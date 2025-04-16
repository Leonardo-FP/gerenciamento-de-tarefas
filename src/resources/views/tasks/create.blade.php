@extends('templates.authenticated')

@section('title', 'Criar tarefa')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Criar Nova Tarefa</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descrição</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="pendente">Pendente</option>
                    <option value="concluida">Concluída</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('tasks.show') }}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
</div>
@endsection
