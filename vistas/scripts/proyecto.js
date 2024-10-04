var tabla;

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);	
    });
}

//Función limpiar
function limpiar() {
    $("#idproyecto").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
    $("#fecha_inicio").val("");
    $("#fecha_fin").val("");
    $("#archivoactual").val("");
    $("#archivo_muestra").hide(); // Oculta el enlace de archivo
}

//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnagregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

//Función cancelar formulario
function cancelarform() {
    limpiar();
    mostrarform(false);
}

//Función listar
function listar() {
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true, // Activamos el procesamiento del datatables
        "aServerSide": true, // Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', // Definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/proyecto.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);	
            }
        },
        "bDestroy": true,
        "iDisplayLength": 5, // Paginación
        "order": [[ 0, "desc" ]] // Ordenar (columna, orden)
    }).DataTable();
}

//Función para guardar o editar
function guardaryeditar(e) {
    e.preventDefault(); // Evitar que se envíe el formulario de manera normal
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/proyecto.php?op=guardaryeditar",
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

//Función para mostrar un proyecto en el formulario
function mostrar(idproyecto) {
    $.post("../ajax/proyecto.php?op=mostrar", {idproyecto: idproyecto}, function(data, status) {
        data = JSON.parse(data);
        mostrarform(true);  // Abrimos el formulario de edición

        // Llenar los campos del formulario con los datos del proyecto
        $("#idproyecto").val(data.idproyecto);  // Asegúrate de llenar el campo oculto con el id
        $("#nombre").val(data.nombre);
        $("#descripcion").val(data.descripcion);
        $("#fecha_inicio").val(data.fecha_inicio);
        $("#fecha_fin").val(data.fecha_fin);
        if (data.archivo_pdf != "") {
            $("#archivo_muestra").show();
            $("#archivo_muestra").attr("href", "../files/proyectos/" + data.archivo_pdf);
            $("#archivoactual").val(data.archivo_pdf);
        } else {
            $("#archivo_muestra").hide();
        }
    });
}


//Función para eliminar un proyecto
function eliminar(idproyecto) {
    bootbox.confirm("¿Está seguro de eliminar este proyecto?", function(result) {
        if (result) {
            $.post("../ajax/proyecto.php?op=eliminar", {idproyecto: idproyecto}, function(e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

init();