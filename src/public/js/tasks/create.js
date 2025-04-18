document.addEventListener('DOMContentLoaded', () => {
    const formCriar = $('#formCriarTarefa');

    formCriar.on('submit', (e) => {
        e.preventDefault();
        enviarFormulario(formCriar, '/tasks/store', (res) => {
            window.location.href = '/tasks';
        });
    });
});