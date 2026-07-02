<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\PlayerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PlayerRepository implements PlayerRepositoryInterface
{
    public function __construct(private readonly User $model) {}

    public function getAllPlayers(): Collection
    {
        return $this->model
            ->whereHas('roles', fn ($query) => $query->where('name', 'jugador'))
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'created_at']);
    }
}
