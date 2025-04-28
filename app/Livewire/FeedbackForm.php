<?php

namespace App\Livewire;

use App\Models\Feedback;
use Livewire\Attributes\Validate;
use Livewire\Component;

class FeedbackForm extends Component
{
    #[Validate]
    public $magang_id;
    public $testimoni;
    public $kritik;
    public $saran;
    
    // Aplikasi Feedback
    public $aplikasi_daya_tarik;
    public $aplikasi_kemudahan;
    public $aplikasi_efisiensi;
    public $aplikasi_keandalan;
    public $aplikasi_stimulasi;
    public $aplikasi_originalitas;
    
    // Magang Feedback
    public $magang_fasilitas;
    public $magang_metode;
    public $magang_materi;
    public $magang_pembimbing;
    public $magang_relevansi;
    public $magang_kepuasan;

    public function rules()
    {
        return [
            'testimoni' => 'required|string|max:1000',
            'kritik' => 'required|string|max:1000',
            'saran' => 'required|string|max:1000',
            
            // Validasi untuk rating 1-5
            'aplikasi_daya_tarik' => 'required|integer|between:1,5',
            'aplikasi_kemudahan' => 'required|integer|between:1,5',
            'aplikasi_efisiensi' => 'required|integer|between:1,5',
            'aplikasi_keandalan' => 'required|integer|between:1,5',
            'aplikasi_stimulasi' => 'required|integer|between:1,5',
            'aplikasi_originalitas' => 'required|integer|between:1,5',
            
            'magang_fasilitas' => 'required|integer|between:1,5',
            'magang_metode' => 'required|integer|between:1,5',
            'magang_materi' => 'required|integer|between:1,5',
            'magang_pembimbing' => 'required|integer|between:1,5',
            'magang_relevansi' => 'required|integer|between:1,5',
            'magang_kepuasan' => 'required|integer|between:1,5',
        ];
    }
    
    public function messages(){
        return [
            'testimoni' => [
                'required' => 'Testimoni harus diisi.',
                'max' => 'Testimoni tidak boleh lebih dari 1000 karakter.',
            ],
            'kritik' => [
                'required' => 'Kritik harus diisi.',
                'max' => 'Kritik tidak boleh lebih dari 1000 karakter.',
            ],
            'saran' => [
                'required' => 'Saran harus diisi.',
                'max' => 'Saran tidak boleh lebih dari 1000 karakter.',
            ],
            'aplikasi_daya_tarik' => [
                'required' => 'Rating Aplikasi Daya Tarik harus diisi.',
            ],
            'aplikasi_kemudahan' => [
                'required' => 'Rating Aplikasi Kemudahan harus diisi.',
            ],
            'aplikasi_efisiensi' => [
                'required' => 'Rating Aplikasi Efisiensi harus diisi.',
            ],
            'aplikasi_keandalan' => [
                'required' => 'Rating Aplikasi Keandalan harus diisi.',
            ],
            'aplikasi_stimulasi' => [
                'required' => 'Rating Aplikasi Stimulasi harus diisi.',
            ],
            'aplikasi_originalitas' => [
                'required' => 'Rating Aplikasi Originalitas harus diisi.',
            ],
            'magang_fasilitas' => [
                'required' => 'Rating Magang Fasilitas harus diisi.',
            ],
            'magang_metode' => [
                'required' => 'Rating Magang Metode harus diisi.',
            ],
            'magang_materi' => [
                'required' => 'Rating Magang Materi harus diisi.',
            ],
            'magang_pembimbing' => [
                'required' => 'Rating Magang Pembimbing harus diisi.',
            ],
            'magang_relevansi' => [
                'required' => 'Rating Magang Relevansi harus diisi.',
            ],
            'magang_kepuasan' => [
                'required' => 'Rating Magang Kepuasan harus diisi.',
            ]
        ];
    } 
    
    public function mount($magangId)
    {
        $this->magang_id = $magangId;
    }

    public function submit()
    {
        $this->validate();
        
        Feedback::updateOrCreate(
            ['magang_id' => $this->magang_id],
            $this->all()
        );
        
        return redirect('/dashboard')->with([
            'success' => [
                "title" => "Feedback berhasil dikirim!",
            ]
        ]);
    }
    
    // Helper untuk emoticon
    public function getEmoticon($rating)
    {
        $emoticons = [
            1 => '😡', // Sangat Buruk
            2 => '😞', // Buruk
            3 => '😐', // Biasa
            4 => '😊', // Baik
            5 => '😍', // Sangat Baik
        ];
        
        return $emoticons[$rating] ?? '';
    }
    
    public function render()
    {
        return view('livewire.feedback-form');
    }
}
