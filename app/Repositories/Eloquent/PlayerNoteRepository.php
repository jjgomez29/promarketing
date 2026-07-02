<?php

namespace App\Repositories\Eloquent;

use App\Models\PlayerNote;
use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PlayerNoteRepository implements PlayerNoteRepositoryInterface
{
    public function __construct(private readonly PlayerNote $model) {}

    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->with(['author:id,name', 'player:id,name'])
            ->latest()
            ->paginate($perPage);
    }

    public function getByPlayer(int $playerId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with('author:id,name')
            ->where('player_id', $playerId)
            ->latest()
            ->paginate($perPage);
    }

    public function create(int $playerId, int $authorId, string $content): PlayerNote
    {
        return $this->model->create([
            'player_id' => $playerId,
            'author_id' => $authorId,
            'content'   => $content,
        ]);
    }

    public function delete(int $noteId): bool
    {
        return $this->model->where('id', $noteId)->delete() > 0;
    }
}
