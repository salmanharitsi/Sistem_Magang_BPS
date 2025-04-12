<?php

namespace App\Livewire;

use App\Models\Logbook;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPersetujuanLogbook extends Component
{

    use WithPagination;

    public $search;
    public $statusFilter = '';
    public $selectAll = false;
    public $selectedItems = [];
    public $showModal = false;
    public $selectedData = [];
    public $originalStatus = '';


    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        Carbon::setLocale('id');
    }

    public function showDetail($id)
    {
        $logbook = Logbook::with('magang.user')->find($id);

        if ($logbook) {
            $this->originalStatus = $logbook->status;
            $this->selectedData = [
                'id' => $logbook->id,
                'nama' => $logbook->magang->user->name,
                'jenis_magang' => $logbook->magang->jenis_magang,
                'tanggal' => $logbook->tanggal,
                'deskripsi' => $logbook->deskripsi,
                'lampiran' => $logbook->lampiran,
                'status' => $logbook->status,
                'komentar' => $logbook->komentar,
                'updated_at' => $logbook->updated_at,
            ];
            $this->showModal = true;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedData = [];
    }

    public function approveLogbook()
    {
        if (isset($this->selectedData['id'])) {

            Logbook::where('id', $this->selectedData['id'])->update([
                'pembimbing_id' => Auth::guard('pegawai')->user()->id,
                'status' => $this->selectedData['status'],
                'komentar' => $this->selectedData['komentar']
            ]);

            $this->closeModal();
            $this->dispatch('refreshComponent');

            return redirect('/daftar-persetujuan')->with([
                'success' => [
                    "title" => "Berhasil menyetujui dokumen!",
                ]
            ]);
        }
    }

    public function updating($key): void
    {
        if (in_array($key, ['search', 'statusFilter'])) {
            $this->resetPage();
        }
    }

    public function updatedStatusFilter()
    {
        // Reset selections when filter changes
        $this->selectedItems = [];
        $this->selectAll = false;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // If select all is checked, get all logbook IDs for the current query
            $userId = Auth::guard('pegawai')->user()->id;

            $query = Logbook::with('magang')
                ->whereHas('magang', function ($query) use ($userId) {
                    $query->where('pembimbing_pertama', $userId)
                        ->orWhere('pembimbing_kedua', $userId);
                })
                ->whereNull('pembimbing_id')
                ->where('status', '!=', 'waiting');

            // Apply search filter
            if ($this->search) {
                $query->where(function (Builder $builder) {
                    $builder->where('status', 'like', '%' . $this->search . '%')
                        ->orWhereHas('magang', function (Builder $query) {
                            $query->where('jenis_magang', 'like', '%' . $this->search . '%')
                            ->orWhereHas('user', function (Builder $query) {
                                $query->where('name', 'like', '%' . $this->search . '%');
                            });
                        });
                });
            }

            // Apply status filter
            if ($this->statusFilter) {
                $query->where('status', $this->statusFilter);
            }

            $this->selectedItems = $query->pluck('id')->map(function ($id) {
                return (string) $id;
            })->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function updatedSelectedItems()
    {
        // Check if all items are selected
        $userId = Auth::guard('pegawai')->user()->id;

        $query = Logbook::with('magang')
            ->whereHas('magang', function ($query) use ($userId) {
                $query->where('pembimbing_pertama', $userId)
                    ->orWhere('pembimbing_kedua', $userId);
            })
            ->whereNull('pembimbing_id')
            ->where('status', '!=', 'waiting');

        // Apply search filter
        if ($this->search) {
            $query->where(function (Builder $builder) {
                $builder->where('status', 'like', '%' . $this->search . '%')
                    ->orWhereHas('magang', function (Builder $query) {
                        $query->where('jenis_magang', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function (Builder $query) {
                            $query->where('name', 'like', '%' . $this->search . '%');
                        });
                    });
            });
        }

        // Apply status filter
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $totalItems = $query->count();
        $this->selectAll = count($this->selectedItems) === $totalItems && $totalItems > 0;
    }

    public function bulkAction()
    {
        if (count($this->selectedItems) > 0) {
            // Get the current authenticated user ID from pegawai guard
            $userId = Auth::guard('pegawai')->user()->id;

            // Update multiple records at once
            Logbook::whereIn('id', $this->selectedItems)->update([
                'pembimbing_id' => $userId
            ]);

            // Get the count before resetting
            $updatedCount = count($this->selectedItems);

            // Reset selections after action
            $this->selectedItems = [];
            $this->selectAll = false;

            // Refresh the component
            $this->dispatch('refreshComponent');

            return redirect('/daftar-persetujuan')->with([
                'success' => [
                    "title" => "Berhasil menyetujui $updatedCount dokumen!",
                ]
            ]);
        }
    }

    public function render()
    {

        $userId = Auth::guard('pegawai')->user()->id;


        $query = Logbook::with('magang')
            ->whereHas('magang', function ($query) use ($userId) {
                $query->where('pembimbing_pertama', $userId)
                    ->orWhere('pembimbing_kedua', $userId);
            })
            ->whereNull('pembimbing_id')
            ->where('status', '!=', 'waiting')
            ->where('tanggal', '<', Carbon::today())
            ->orderBy('updated_at', 'desc');

        // Apply search filter if search term is provided
        if ($this->search) {
            $query->where(function (Builder $builder) {
                $builder->where('status', 'like', '%' . $this->search . '%')
                    ->orWhereHas('magang', function (Builder $query) {
                        $query->where('jenis_magang', 'like', '%' . $this->search . '%')
                            ->orWhereHas('user', function (Builder $query) {
                                $query->where('name', 'like', '%' . $this->search . '%');
                            });
                    });
            });
        }

        // Apply status filter if selected
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $logbook = $query->paginate(5);


        return view('livewire.show-persetujuan-logbook', [
            'logbook' => $logbook
        ]);
    }
}
