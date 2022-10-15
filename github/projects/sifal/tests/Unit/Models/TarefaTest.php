<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Tarefa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\BrowserKitTest as TestCase;

class TarefaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_tarefa_has_title_link_attribute()
    {
        $tarefa = Tarefa::factory()->create();

        $title = __('app.show_detail_title', [
            'title' => $tarefa->title, 'type' => __('tarefa.tarefa'),
        ]);
        $link = '<a href="'.route('tarefas.show', $tarefa).'"';
        $link .= ' title="'.$title.'">';
        $link .= $tarefa->title;
        $link .= '</a>';

        $this->assertEquals($link, $tarefa->title_link);
    }

    /** @test */
    public function a_tarefa_has_belongs_to_creator_relation()
    {
        $tarefa = Tarefa::factory()->make();

        $this->assertInstanceOf(User::class, $tarefa->creator);
        $this->assertEquals($tarefa->creator_id, $tarefa->creator->id);
    }
}
