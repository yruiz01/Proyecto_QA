var tabla;

// Función que se ejecuta al inicio
function init() {
   mostrarform(false);
   listar();

   $("#formulario").on("submit", function(e) {
      guardaryeditar(e);
   })
}

// Función para limpiar los campos del formulario
function limpiar() {
   $("#id_comunidad").val("");
   $("#nombre_comunidad").val("");
   $("#fecha_creacion").val("");
   // Elimina el campo de estado si no es necesario cambiarlo
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

// Cancelar formulario
function cancelarform() {
   limpiar();
   mostrarform(false);
}

// Función para listar registros
function listar() {
   tabla = $('#tbllistado').dataTable({
      "aProcessing": true, // Activamos el procesamiento del datatable
      "aServerSide": true, // Paginación y filtrado realizados por el servidor
      dom: 'Bfrtip', // Definimos los elementos del control de la tabla
      buttons: [
         'copyHtml5',
         'excelHtml5',
         'csvHtml5',
         'pdf'
      ],
      "ajax": {
         url: '../ajax/comunidades.php?op=listar',
         type: "get",
         dataType: "json",
         error: function(e) {
            console.log(e.responseText);
         }
      },
      "bDestroy": true,
      "iDisplayLength": 10, // Paginación
      "order": [[0, "desc"]] // Ordenar (columna, orden)
   }).DataTable();
}

// Función para guardar o editar
function guardaryeditar(e) {
   e.preventDefault(); // No se activará la acción predeterminada 
   $("#btnGuardar").prop("disabled", true);
   var formData = new FormData($("#formulario")[0]);

   $.ajax({
      url: "../ajax/comunidades.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,

      success: function(datos) {
         // Verificamos si la respuesta es correcta
         if (datos == "ok") {
            Swal.fire("Correcto!", "Los datos han sido guardados correctamente!", "success");
         } else {
            Swal.fire("Error!", datos, "error");
         }
         tabla.ajax.reload(); // Recargar la tabla
         mostrarform(false);
         $("#btnGuardar").prop("disabled", false);
      }
   });
}

// Función para mostrar los datos de una comunidad
function mostrar(id_comunidad) {
   $.post("../ajax/comunidades.php?op=mostrar", {id_comunidad: id_comunidad}, function(data, status) {
      data = JSON.parse(data);
      mostrarform(true);

      $("#nombre_comunidad").val(data.Nombre_Comunidad);
      $("#id_comunidad").val(data.Id_Comunidad);
      // Elimina la línea del estado si no es necesario cambiarlo
      // $("#estado").val(data.Estado);
   })
}

init();
