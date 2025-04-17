document.addEventListener('DOMContentLoaded', function () {
    const modalEditarTarefa = new bootstrap.Modal(document.getElementById('modalEditarTarefa'));
    const modalAlterarStatus = new bootstrap.Modal(document.getElementById('modalAlterarStatus'));
    
    // Preenche Modal de Editar Tarefa com dados
    document.querySelectorAll('.btn-editar').forEach(btn => {
        btn.addEventListener('click', function () {
            $('#tarefa-id').val(this.dataset.id);
            $('#title').val(this.dataset.title);
            $('#description').val(this.dataset.description);
            modalEditarTarefa.show();
        });
    });

    // Preenche Modal de Alterar Status com dados
    document.querySelectorAll('.btn-status').forEach(btn => {
        btn.addEventListener('click', function () {
            const status = this.dataset.status;
            const statusTexto = status == 1 ? 'Pendente' : 'Concluído';

            $('#tarefa-alterarStatus-hidden-id').val(this.dataset.id);
            $('#tarefa-alterarStatus-id').val(this.dataset.id);
            $('#tarefa-alterarStatus-title').val(this.dataset.title);
            $('#tarefa-alterarStatus-status').text(statusTexto);
            $('#title').val(this.dataset.title);
            modalAlterarStatus.show();
        });
    });

    // Enviar formulário de edição de tarefa via AJAX
    $('#formEditarTarefa').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: '/tasks/update',
            method: 'POST',
            data: formData,
            success: function (response) {
                const task = response.task;

                $(`#tarefa-${task.id}`).replaceWith(`
                    <tr id="tarefa-${task.id}">
                        <td>${task.id}</td>
                        <td>${task.title}</td>
                        <td>${task.description}</td>
                        <td>
                            <span class="badge ${task.status == 1 ? 'bg-success' : 'bg-warning'}">
                                ${task.status == 1 ? 'Concluída' : 'Pendente'}
                            </span>
                        </td>
                        <td>${task.created_at}</td>
                        <td>
                            <button class="btn btn-sm btn-secondary btn-editar" data-id="${task.id}" data-title="${task.title}" data-description="${task.description}">Editar</button>
                            <button class="btn btn-sm btn-success btn-concluir" data-id="${task.id}">Alterar Status</button>
                            <button class="btn btn-sm btn-danger btn-excluir" data-id="${task.id}">Excluir</button>
                        </td>
                    </tr>
                `);

                modalEditarTarefa.hide();
            },
            error: function (xhr) {
                alert('Erro ao atualizar a tarefa.');
                console.error(xhr.responseText);
            }
        });
    });

      // Enviar formulário de alteração de status via AJAX
      $('#formAlterarStatus').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: '/tasks/updateStatus',
            method: 'POST',
            data: formData,
            success: function (response) {
                const task = response.task;

                $(`#tarefa-${task.id}`).replaceWith(`
                    <tr id="tarefa-${task.id}">
                        <td>${task.id}</td>
                        <td>${task.title}</td>
                        <td>${task.description}</td>
                        <td>
                            <span class="badge ${task.status == 1 ? 'bg-success' : 'bg-warning'}">
                                ${task.status == 1 ? 'Concluída' : 'Pendente'}
                            </span>
                        </td>
                        <td>${task.created_at}</td>
                        <td>
                            <button class="btn btn-sm btn-secondary btn-editar" data-id="${task.id}" data-title="${task.title}" data-description="${task.description}">Editar</button>
                            <button class="btn btn-sm btn-success btn-concluir" data-id="${task.id}">Alterar Status</button>
                            <button class="btn btn-sm btn-danger btn-excluir" data-id="${task.id}">Excluir</button>
                        </td>
                    </tr>
                `);

                modalAlterarStatus.hide();
            },
            error: function (xhr) {
                alert('Erro ao atualizar a tarefa.');
                console.error(xhr.responseText);
            }
        });
    });
});
