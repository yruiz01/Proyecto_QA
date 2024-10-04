var tabla;

// Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    });

    // Ocultar la imagen de vista previa inicialmente
    $("#imagenmuestra").hide();
}

// Función para limpiar los campos del formulario
function limpiar() {
    $("#nombre_comunidad").val("");  // Campo relevante para comunidades
    $("#fecha_creacion").val("");    // Otro campo relevante
    $("#idcomunidad").val("");
}

// Función para mostrar el formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

// Función para listar las comunidades
function listar() {
    var comunidad_id = $("#id_comunidad").val();
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: ['copyHtml5', 'excelHtml5', 'pdfHtml5', 'colvis'],
        "ajax": {
            url: '../ajax/comunidades.php?op=listar', // Cambiar a la URL correcta
            data: { id_comunidad: comunidad_id },
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
    }).DataTable();
}

// Función para guardar o editar un registro
function guardaryeditar(e) {
    e.preventDefault(); // No se activará la acción predeterminada
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/beneficiarios.php?op=guardaryeditar", // Cambiado alumnos a beneficiarios
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }
    });

    limpiar();
}

// Función para mostrar un registro
function mostrar(idcomunidad) {
    $.post("../ajax/comunidades.php?op=mostrar", { idcomunidad: idcomunidad }, function(data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $("#nombre_comunidad").val(data.Nombre_Comunidad);
        $("#fecha_creacion").val(data.Fecha_Creacion);
        $("#idcomunidad").val(data.Id_Comunidad);
    });
}

// Función para desactivar un registro
// Función para activar/desactivar una comunidad
function activar(idcomunidad) {
    bootbox.confirm("¿Está seguro de activar esta comunidad?", function(result) {
        if (result) {
            $.post("../ajax/comunidades.php?op=activar", { idcomunidad: idcomunidad }, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}
init();
