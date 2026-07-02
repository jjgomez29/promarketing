<?php

use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public int $playerId;

    #[Validate('required|string|max:1000')]
    public string $noteContent = '';

    public function mount(int $playerId): void
    {
        $this->playerId = $playerId;
    }

    public function saveNote(PlayerNoteRepositoryInterface $repository): void
    {
        $this->authorize('create-player-note');

        $this->validate();

        $repository->create(
            playerId: $this->playerId,
            authorId: auth()->id(),
            content:  $this->noteContent,
        );

        $this->reset('noteContent');
        $this->resetPage();
        $this->dispatch('note-saved');
    }

    public function render(PlayerNoteRepositoryInterface $repository): \Illuminate\View\View
    {
        $notes = $repository->getByPlayer($this->playerId);

        return view('livewire.player-notes', ['notes' => $notes]);
    }
};
?>