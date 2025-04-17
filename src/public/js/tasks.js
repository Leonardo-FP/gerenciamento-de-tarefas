document.addEventListener('DOMContentLoaded', () => {

    // Instancia os modais
    const modalEditarTarefa = new bootstrap.Modal('#modalEditarTarefa');
    const modalAlterarStatus = new bootstrap.Modal('#modalAlterarStatus');
    const modalExcluirTarefa = new bootstrap.Modal('#modalExcluirTarefa');

    // Pega formulários para referencias futuras
    const formEditar = $('#formEditarTarefa');
    const formStatus = $('#formAlterarStatus');
    const formExcluir = $('#formExcluirTarefa');

    // Centralizar e facilitar a sintaxe de acesso aos modais
    const modals = {
        editar: modalEditarTarefa,
        status: modalAlterarStatus,
        excluir: modalExcluirTarefa
    };

    // Preenche modal de editar com dados
    function preencherModalEdicao({ id, title, description }) {
        $('#tarefa-id').val(id);
        $('#title').val(title);
        $('#description').val(description);
        modals.editar.show();
    }

    // Preenche modal de status com dados
    function preencherModalStatus({ id, title, status }) {
        const novoStatusTexto = status == 1 ? 'Pendente' : 'Concluído';

        $('#tarefa-alterarStatus-hidden-id, #tarefa-alterarStatus-id').val(id);
        $('#tarefa-alterarStatus-title').val(title);
        $('#tarefa-alterarStatus-status').text(novoStatusTexto);

        modals.status.show();
    }

    // Preenche modal de exclusão com dados
    function preencherModalExclusao({ id, title }) {
        $('#tarefa-excluir-id').val(id);
        $('#tarefa-excluir-title').text(title);
        modals.excluir.show();
    }

    // Renderiza a linha com os dados atualizados
    function renderizarLinhaTarefa(task) {
        return `
            <tr id="tarefa-${task.id}">
                <td>${task.id}</td>
                <td>${task.title}</td>
                <td class="descricao-cell" title="${task.description}">${task.description}</td>
                <td>
                    <span class="badge ${task.status == 1 ? 'bg-success' : 'bg-warning'}">
                        ${task.status == 1 ? 'Concluída' : 'Pendente'}
                    </span>
                </td>
                <td>${task.created_at}</td>
                <td class="acoes-cell">
                    <button class="btn btn-sm btn-secondary btn-editar w-100 mb-2" data-id="${task.id}" data-title="${task.title}" data-description="${task.description}">Editar</button>
                    <button class="btn btn-sm btn-success btn-status w-100 mb-2" data-id="${task.id}" data-title="${task.title}" data-status="${task.status}">Alterar Status</button>
                    <button class="btn btn-sm btn-danger btn-excluir w-100 mb-2" data-id="${task.id}" data-title="${task.title}">Excluir</button>
                </td>
            </tr>
        `;
    }

    // Chama a atualização dinâmica da linha e também anexa novamente os eventos de click nos botões, para que os modais continuem funcionando
    function atualizarLinha(task) {
        $(`#tarefa-${task.id}`).replaceWith(renderizarLinhaTarefa(task));
        registrarEventos(); 
    }

    // Remove os eventos antigos dos botões e anexa os novos eventos, chamando o preenchimento dos modais já com os dados corretos, vindos dos botões
    function registrarEventos() {
        $('.btn-editar').off('click').on('click', function () {
            preencherModalEdicao(this.dataset);
        });

        $('.btn-status').off('click').on('click', function () {
            preencherModalStatus(this.dataset);
        });

        $('.btn-excluir').off('click').on('click', function () {
            preencherModalExclusao(this.dataset);
        });
    }

    // Função genérica para envio padrão de qualquer formulário
    function enviarFormulario(form, url, callback) {
        $.ajax({
            url,
            method: 'POST',
            data: form.serialize(),
            success: callback,
            error: (xhr) => {
                alert('Ocorreu um erro ao processar sua requisição.');
                console.error(xhr.responseText);
            }
        });
    }

    // Realiza a submissão dos formulários quando são chamados na view. Além disso, atualiza a linha afetada e esconde o modal
    formEditar.on('submit', (e) => {
        e.preventDefault();
        enviarFormulario(formEditar, '/tasks/update', (res) => {
            atualizarLinha(res.task);
            modals.editar.hide();
            notificarUsuario('Tarefa atualizada com sucesso!', 'primary');
        });
    });

    formStatus.on('submit', (e) => {
        e.preventDefault();
        enviarFormulario(formStatus, '/tasks/updateStatus', (res) => {
            const statusFiltroAtivo = document.querySelector('.filtro-status.active')?.dataset.status;

            // Se a tarefa mudou de status e não pertence mais ao filtro atual, remove ela
            if (
                (statusFiltroAtivo === '1' && res.task.status == 0) ||
                (statusFiltroAtivo === '0' && res.task.status == 1)
            ) {
                $(`#tarefa-${res.task.id}`).remove();
            } else {
                atualizarLinha(res.task);
            }

            modals.status.hide();
            notificarUsuario('Status alterado com sucesso!');
        });
    });

    formExcluir.on('submit', (e) => {
        e.preventDefault();
        const id = $('#tarefa-excluir-id').val();

        enviarFormulario(formExcluir, '/tasks/delete', () => {
            $(`#tarefa-${id}`).remove();
            modals.excluir.hide();
            notificarUsuario('Tarefa excluída com sucesso!', 'warning');
        });
    });

    // Filtra as tarefas
    document.querySelectorAll('.filtro-status').forEach(btn => {
        btn.addEventListener('click', function () {
            // Marca botão como ativo
            document.querySelectorAll('.filtro-status').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
    
            const status = this.dataset.status;
    
            fetch(`/tasks/filter?status=${status}`)
                .then(response => response.text())
                .then(html => {
                    document.querySelector('table tbody').innerHTML = html;
                    registrarEventos();
                })
                .catch(err => console.error('Erro ao filtrar tarefas:', err));
        });
    });
    
    // Inicializa eventos ao carregar
    registrarEventos();
});
