<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PlayerNoteSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar tablas relacionadas
        User::query()->delete();

        // Crear permisos
        $permission = Permission::firstOrCreate(['name' => 'create-player-note']);

        // Crear roles
        $agentRole = Role::firstOrCreate(['name' => 'support-agent']);
        $playerRole = Role::firstOrCreate(['name' => 'jugador']);

        // Asignar permiso al rol support-agent
        $agentRole->givePermissionTo($permission);

        // Crear usuario agente
        $agent = User::create([
            'name' => 'Agente Promarketing',
            'email' => 'agent@promarketing.com',
            'password' => Hash::make('123456'),
        ]);
        $agent->assignRole('support-agent');

        // Crear jugadores
        $players = [
            ['name' => 'Carlos Mendoza', 'email' => 'carlos@promarketing.com'],
            ['name' => 'Laura Jimenez', 'email' => 'laura@promarketing.com'],
            ['name' => 'Diego Ramirez', 'email' => 'diego@promarketing.com'],
        ];

        foreach ($players as $playerData) {
            $player = User::create([
                'name' => $playerData['name'],
                'email' => $playerData['email'],
                'password' => Hash::make('123456'),
            ]);
            $player->assignRole('jugador');
        }
    }
}
