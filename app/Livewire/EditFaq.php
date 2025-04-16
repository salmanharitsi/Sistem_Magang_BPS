<?php

namespace App\Livewire;

use App\Models\Faq;
use Livewire\Component;

class EditFaq extends Component
{

    public $search = '';
    public $faqId, $question, $answer;
    public $showModal = false;
    public $isEdit = false;

    protected $rules = [
        'question' => 'required|string|max:255',
        'answer' => 'required|string',
    ];

    public function render()
    {
        $faqs = Faq::where('question', 'like', '%' . $this->search . '%')->get();
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

        session()->flash('message', 'FAQ berhasil ditambahkan.');
        $this->resetModal();
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

        session()->flash('message', 'FAQ berhasil diperbarui.');
        $this->resetModal();
    }

    public function resetModal()
    {
        $this->faqId = null;
        $this->question = '';
        $this->answer = '';
        $this->showModal = false;
        $this->isEdit = false;
    }
}
