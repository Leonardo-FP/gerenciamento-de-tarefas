@extends('templates.authenticated')

@section('title', 'Suas tarefas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Minhas Tarefas</h2>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary" id="btn-nova-tarefa">Nova Tarefa</a>
</div>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>Título</th>
            <th>Descrição</th>
            <th>Status</th>
            <th>Data de Criação</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tarefas as $tarefa)
        <tr>
            <td>{{ $tarefa->titulo }}</td>
            <td>{{ $tarefa->descricao }}</td>
            <td>
                <span class="badge {{ $tarefa->status === 'concluida' ? 'bg-success' : 'bg-warning' }}">
                    {{ ucfirst($tarefa->status) }}
                </span>
            </td>
            <td>{{ $tarefa->created_at->format('d/m/Y') }}</td>
            <td>
                <button class="btn btn-sm btn-secondary btn-editar" data-id="{{ $tarefa->id }}" data-titulo="{{ $tarefa->titulo }}" data-descricao="{{ $tarefa->descricao }}">Editar</button>
                <button class="btn btn-sm btn-success btn-concluir" data-id="{{ $tarefa->id }}">Concluir</button>
                <button class="btn btn-sm btn-danger btn-excluir" data-id="{{ $tarefa->id }}">Excluir</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('scripts')
<!-- Modal para edição -->
<div class="modal fade" id="modalEditarTarefa" tabindex="-1" aria-labelledby="modalEditarTarefaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditarTarefa">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditarTarefaLabel">Editar Tarefa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="tarefa-id" name="id">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Salvar alterações</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection