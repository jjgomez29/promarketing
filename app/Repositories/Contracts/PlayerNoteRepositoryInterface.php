<?php

namespace App\Repositories\Contracts;

use App\Models\PlayerNote;
use Illuminate\Pagination\LengthAwarePaginator;

interface PlayerNoteRepositoryInterface
{
    public function getAll(int $perPage = 10): LengthAwarePaginator;

    public function getByPlayer(int $playerId, int $perPage = 15): LengthAwarePaginator;

    public function create(int $playerId, int $authorId, string $content): PlayerNote;

    public function delete(int $noteId): bool;
}
