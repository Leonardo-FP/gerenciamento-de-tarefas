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

// Função genérica para envio padrão de qualquer formulário
function enviarFormulario(form, url, callback) {
    $.ajax({
        url,
        method: 'POST',
        data: form.serialize(),
        success: callback,
        error: (xhr) => {
            if (xhr.status === 422) {
                const erros = xhr.responseJSON.errors;
                const mensagens = Object.values(erros).flat().join('\n');
                alert('Erros de validação:\n' + mensagens);
            } else {
                alert('Ocorreu um erro ao processar sua requisição.');
            }
            console.error(xhr.responseText);
        }
    });
}