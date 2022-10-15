<?php

namespace Tests\Feature;

use App\Models\Tarefa;
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageTarefaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_tarefa_list_in_tarefa_index_page()
    {
        $tarefa = Tarefa::factory()->create();

        $this->loginAsUser();
        $this->visitRoute('tarefas.index');
        $this->see($tarefa->title);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'title'       => 'Tarefa 1 title',
            'description' => 'Tarefa 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_create_a_tarefa()
    {
        $this->loginAsUser();
        $this->visitRoute('tarefas.index');

        $this->click(__('tarefa.create'));
        $this->seeRouteIs('tarefas.create');

        $this->submitForm(__('app.create'), $this->getCreateFields());

        $this->seeRouteIs('tarefas.show', Tarefa::first());

        $this->seeInDatabase('tarefas', $this->getCreateFields());
    }

    /** @test */
    public function validate_tarefa_title_is_required()
    {
        $this->loginAsUser();

        // title empty
        $this->post(route('tarefas.store'), $this->getCreateFields(['title' => '']));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_tarefa_title_is_not_more_than_60_characters()
    {
        $this->loginAsUser();

        // title 70 characters
        $this->post(route('tarefas.store'), $this->getCreateFields([
            'title' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_tarefa_description_is_not_more_than_255_characters()
    {
        $this->loginAsUser();

        // description 256 characters
        $this->post(route('tarefas.store'), $this->getCreateFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'title'       => 'Tarefa 1 title',
            'description' => 'Tarefa 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_edit_a_tarefa()
    {
        $this->loginAsUser();
        $tarefa = Tarefa::factory()->create(['title' => 'Testing 123']);

        $this->visitRoute('tarefas.show', $tarefa);
        $this->click('edit-tarefa-'.$tarefa->id);
        $this->seeRouteIs('tarefas.edit', $tarefa);

        $this->submitForm(__('tarefa.update'), $this->getEditFields());

        $this->seeRouteIs('tarefas.show', $tarefa);

        $this->seeInDatabase('tarefas', $this->getEditFields([
            'id' => $tarefa->id,
        ]));
    }

    /** @test */
    public function validate_tarefa_title_update_is_required()
    {
        $this->loginAsUser();
        $tarefa = Tarefa::factory()->create(['title' => 'Testing 123']);

        // title empty
        $this->patch(route('tarefas.update', $tarefa), $this->getEditFields(['title' => '']));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_tarefa_title_update_is_not_more_than_60_characters()
    {
        $this->loginAsUser();
        $tarefa = Tarefa::factory()->create(['title' => 'Testing 123']);

        // title 70 characters
        $this->patch(route('tarefas.update', $tarefa), $this->getEditFields([
            'title' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('title');
    }

    /** @test */
    public function validate_tarefa_description_update_is_not_more_than_255_characters()
    {
        $this->loginAsUser();
        $tarefa = Tarefa::factory()->create(['title' => 'Testing 123']);

        // description 256 characters
        $this->patch(route('tarefas.update', $tarefa), $this->getEditFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_delete_a_tarefa()
    {
        $this->loginAsUser();
        $tarefa = Tarefa::factory()->create();
        Tarefa::factory()->create();

        $this->visitRoute('tarefas.edit', $tarefa);
        $this->click('del-tarefa-'.$tarefa->id);
        $this->seeRouteIs('tarefas.edit', [$tarefa, 'action' => 'delete']);

        $this->press(__('app.delete_confirm_button'));

        $this->dontSeeInDatabase('tarefas', [
            'id' => $tarefa->id,
        ]);
    }
}
