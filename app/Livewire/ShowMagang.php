<?php

namespace App\Livewire;

use App\Models\Magang;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowMagang extends Component
{
    use WithPagination;

    public $search;

    public function updating($key): void
    {
        if ($key === 'search') {
            $this->resetPage();
        }
    }

    public function render()
    {
        // Build the base query
        $query = Magang::with('pembimbingPertama', 'pembimbingKedua')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        // Apply search filter if search term is provided
        if ($this->search) {
            $query->where(function (Builder $builder) {
                $builder->where('jenis_magang', 'like', '%' . $this->search . '%')
                    ->orWhere('bidang_tujuan', 'like', '%' . $this->search . '%');
            });
        }

        // Paginate the results
        $magang = $query->paginate(5);

        return view('livewire.show-magang', [
            'magang' => $magang
        ]);
    }
}