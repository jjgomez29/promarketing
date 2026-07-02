<?php

use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use App\Repositories\Contracts\PlayerRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $selectedPlayerId = '';
    public string $noteContent = '';
    public ?int $noteToDelete = null;
    public bool $showDeleteModal = false;

    public function saveNote(PlayerNoteRepositoryInterface $noteRepository): void
    {
        $this->authorize('create-player-note');

        $validated = $this->validate([
            'selectedPlayerId' => 'required|integer|exists:users,id',
            'noteContent' => 'required|string|max:1000',
        ], [
            'selectedPlayerId.required' => 'Debes seleccionar un jugador.',
            'selectedPlayerId.integer' => 'Debes seleccionar un jugador.',
            'selectedPlayerId.exists' => 'El jugador seleccionado no existe.',
            'noteContent.required' => 'El contenido de la nota es obligatorio.',
            'noteContent.max' => 'La nota no puede exceder 1000 caracteres.',
        ]);

        $noteRepository->create(
            playerId: (int) $this->selectedPlayerId,
            authorId: auth()->id(),
            content:  $this->noteContent,
        );

        $this->reset(['selectedPlayerId', 'noteContent']);
        $this->resetValidation();
        $this->resetPage();

        $this->js('document.getElementById("noteContent").value = ""');
        $this->js('document.getElementById("player").value = ""');
    }

    public function confirmDelete(int $noteId): void
    {
        $this->noteToDelete = $noteId;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->noteToDelete = null;
        $this->showDeleteModal = false;
    }

    public function deleteNote(PlayerNoteRepositoryInterface $noteRepository): void
    {
        $this->authorize('create-player-note');

        if ($this->noteToDelete) {
            $noteRepository->delete($this->noteToDelete);
        }

        $this->noteToDelete = null;
        $this->showDeleteModal = false;
    }

    public function render(
        PlayerRepositoryInterface $playerRepository,
        PlayerNoteRepositoryInterface $noteRepository,
    ): \Illuminate\View\View {
        $players = $playerRepository->getAllPlayers();
        $notes = $noteRepository->getAll();

        return view('livewire.player-notes-dashboard', compact('players', 'notes'));
    }
};
?>