<?php

namespace App\Livewire;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class EditFaq extends Component
{
    use WithPagination;

    #[Validate]
    
    public $faqId, $question, $answer;
    public $search = '';
    public $showModal = false;
    public $isEdit = false;
    public $showDeleteModal = false;
    public $deleteId;
    public $deleteQuestion;
    

    public function rules()
    {
        return [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'question' => [
                "required" => 'Pertanyaan tidak boleh kosong',
                "max" => 'Pertanyaan maksimal 255 karakter'
            ],
            'answer' => [
                "required" => 'Jawaban tidak boleh kosong',
            ],
        ];
    }

    public function updating($key): void
    {
        if ($key === 'search') {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = Faq::orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function (Builder $builder) {
                $builder->where('question', 'like', '%' . $this->search . '%');
            });
        }

        $faqs = $query->paginate(5);

        return view('livewire.edit-faq', ['faqs' => $faqs]);
    }


    public function create()
    {
        $this->resetModal();
        $this->isEdit = false;
        $this->showModal = true;
    }


    public function store()
    {
        $this->validate();

        Faq::create([
            'question' => $this->question,
            'answer' => $this->answer,
        ]);
 
        $this->resetModal();

        return redirect('/edit-home?selected=faq')->with([
            'success' => [
                "title" => "FAQ berhasil ditambahkan!",
            ]
        ]);
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $this->faqId = $faq->id;
        $this->question = $faq->question;
        $this->answer = $faq->answer;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $faq = Faq::find($this->faqId);
        $faq->update([
            'question' => $this->question,
            'answer' => $this->answer,
        ]);

        $this->resetModal();

        return redirect('/edit-home?selected=faq')->with([
            'success' => [
                "title" => "FAQ berhasil diperbarui!",
            ]
        ]);
    }

    public function resetModal()
    {
        $this->faqId = null;
        $this->question = '';
        $this->answer = '';
        $this->showModal = false;
        $this->isEdit = false;

        // Reset error bag
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function confirmDelete($id)
    {
        $faq = Faq::find($id);
        $this->deleteId = $id;
        $this->deleteQuestion = $faq->question;
        $this->showDeleteModal = true;
    }

    public function delete()
    {        
        Faq::find($this->deleteId)->delete();
        
        $this->showDeleteModal = false;
        $this->deleteId = null;

        return redirect('/edit-home?selected=faq')->with([
            'success' => [
                "title" => "FAQ berhasil dihapus!",
            ]
        ]);
    }
}
