$(document).ready(function () {
    // Se añade la clase 'sign-in' al contenedor después de 200 ms
    setTimeout(function () {
        $('#container').addClass('sign-in');
    }, 200);

    // LOGIN
    $('.sign-in button').click(function (e) {
        e.preventDefault();
        const username = $('.sign-in input[placeholder="Nombre de usuario"]').val();
        const password = $('.sign-in input[placeholder="Contraseña"]').val();

        // Enviar datos de inicio de sesión al servidor
        $.post('login.php', {
            username: username,
            password: password
        }, function (response) {
            if (response === "success") {
                window.location.href = "welcome.php"; // Redirigir a la página de bienvenida
            } else {
                alert("Credenciales incorrectas"); // Mensaje de error
            }
        });
    });
});
