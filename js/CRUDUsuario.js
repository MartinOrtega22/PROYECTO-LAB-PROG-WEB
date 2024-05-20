$(document).ready(function () {
    $('.editar-btn').on('click', function () {
        var idUsuario = $(this).data('id');

        if (!idUsuario) {
            console.error('ID de usuario no proporcionado');
            return;
        }

        $.ajax({
            url: 'accionphp/obtenerusuario.php',
            type: 'GET',
            data: { idUsuario: idUsuario },
            success: function (response) {
                var usuario = JSON.parse(response);
                $('#editIdUsuario').val(usuario.IdUsuario);
                $('#editNombreUsuario').val(usuario.NombreUsuario);
                $('#editDireccionUsuario').val(usuario.DireccionUsuario);
                $('#editCorreoUsuario').val(usuario.CorreoUsuario);
                $('#editTelefonoUsuario').val(usuario.TelefonoUsuario);
                $('#editRolUsuario').val(usuario.RolUsuario);
            },
            error: function () {
                alert('Error al obtener los datos del usuario');
            }
        });
    });

    $('#formAgregarUsuario').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: 'accionphp/agregarusuario.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud AJAX:', status, error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });
    });


    $('#formEditarUsuario').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: 'accionphp/editarusuario.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud AJAX:', status, error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });
    });

    $('.eliminar-btn').click(function () {
        var idUsuario = $(this).data('id');
        if (!idUsuario) {
            console.error('ID de usuario no proporcionado');
            return;
        }

        if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
            $.ajax({
                url: 'accionphp/eliminarusuario.php',
                type: 'POST',
                data: {
                    idUsuario: idUsuario
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert('Usuario eliminado correctamente.');
                        location.reload();
                    } else {
                        console.error('Error:', response.error);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', status, error);
                    console.error('Respuesta del servidor:', xhr.responseText);
                }
            });
        }
    });

    $("#searchInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#dataTable tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});