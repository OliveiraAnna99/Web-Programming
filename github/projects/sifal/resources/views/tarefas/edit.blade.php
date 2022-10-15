@extends('layouts.app')

@section('title', __('tarefa.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $tarefa)
        @can('delete', $tarefa)
            <div class="card">
                <div class="card-header">{{ __('tarefa.delete') }}</div>
                <div class="card-body">
                    <label class="form-label text-primary">{{ __('tarefa.title') }}</label>
                    <p>{{ $tarefa->title }}</p>
                    <label class="form-label text-primary">{{ __('tarefa.description') }}</label>
                    <p>{{ $tarefa->description }}</p>
                    {!! $errors->first('tarefa_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="card-body text-danger">{{ __('tarefa.delete_confirm') }}</div>
                <div class="card-footer">
                    <form method="POST" action="{{ route('tarefas.destroy', $tarefa) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;{{ __('app.delete_confirm') }}&quot;)" class="del-form float-right" style="display: inline;">
                        {{ csrf_field() }} {{ method_field('delete') }}
                        <input name="tarefa_id" type="hidden" value="{{ $tarefa->id }}">
                        <button type="submit" class="btn btn-danger">{{ __('app.delete_confirm_button') }}</button>
                    </form>
                    <a href="{{ route('tarefas.edit', $tarefa) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </div>
        @endcan
        @else
        <div class="card">
            <div class="card-header">{{ __('tarefa.edit') }}</div>
            <form method="POST" action="{{ route('tarefas.update', $tarefa) }}" accept-charset="UTF-8">
                {{ csrf_field() }} {{ method_field('patch') }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="title" class="form-label">{{ __('tarefa.title') }} <span class="form-required">*</span></label>
                        <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title', $tarefa->title) }}" required>
                        {!! $errors->first('title', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">{{ __('tarefa.description') }}</label>
                        <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" rows="4">{{ old('description', $tarefa->description) }}</textarea>
                        {!! $errors->first('description', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('tarefa.update') }}" class="btn btn-success">
                    <a href="{{ route('tarefas.show', $tarefa) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    @can('delete', $tarefa)
                        <a href="{{ route('tarefas.edit', [$tarefa, 'action' => 'delete']) }}" id="del-tarefa-{{ $tarefa->id }}" class="btn btn-danger float-right">{{ __('app.delete') }}</a>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
