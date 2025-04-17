@foreach($tarefas as $tarefa)
    <tr id="tarefa-{{ $tarefa->id }}">
    <td>{{ $tarefa->id }}</td>
    <td>{{ $tarefa->title }}</td>
    <td>{{ $tarefa->description }}</td>
    <td>
        <span class="badge {{ $tarefa->status == 1 ? 'bg-success' : 'bg-warning' }}">
            {{ $tarefa->status == 1 ? 'Concluída' : 'Pendente' }}
        </span>
    </td>
    <td>{{ $tarefa->created_at->format('d/m/Y') }}</td>
    <td>
        <button class="btn btn-sm btn-secondary btn-editar" data-id="{{ $tarefa->id }}" data-title="{{ $tarefa->title }}" data-description="{{ $tarefa->description }}">Editar</button>
        <button class="btn btn-sm btn-success btn-status" data-id="{{ $tarefa->id }}" data-title="{{ $tarefa->title }}" data-status="{{ $tarefa->status }}">Alterar Status</button>
        <button class="btn btn-sm btn-danger btn-excluir" data-id="{{ $tarefa->id }}">Excluir</button>
    </td>
    </tr>
@endforeach

@if($tarefas->isEmpty())
    <tr><td colspan="6" class="text-center"><em>Nenhuma tarefa encontrada</em></td></tr>
@endif
