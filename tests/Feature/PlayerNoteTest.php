<?php

namespace Tests\Feature;

use App\Models\PlayerNote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PlayerNoteTest extends TestCase
{
    use RefreshDatabase;

    private User $player;
    private User $agent;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::firstOrCreate(['name' => 'create-player-note']);

        $this->player = User::factory()->create();
        $this->agent  = User::factory()->create();
        $this->agent->givePermissionTo('create-player-note');
    }

    public function test_agent_can_save_a_note_for_a_player(): void
    {
        $this->actingAs($this->agent);

        Livewire::test('player-notes', ['playerId' => $this->player->id])
            ->set('noteContent', 'This player shows suspicious activity.')
            ->call('saveNote')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('player_notes', [
            'player_id' => $this->player->id,
            'author_id' => $this->agent->id,
            'content'   => 'This player shows suspicious activity.',
        ]);
    }

    public function test_note_content_is_required(): void
    {
        $this->actingAs($this->agent);

        Livewire::test('player-notes', ['playerId' => $this->player->id])
            ->set('noteContent', '')
            ->call('saveNote')
            ->assertHasErrors(['noteContent' => 'required']);
    }

    public function test_note_content_cannot_exceed_max_length(): void
    {
        $this->actingAs($this->agent);

        Livewire::test('player-notes', ['playerId' => $this->player->id])
            ->set('noteContent', str_repeat('a', 1001))
            ->call('saveNote')
            ->assertHasErrors(['noteContent' => 'max']);
    }

    public function test_user_without_permission_cannot_save_note(): void
    {
        $unauthorizedUser = User::factory()->create();
        $this->actingAs($unauthorizedUser);

        Livewire::test('player-notes', ['playerId' => $this->player->id])
            ->set('noteContent', 'Trying to sneak a note.')
            ->call('saveNote')
            ->assertForbidden();

        $this->assertDatabaseMissing('player_notes', [
            'author_id' => $unauthorizedUser->id,
        ]);
    }

    public function test_notes_are_listed_for_a_player(): void
    {
        PlayerNote::factory()->count(3)->create([
            'player_id' => $this->player->id,
            'author_id' => $this->agent->id,
        ]);

        $this->actingAs($this->agent);

        Livewire::test('player-notes', ['playerId' => $this->player->id])
            ->assertViewHas('notes', fn ($notes) => $notes->total() === 3);
    }
}
