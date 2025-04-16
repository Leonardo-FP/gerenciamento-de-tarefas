$(document).ready(function () {
    $('#logout-btn').on('click', function (e) {
        e.preventDefault();

        $.post('/logout')
            .done(function () {
                window.location.href = '/';
            })
            .fail(function () {
                alert('Erro ao deslogar.');
            });
    });
});
