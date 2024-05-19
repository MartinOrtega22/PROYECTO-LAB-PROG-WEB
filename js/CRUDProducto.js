
$(document).ready(function () {

    //Editar
    $('.editar-btn').click(function () {
        var idProducto = $(this).data('id');

        if (!idProducto) {
            console.error('ID de producto no proporcionado');
            return;
        }

        $.ajax({
            url: 'accionphp/obtenerproducto.php',
            type: 'GET',
            data: {
                idProducto: idProducto
            },
            dataType: 'json',
            success: function (data) {
                if (data.error) {
                    console.error('Error:', data.error);
                } else {
                    $('#editIdProducto').val(data.IdProducto);
                    $('#editNombreProducto').val(data.NombreProducto);
                    $('#editDescripcionProducto').val(data.DescripcionProducto);
                    $('#editPrecioProducto').val(data.PrecioProducto);
                    $('#editCategoriaProducto').val(data.CategoriaProducto);

                    if (data.ImagenProducto) {
                        $('#editImagenPreview').attr('src', 'data:image/jpeg;base64,' + data.ImagenProducto).show();
                    } else {
                        $('#editImagenPreview').hide();
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud AJAX:', status, error);
                console.error('Respuesta del servidor:', xhr.responseText);
            }
        });
    });

    $('#formAgregarProducto').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: 'accionphp/agregarproducto.php',
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


    $('#formEditarProducto').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: 'accionphp/editarproducto.php',
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
        var idProducto = $(this).data('id');
        if (!idProducto) {
            console.error('ID de producto no proporcionado');
            return;
        }

        if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
            $.ajax({
                url: 'accionphp/eliminarproducto.php',
                type: 'POST',
                data: {
                    idProducto: idProducto
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert('Producto eliminado correctamente.');
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
