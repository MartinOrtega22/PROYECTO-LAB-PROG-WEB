
$(document).ready(function () {


    //Funcion de obtener fecha y hora
    function getCurrentDateTime() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');

        return `${year}-${month}-${day} ${hours}:${minutes}:00`;
    }
    $('#fechaAlta').val(getCurrentDateTime());

    //Editar
    $('.editar-btn').click(function () {
        var idSucursal = $(this).data('id');

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

                    $('#editnombreSucursal').val(data.NombreSucursal);
                    $('#editdireccionSucursal').val(data.DireccionSucursal);
                    $('#edittelefonoSucursal').val(data.TelefonoSucursal);
                    $('#editUsuario').val(data.IdUsuario);
                    $('#editfechaAlta').val(data.FechaAlta);
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
