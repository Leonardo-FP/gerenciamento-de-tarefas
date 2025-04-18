document.addEventListener('DOMContentLoaded', () => {
    const formCriar = $('#formCriarTarefa');

    formCriar.on('submit', (e) => {
        e.preventDefault();
        enviarFormulario(formCriar, '/tasks/store', (res) => {
            notificarUsuario('Tarefa criada com sucesso!', 'primary');
            window.location.href = '/tasks';
        });
    });
});