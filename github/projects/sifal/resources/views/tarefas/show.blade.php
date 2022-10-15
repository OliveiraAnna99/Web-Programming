@extends('layouts.app')

@section('title', __('tarefa.detail'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('tarefa.detail') }}</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>{{ __('tarefa.title') }}</td><td>{{ $tarefa->title }}</td></tr>
                        <tr><td>{{ __('tarefa.description') }}</td><td>{{ $tarefa->description }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $tarefa)
                    <a href="{{ route('tarefas.edit', $tarefa) }}" id="edit-tarefa-{{ $tarefa->id }}" class="btn btn-warning">{{ __('tarefa.edit') }}</a>
                @endcan
                <a href="{{ route('tarefas.index') }}" class="btn btn-link">{{ __('tarefa.back_to_index') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
