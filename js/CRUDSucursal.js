
$(document).ready(function () {

    //Editar
    $('.editar-btn').click(function () {
        var idProducto = $(this).data('id');

        if (!idSucursal) {
            console.error('ID de sucursal no proporcionado');
            return;
        }

        $.ajax({
            url: 'accionphp/obtenersucursal.php',
            type: 'GET',
            data: {
                idSucursal: idSucursal
            },
            dataType: 'json',
            success: function (data) {
                if (data.error) {
                    console.error('Error:', data.error);
                } else {
                    $('#editIdSucursal').val(data.IdSucursal);
                    $('#editNombreSucursal').val(data.NombreSucursal);
                    $('#editDireccionSucursal').val(data.DireccionSucursal);
                    $('#editTelefonoSucursal').val(data.TelefonoSucursal);
                    $('#editIdUsuario').val(data.IdUsuario);
                    $('#editFechaAlta').val(data.FechaAlta);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud AJAX:', status, error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });
    });

    $('#formAgregarSucursal').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: 'accionphp/agregarsucursal.php',
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


    $('#formEditarSucursal').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: 'accionphp/editarsucursal.php',
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
        var idSucursal = $(this).data('id');
        if (!idSucursal) {
            console.error('ID de sucursal no proporcionado');
            return;
        }

        if (confirm('¿Estás seguro de que deseas eliminar esta sucursal?')) {
            $.ajax({
                url: 'accionphp/eliminarsucursal.php',
                type: 'POST',
                data: {
                    idSucursal: idSucursal
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert('Sucursal eliminada correctamente.');
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
