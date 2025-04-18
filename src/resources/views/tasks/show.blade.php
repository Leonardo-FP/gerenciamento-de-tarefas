@extends('templates.authenticated')

@section('title', 'Minhas tarefas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Minhas Tarefas</h2>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary" id="btn-nova-tarefa">Nova Tarefa</a>
</div>

<div class="mb-3">
  <div class="btn-group" role="group" aria-label="Filtro de status">
      <button class="btn btn-outline-primary filtro-status active" data-status="">Todas</button>
      <button class="btn btn-outline-warning filtro-status" data-status="0">Pendentes</button>
      <button class="btn btn-outline-success filtro-status" data-status="1">Concluídas</button>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-bordered table-hover">
      <thead class="table-light">
          <tr>
              <th>ID</th>
              <th>Título</th>
              <th>Descrição</th>
              <th>Status</th>
              <th>Data de Criação</th>
              <th>Ações</th>
          </tr>
      </thead>
      <tbody>
          @foreach($tarefas as $tarefa)
            @if(!empty($tarefa))
              <tr id="tarefa-{{ $tarefa->id }}">
                <td>{{ $tarefa->id }}</td>
                <td>{{ $tarefa->title }}</td>
                <td class="descricao-cell" title="{{ $tarefa->description }}">{{ $tarefa->description }}</td>
                <td>
                    <span class="badge {{ $tarefa->status == 1 ? 'bg-success' : 'bg-warning' }}">
                        {{ $tarefa->status == 1 ? 'Concluída' : 'Pendente' }}
                    </span>
                </td>
                <td>{{ $tarefa->created_at->format('d/m/Y') }}</td>
                <td class="acoes-cell">
                    <button class="btn btn-sm btn-secondary btn-editar w-100 mb-2" data-id="{{ $tarefa->id }}" data-title="{{ $tarefa->title }}" data-description="{{ $tarefa->description }}">Editar</button>
                    <button class="btn btn-sm btn-success btn-status w-100 mb-2" data-id="{{ $tarefa->id }}" data-title="{{ $tarefa->title }}" data-status="{{ $tarefa->status }}">Alterar Status</button>
                    <button class="btn btn-sm btn-danger btn-excluir w-100 mb-2" data-id="{{ $tarefa->id }}">Excluir</button>
                </td>
              </tr>
            @else
              <tr>
                <td colspan="6" class="text-center"><em>Nenhuma tarefa cadastrada</em></td>
              </tr>
            @endif
          @endforeach
      </tbody>
  </table>
</div>

<!-- Modal para edição -->
<div class="modal fade" id="modalEditarTarefa" tabindex="-1" aria-labelledby="modalEditarTarefaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditarTarefa" action="{{ route('tasks.update') }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modalEditarTarefaLabel">Editar Tarefa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="tarefa-id" name="id">
            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descrição</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Salvar alterações</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal para alteração de status -->
<div class="modal fade" id="modalAlterarStatus" tabindex="-1" aria-labelledby="modalAlterarStatusLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formAlterarStatus" action="{{ route('tasks.updateStatus') }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modalAlterarStatusLabel">Alterar status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="tarefa-alterarStatus-hidden-id" name="id">

            <h6>Você tem certeza que deseja alterar o Status da seguinte tarefa para <strong id="tarefa-alterarStatus-status"></strong>?</h6>
            <div class="d-flex justify-content-between mt-5 mb-3">
              <div>
                <label for="tarefa-alterarStatus-id" class="form-label">ID</label>
                <input type="text" class="form-control bg-body-secondary" id="tarefa-alterarStatus-id" name="id" required readonly>
              </div>
              <div>
                <label for="tarefa-alterarStatus-title" class="form-label">Título</label>
                <input type="text" class="form-control bg-body-secondary" id="tarefa-alterarStatus-title" required readonly>
              </div>
            </div>

          </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Salvar alterações</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal para confirmação de exclusão -->
<div class="modal fade" id="modalExcluirTarefa" tabindex="-1" aria-labelledby="modalExcluirTarefaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formExcluirTarefa" action="{{ route('tasks.delete') }}" method="POST">
        @csrf
        <input type="hidden" name="id" id="tarefa-excluir-id">

        <div class="modal-header">
          <h5 class="modal-title" id="modalExcluirTarefaLabel">Excluir Tarefa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <p>Tem certeza que deseja excluir a tarefa <strong id="tarefa-excluir-title"></strong>?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Excluir</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
  <!-- Importa os scripts responsáveis pelo controle dos formulários -->
  <script src="{{ asset('js/tasks/index.js') }}"></script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Verifica se há mensagem armazenada na sessão, vinda da tela de cadastro
      const toastMessage = "{{ session('toast_message') }}";
      const toastType = "{{ session('toast_type') }}";
      
      // Se a mensagem existir, chama o Toast
      if (toastMessage) {
          notificarUsuario(toastMessage, toastType);
      }
    });
  </script>
  
@endsection


