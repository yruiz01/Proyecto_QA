var tabla;

// Función que se ejecuta al inicio
function init() {
    var team_id = $("#idgrupo").val();
    listar(); // Llamar a la función para listar actividades al iniciar

    // Cargar las opciones de cursos basadas en el grupo seleccionado
    $.post("../ajax/cursos.php?op=selectCursos", { idgrupo: team_id }, function (r) {
        $("#curso").html(r);
        $('#curso').selectpicker('refresh');
    });

    // Asociar la función `guardaryeditar` al evento `submit` del formulario
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });

    // Actualizar el ID del curso cuando cambie el select y listar actividades
    $("#curso").change(function () {
        var idcurso = $("#curso").val(); 
        $("#idcurso").val(idcurso); // Actualizar el campo oculto con el ID del curso seleccionado
        listar(); // Volver a listar las actividades con el nuevo curso seleccionado
    });
}

// Función para limpiar los formularios y los campos
function limpiar() {
    $("#id_actividad").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
    $("#curso").selectpicker('refresh');
    $('#modalActividad').modal('hide');
}

// Función para listar actividades vinculadas al proyecto seleccionado
function listar() {
    var block_id = $("#curso").val();
    console.log("Block ID enviado: '" + block_id + "'");

    if (!block_id) {
        console.warn("No se ha seleccionado un proyecto. El ID del curso está vacío.");
        return;
    }

    // Si la tabla ya está inicializada, destruirla antes de crear una nueva instancia
    if ($.fn.DataTable.isDataTable('#tbllistado')) {
        $('#tbllistado').DataTable().destroy();
    }

    // Inicializar DataTable con opciones y datos del servidor
    tabla = $('#tbllistado').DataTable({
        "processing": true,
        "serverSide": true,
        dom: 'Bfrtip', // Definir botones de exportación
        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdf'],
        "ajax": {
            url: '../ajax/actividad.php?op=listar',
            type: "POST",
            dataType: "json",
            data: { idcurso: block_id }, // Enviar el ID del curso (block_id) como parámetro
            dataSrc: function (json) {
                console.log("Datos recibidos del servidor: ", json);

                // Si hay un problema con el formato de los datos, verificar aquí
                if (!json.aaData) {
                    console.error("Formato de datos incorrecto o no hay datos: ", json);
                    return [];
                }
                return json.aaData;
            },
            error: function (e) {
                console.error("Error en la llamada AJAX: " + e.responseText);
            }
        },
        "columns": [
            { "data": 0, "title": "Opciones" },
            { "data": 1, "title": "Nombre" },
            { "data": 2, "title": "Descripción" },
            { "data": 3, "title": "Proyecto" },
            { "data": 4, "title": "Estado" }
        ],
        "columnDefs": [
            { 
                "targets": 0, 
                "orderable": false,
                "searchable": false,
                "render": function (data, type, full, meta) {
                    return $("<div/>").html(data).text();  // Asegurar que se procese como HTML
                }
            }
        ],
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[1, "asc"]] // Ordenar por nombre de actividad de manera ascendente
    });
}

// Función para guardar o editar actividades
function guardaryeditar(e) {
    e.preventDefault(); // Evitar el comportamiento predeterminado del formulario
    $("#btnGuardar").prop("disabled", false);
    var formData = new FormData($("#formulario")[0]); // Capturar los datos del formulario

    $.ajax({
        url: "../ajax/actividad.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            bootbox.alert(datos); // Mostrar mensaje de éxito o error
            tabla.ajax.reload(); // Recargar la tabla después de la operación
            limpiar(); // Limpiar el formulario
        },
        error: function (e) {
            console.error("Error en la operación de guardado/edición: " + e.responseText);
        }
    });
}

// Función para mostrar los datos de una actividad en el formulario de edición
function mostrar(idactividad) {
    $.post("../ajax/actividad.php?op=mostrar", { idactividad: idactividad }, function (data, status) {
        try {
            data = JSON.parse(data);
            console.log("Datos de la actividad a mostrar: ", data);

            $("#id_actividad").val(data.idactividad);
            $("#nombre").val(data.nombre);
            $("#descripcion").val(data.descripcion);
            $("#curso").val(data.block_id);
            $('#curso').selectpicker('refresh');
        } catch (e) {
            console.error("Error al mostrar la actividad: " + e);
        }
    });
}

// Función para desactivar una actividad
function desactivar(idactividad) {
    bootbox.confirm("¿Está seguro de desactivar esta actividad?", function (result) {
        if (result) {
            $.post("../ajax/actividad.php?op=desactivar", { idactividad: idactividad }, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

// Función para activar una actividad
function activar(idactividad) {
    bootbox.confirm("¿Está seguro de activar esta actividad?", function (result) {
        if (result) {
            $.post("../ajax/actividad.php?op=activar", { idactividad: idactividad }, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

// Ejecutar la función de inicio cuando el documento esté listo
init();
