@extends('templates.authenticated')

@section('title', 'Criar tarefa')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow rounded-4">
                <div class="card-header text-center border-0 bg-white">
                    <h4 class="mb-0">Criar Nova Tarefa</h4>
                </div>
                <div class="card-body">
                    <form id="formCriarTarefa">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" required>

                        <div class="mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" class="form-control rounded-3" id="title" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea class="form-control rounded-3" id="description" name="description" rows="4" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select rounded-3" id="status" name="status" required>
                                <option value="0">Pendente</option>
                                <option value="1">Concluída</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                            <a href="{{ route('tasks.show') }}" class="btn btn-sm btn-danger">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
  <!-- Importa os scripts responsáveis pelo controle dos formulários -->
  <script src="{{ asset('js/tasks/create.js') }}"></script>
@endsection