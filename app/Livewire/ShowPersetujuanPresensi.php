<?php

namespace App\Livewire;

use App\Models\Presensi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class ShowPersetujuanPresensi extends Component
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
        $presensi = Presensi::with('magang.user')->find($id);

        if ($presensi) {
            $this->originalStatus = $presensi->status;
            $this->selectedData = [
                'id' => $presensi->id,
                'name' => $presensi->magang->user->name,
                'tanggal' => $presensi->tanggal,
                'jenis_magang' => $presensi->magang->jenis_magang,
                'status' => $presensi->status,
                'jam_masuk' => $presensi->jam_masuk,
                'jam_keluar' => $presensi->jam_keluar,
                'foto_masuk' => $presensi->foto_masuk ? 'storage/' . $presensi->foto_masuk : null, // Path ke foto_masuk
                'foto_keluar' => $presensi->foto_keluar ? 'storage/' . $presensi->foto_keluar : null, // Path ke foto_keluar
                'keterangan_izin' => $presensi->keterangan_izin,
                'updated_at' => $presensi->updated_at,
            ];
            $this->showModal = true;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedData = [];
    }

    public function approvePresensi()
    {
        if (isset($this->selectedData['id'])) {
            $presensi = Presensi::find($this->selectedData['id']);
            if ($presensi) {
                // Data yang akan diupdate
                $updateData = [
                    'pembimbing_id' => Auth::guard('pegawai')->user()->id,
                ];

                // Jika status berubah
                if ($this->selectedData['status'] !== $this->originalStatus) {
                    $updateData['status'] = $this->selectedData['status'];

                    // Logika perubahan status
                    if ($this->originalStatus === 'hadir') {
                        if ($this->selectedData['status'] === 'izin') {
                            // hadir -> izin
                            $updateData['jam_masuk'] = null;
                            $updateData['jam_keluar'] = null;
                            $updateData['foto_masuk'] = null;
                            $updateData['foto_keluar'] = null;
                            $updateData['status'] = 'izin';
                        } elseif ($this->selectedData['status'] === 'tidak-hadir') {
                            // hadir -> tidak-hadir
                            $updateData['jam_masuk'] = null;
                            $updateData['jam_keluar'] = null;
                            $updateData['foto_masuk'] = null;
                            $updateData['foto_keluar'] = null;
                            $updateData['status'] = 'tidak-hadir';
                        }
                    } elseif ($this->originalStatus === 'izin') {
                        if ($this->selectedData['status'] === 'hadir') {
                            // izin -> hadir
                            $updateData['jam_masuk'] = Carbon::parse($this->selectedData['updated_at'])->format('H:i:s'); 
                            $updateData['jam_keluar'] = '16:00:00'; // Jam keluar tetap 16.00
                            $updateData['status'] = 'hadir';
                        } elseif ($this->selectedData['status'] === 'tidak-hadir') {
                            // izin -> tidak-hadir
                            $updateData['status'] = 'tidak-hadir';
                        }
                    } elseif ($this->originalStatus === 'tidak-hadir') {
                        if ($this->selectedData['status'] === 'hadir') {
                            // tidak-hadir -> hadir
                            $updateData['jam_masuk'] = Carbon::parse($this->selectedData['updated_at'])->format('H:i:s'); 
                            $updateData['jam_keluar'] = '16:00:00'; // Jam keluar tetap 16.00
                            $updateData['status'] = 'hadir';
                        } elseif ($this->selectedData['status'] === 'izin') {
                            // tidak-hadir -> izin
                            $updateData['status'] = 'izin';
                        }
                    }
                }

                // Update data
                $presensi->update($updateData);
                
                $this->closeModal();
                $this->dispatch('refreshComponent');
                
                return redirect('/daftar-persetujuan')->with([
                    'success' => [
                        "title" => "Berhasil menyetujui dokumen!",
                    ]
                ]);
            }
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
            // If select all is checked, get all presensi IDs for the current query
            $userId = Auth::guard('pegawai')->user()->id;
            
            $query = Presensi::with('magang')
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
        
        $query = Presensi::with('magang')
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
            Presensi::whereIn('id', $this->selectedItems)->update([
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

        $query = Presensi::with('magang')
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

        $presensi = $query->paginate(5);

        return view('livewire.show-persetujuan-presensi', [
            'presensi' => $presensi
        ]);
    }
}