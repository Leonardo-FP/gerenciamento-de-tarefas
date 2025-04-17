$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Função que chama o Toast do Bootstrap e notifica o usuário
function notificarUsuario(mensagem, tipo = 'success') {
    const toastEl = $('#toastFeedback');
    toastEl.removeClass('text-bg-success text-bg-danger text-bg-warning').addClass(`text-bg-${tipo}`);
    toastEl.find('.toast-body').text(mensagem);
    const toast = new bootstrap.Toast(toastEl[0]);
    toast.show();
}