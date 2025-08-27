<?php

namespace App\Livewire;

use App\Models\Institusi;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class KelolaInstitusiSekolah extends Component
{
    use WithPagination;

    public $search = "";
    public $searchApproved = "";
    public $activeTab = 'approved'; // approved, pending
    public $showModal = false;
    public $selectedInstitusi = null;

    public function updating($key): void
    {
        if ($key === 'search' || $key === 'searchApproved') {
            $this->resetPage();
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->search = "";
        $this->searchApproved = "";
        $this->resetPage();
    }

    public function openModal($id)
    {
        $this->selectedInstitusi = Institusi::find($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedInstitusi = null;
    }

    public function approveInstitusi($id)
    {
        $institusi = Institusi::find($id);
        if ($institusi) {
            $institusi->update(['status' => 'approved']);
            $this->closeModal();
            
            return redirect()->to(request()->header('Referer'))->with([
                'success' => [
                    "title" => "Institusi berhasil disetujui!",
                ]
            ]);
        }
    }

    public function rejectInstitusi($id)
    {
        $institusi = Institusi::find($id);
        if ($institusi) {
            $institusi->update(['status' => 'rejected']);
            $this->closeModal();
            
            return redirect()->to(request()->header('Referer'))->with([
                'success' => [
                    "title" => "Institusi berhasil ditolak!",
                ]
            ]);
        }
    }

    public function render()
    {
        if ($this->activeTab === 'approved') {
            // Query untuk institusi yang sudah diverifikasi (approved)
            $approvedQuery = Institusi::where('status', 'approved')
                ->orderBy('created_at', 'desc');

            if ($this->search) {
                $approvedQuery->where(function (Builder $builder) {
                    $builder->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('alamat', 'like', '%' . $this->search . '%');
                });
            }

            $approvedInstitusi = $approvedQuery->paginate(5);
            
            // Untuk tab pending, hanya ambil count
            $pendingInstitusi = Institusi::where('status', 'pending')->paginate(1);
            
        } else {
            // Query untuk institusi yang perlu review (pending)
            $pendingQuery = Institusi::where('status', 'pending')
                ->orderBy('created_at', 'desc');

            if ($this->searchApproved) {
                $pendingQuery->where(function (Builder $builder) {
                    $builder->where('nama', 'like', '%' . $this->searchApproved . '%')
                        ->orWhere('alamat', 'like', '%' . $this->searchApproved . '%');
                });
            }

            $pendingInstitusi = $pendingQuery->paginate(5);
            
            // Untuk tab approved, hanya ambil count
            $approvedInstitusi = Institusi::where('status', 'approved')->paginate(1);
        }

        return view('livewire.kelola-institusi-sekolah', [
            'approvedInstitusi' => $approvedInstitusi,
            'pendingInstitusi' => $pendingInstitusi
        ]);
    }
}