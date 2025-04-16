@extends('templates.authenticated')

@section('title', 'Bem-vindo(a)')

@section('content')
    <div class="text-center">
        <h1 class="display-4">Bem vindo(a), {{ auth()->user()->name }} !</h1>
        <p class="lead">Aqui você pode gerenciar suas tarefas pessoais com a maior eficiência possível!</p>
        <a href="{{ route('tasks.show') }}" class="btn btn-primary">Clique aqui para começar</a>
    </div>
@endsection
