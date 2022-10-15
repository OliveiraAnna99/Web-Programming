@extends('layouts.app')

@section('title', __('tarefa.list'))

@section('content')
<div class="mb-3">
    <div class="float-right">
        @can('create', new App\Models\Tarefa)
            <a href="{{ route('tarefas.create') }}" class="btn btn-success">{{ __('tarefa.create') }}</a>
        @endcan
    </div>
    <h1 class="page-title">{{ __('tarefa.list') }} <small>{{ __('app.total') }} : {{ $tarefas->total() }} {{ __('tarefa.tarefa') }}</small></h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                    <div class="form-group">
                        <label for="q" class="form-label">{{ __('tarefa.search') }}</label>
                        <input placeholder="{{ __('tarefa.search_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                    </div>
                    <input type="submit" value="{{ __('tarefa.search') }}" class="btn btn-secondary">
                    <a href="{{ route('tarefas.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                </form>
            </div>
            <table class="table table-sm table-responsive-sm table-hover">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('tarefa.title') }}</th>
                        <th>{{ __('tarefa.description') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tarefas as $key => $tarefa)
                    <tr>
                        <td class="text-center">{{ $tarefas->firstItem() + $key }}</td>
                        <td>{!! $tarefa->title_link !!}</td>
                        <td>{{ $tarefa->description }}</td>
                        <td class="text-center">
                            @can('view', $tarefa)
                                <a href="{{ route('tarefas.show', $tarefa) }}" id="show-tarefa-{{ $tarefa->id }}">{{ __('app.show') }}</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $tarefas->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
@endsection
