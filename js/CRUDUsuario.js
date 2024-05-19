$(document).ready(function () {
    $('.editar-btn').click(function () {
        var idUsuario = $(this).data('id');

        if (!idUsuario) {
            console.error('ID de usuario no proporcionado');
            return;
        }

        $.ajax({
            url: 'accionphp/obtenerusuario.php',
            type: 'GET',
            data: {
                idUsuario: idUsuario
            },
            dataType: 'json',
            success: function (data) {
                if (data.error) {
                    console.error('Error:', data.error);
                } else {
                    $('#editIdUsuario').val(data.IdUsuario);
                    $('#editNombreUsuario').val(data.NombreUsuario);
                    $('#editDireccionUsuario').val(data.DireccionUsuario);
                    $('#editCorreoUsuario').val(data.CorreoUsuario);
                    $('#editTelefonoUsuario').val(data.TelefonoUsuario);
                    $('#editRolUsuario').val(data.RolUsuario);
                    $('#editContrasenaUsuario').val(data.ContrasenaUsuario);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud AJAX:', status, error);
                console.error('Respuesta del servidor:', xhr.responseText);
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