<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tarefa;
use Illuminate\Auth\Access\HandlesAuthorization;

class TarefaPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Tarefa $tarefa)
    {
        // Update $user authorization to view $tarefa here.
        return true;
    }

    public function create(User $user, Tarefa $tarefa)
    {
        // Update $user authorization to create $tarefa here.
        return true;
    }

    public function update(User $user, Tarefa $tarefa)
    {
        // Update $user authorization to update $tarefa here.
        return true;
    }

    public function delete(User $user, Tarefa $tarefa)
    {
        // Update $user authorization to delete $tarefa here.
        return true;
    }
}
