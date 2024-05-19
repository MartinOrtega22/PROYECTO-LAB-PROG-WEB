
$(document).ready(function () {
    showSection('categoriasSeccion');

    function showSection(sectionId) {
        $('.seccion').hide();
        $('#' + sectionId).show();
    }

    window.showSection = showSection;

    window.searchTable = function (tableId, searchInputId) {
        var value = $('#' + searchInputId).val().toLowerCase();
        $('#' + tableId + ' tbody tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    };

    // Botones generales Editar
    configureEditButtons('categoriasSeccion', 'editarCategoriaModal', 'accionphp/obtenercategoria.php', 'editIdCategoria', 'editDescripcionCategoria');
    configureEditButtons('estatusventaSeccion', 'editarEstatusModal', 'accionphp/obtenerestatus.php', 'editIdEstatus', 'editDescripcionEstatus');
    configureEditButtons('rolUsuarioSeccion', 'editarRolModal', 'accionphp/obtenerrol.php', 'editIdRol', 'editDescripcionRol');

    function configureEditButtons(sectionId, modalId, fetchUrl, idInputId, descInputId) {
        $('#' + sectionId + ' .editar-btn').click(function () {
            var id = $(this).data('id');
            if (!id) {
                console.error('ID no proporcionado');
                return;
            }

            $.ajax({
                url: fetchUrl,
                type: 'GET',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data) {
                    if (data.error) {
                        console.error('Error:', data.error);
                    } else {
                        $('#' + idInputId).val(data.IdCategoria || data.IdEstatus || data.IdRol);
                        $('#' + descInputId).val(data.DescripcionCategoria || data.DescripcionEstatus || data.DescripcionRol);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', status, error);
                    console.error('Respuesta del servidor:', xhr.responseText);
                }
            });
        });
    }

    // Botones generales eliminar
    configureDeleteButtons('categoriasSeccion', 'accionphp/eliminarcategoria.php');
    configureDeleteButtons('estatusventaSeccion', 'accionphp/eliminarestatus.php');
    configureDeleteButtons('rolUsuarioSeccion', 'accionphp/eliminarrol.php');

    function configureDeleteButtons(sectionId, deleteUrl) {
        $('#' + sectionId + ' .eliminar-btn').click(function () {
            var id = $(this).data('id');
            if (!id) {
                console.error('ID no proporcionado');
                return;
            }

            if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                $.ajax({
                    url: deleteUrl,
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            alert('Registro eliminado correctamente.');
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
    }

    // Botones Generales de recarga de formularios
    configureFormAgregar('formAgregarCategoria', 'accionphp/agregarcategoria.php')
    configureFormAgregar('formAgregarEstatus', 'accionphp/agregarestatu.php')
    configureFormAgregar('formAgregarRol', 'accionphp/agregarrol.php')

    function configureFormAgregar(formAgregar, urlAgregar) {
        $('#' + formAgregar).submit(function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: urlAgregar,
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
    }


    configureFormEditar('formEditarCategoria', 'accionphp/editarcategoria.php')
    configureFormEditar('formEditarEstatus', 'accionphp/editarestatu.php')
    configureFormEditar('formEditarRol', 'accionphp/editarrol.php')

    function configureFormEditar(formEditar, urleditar) {
        $('#' + formEditar).submit(function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: urleditar,
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
    }

});