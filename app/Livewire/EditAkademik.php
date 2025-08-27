<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Institusi;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class EditAkademik extends Component
{
    #[Validate]

    public $nomor_induk,
    $institusi_id,
    $jurusan;

    public function mount()
    {
        $user = Auth::user();
        $this->institusi_id = $user->institusi_id;
        $this->jurusan = $user->jurusan;
        $this->nomor_induk = $user->nomor_induk;
    }

    public function rules()
    {
        return [
            'nomor_induk' => 'required|min:5|unique:users,nomor_induk,' . Auth::id(),
            'institusi_id' => 'required|exists:institusi,id',
            'jurusan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nomor_induk' => [
                "required" => 'Nomor induk tidak boleh kosong',
                "min" => 'Nomor induk minimal 5 karakter',
                "unique" => 'Nomor induk ini sudah terdaftar',
            ],
            'institusi_id' => [
                "required" => 'Institusi tidak boleh kosong',
                "exists" => 'Institusi tidak valid',
            ],
            'jurusan' => [
                "required" => 'Jurusan tidak boleh kosong',
            ]
        ];
    }

    public function update_akademik()
    {
        $user = Auth::user();

        // Cek jika data tidak berubah
        $isDataChanged =
            $user->institusi_id !== $this->institusi_id ||
            $user->jurusan !== ucwords(strtolower(trim($this->jurusan))) ||
            $user->nomor_induk !== $this->nomor_induk;

        if (!$isDataChanged) {
            return redirect('/profil-edit?selected=akademik')->with([
                'warning' => [
                    "title" => "Tidak ada perubahan data"
                ]
            ]);
        }

        // Build dynamic validation rules
        $rules = [
            'institusi_id' => 'required|exists:institusi,id',
            'jurusan' => 'required',
        ];

        // Add unique rule for nomor_induk if it has changed
        if ($user->nomor_induk !== $this->nomor_induk) {
            $rules['nomor_induk'] = 'required|min:5|unique:users,nomor_induk';
        } else {
            $rules['nomor_induk'] = 'required|min:5';
        }

        // Validate data input
        $validatedData = $this->validate($rules);

        // Update user data with validated data
        $user->institusi_id = $validatedData['institusi_id'];
        $user->jurusan = ucwords(strtolower(trim($validatedData['jurusan'])));
        $user->nomor_induk = $validatedData['nomor_induk'];
        $user->save();

        return redirect('/profil')->with([
            'success' => [
                "title" => "Data Berhasil diperbarui"
            ]
        ]);
    }

    public function render()
    {
        return view('livewire.edit-akademik', [
            'institusiList' => Institusi::where('status', 'approved')->orderBy('nama')->get()
        ]);
    }
}