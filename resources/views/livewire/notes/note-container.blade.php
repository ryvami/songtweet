<?php

use Livewire\Volt\Component;
use App\Models\Note;

new class extends Component {
    public function delete($noteId)
    {
        $note = Note::where('id', $noteId)->first();
        $this->authorize('delete', $note);
        $note->delete();
    }
    public function with(): array
    {
        return [
            'notes' => Auth::user()
                ->note()
                ->orderBy('send_date', 'asc')
                ->get(),
        ];
    }
}; ?>

<div>
    <div class="space-y-2">
    @if ($notes->isEmpty())
       <div class="text-center">
            <p class="text-xl font-bold">No notes!</p>
            <p class="text-sm">Do you want to create a new note?</p>
            <x-button primary right-icon="plus" class="mt-6" href="{{ route('notes.create') }}" wire:navigate>Note</x-button>
       </div> 
    @else
    <x-button primary right-icon="plus" class="mt-6" href="{{ route('notes.create') }}" wire:navigate>Note</x-button>
    <div class="grid grid-cols-3 gap-4 mt-12">
        @foreach ($notes as $note)
            <x-card wire:key='{{ $note->id }}'>
            <div class="flex justify-between">
                <div>
                    <a href='{{ route('notes.edit', $note) }}' 
                    wire:navigate 
                    class='text-xl font-bold hover:underline hover:text-blue-500'>{{ $note->title }}</a>
                    <p>{{ Str::limit($note->body, 30) }}</p>
                </div>
                <div class='text-xs text-gray-400'>{{\Carbon\Carbon::parse($note->send_date)->format('M-d-y')}}</div>
            </div>
            <div class="flex items-end justify-between mt-4 space-x-1">
                <p class="text-xs">Recipient: <span class="font-semibold">{{ $note->recipient }}</span></p> 
                <div>
                <x-button.circle icon="eye"></x-button.circle>
                <x-button.circle icon="trash" wire:click="delete('{{ $note->id }}')"></x-button.circle>
                </div>
            </div>
            </x-card>
        @endforeach
        </div>
    @endif
    </div>
</div>
