<?php

namespace Tests\Unit\Policies;

use App\Models\Tarefa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class TarefaPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_tarefa()
    {
        $user = $this->createUser();
        $this->assertTrue($user->can('create', new Tarefa));
    }

    /** @test */
    public function user_can_view_tarefa()
    {
        $user = $this->createUser();
        $tarefa = Tarefa::factory()->create();
        $this->assertTrue($user->can('view', $tarefa));
    }

    /** @test */
    public function user_can_update_tarefa()
    {
        $user = $this->createUser();
        $tarefa = Tarefa::factory()->create();
        $this->assertTrue($user->can('update', $tarefa));
    }

    /** @test */
    public function user_can_delete_tarefa()
    {
        $user = $this->createUser();
        $tarefa = Tarefa::factory()->create();
        $this->assertTrue($user->can('delete', $tarefa));
    }
}
