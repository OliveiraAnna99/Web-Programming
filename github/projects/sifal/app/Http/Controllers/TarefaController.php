<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;

class TarefaController extends Controller
{
    public function index(Request $request)
    {
        $tarefaQuery = Tarefa::query();
        $tarefaQuery->where('title', 'like', '%'.$request->get('q').'%');
        $tarefaQuery->orderBy('title');
        $tarefas = $tarefaQuery->paginate(25);

        return view('tarefas.index', compact('tarefas'));
    }

    public function create()
    {
        $this->authorize('create', new Tarefa);

        return view('tarefas.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', new Tarefa);

        $newTarefa = $request->validate([
            'title'       => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $newTarefa['creator_id'] = auth()->id();

        $tarefa = Tarefa::create($newTarefa);

        return redirect()->route('tarefas.show', $tarefa);
    }

    public function show(Tarefa $tarefa)
    {
        return view('tarefas.show', compact('tarefa'));
    }

    public function edit(Tarefa $tarefa)
    {
        $this->authorize('update', $tarefa);

        return view('tarefas.edit', compact('tarefa'));
    }

    public function update(Request $request, Tarefa $tarefa)
    {
        $this->authorize('update', $tarefa);

        $tarefaData = $request->validate([
            'title'       => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);
        $tarefa->update($tarefaData);

        return redirect()->route('tarefas.show', $tarefa);
    }

    public function destroy(Request $request, Tarefa $tarefa)
    {
        $this->authorize('delete', $tarefa);

        $request->validate(['tarefa_id' => 'required']);

        if ($request->get('tarefa_id') == $tarefa->id && $tarefa->delete()) {
            return redirect()->route('tarefas.index');
        }

        return back();
    }
}
