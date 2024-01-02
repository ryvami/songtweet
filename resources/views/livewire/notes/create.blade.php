<?php

use Livewire\Volt\Component;

new class extends Component {
    public $noteTitle;
    public $noteBody;
    public $songUrl;
    public $noteRecipient;
    public $noteSendDate;

    protected $rules = [
        'noteTitle' => 'required|min:5',
        'noteBody' => 'required|min:20',
        'songUrl' => 'required',
        'noteRecipient' => 'required|email',
        'noteSendDate' => 'required|date'
    ];

    public function submit()
    {
        $this->validate();

        auth()->user()->note()->create([
            'title' => $this->noteTitle,
            'body' => $this->noteBody,
            'song_url' => $this->songUrl,
            'recipient' => $this->noteRecipient,
            'send_date' => $this->noteSendDate,
            'is_published' => false
        ]);
        redirect(route('notes.index'));
    }


}; ?>

<div>
    <form wire:submit='submit' class="space-y-3">
        <x-input wire:model='noteTitle' label='Title' />
        <x-input wire:model='songUrl' label='Song Url' />
        <x-textarea wire:model='noteBody' label='Body' />
        <x-input wire:model='noteRecipient' label='Recipient' />
        <x-input icon="" class="mb-6" wire:model='noteSendDate' label='Send Date' type='date'/>
        <div class="">
            <x-button icon="plus" wire:click='submit' primary>Submit</x-button>
        </div>
    </form>
</div>
