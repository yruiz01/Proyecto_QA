var tabla;

// Función que se ejecuta al inicio
function init(){
   mostrarform(false);
   listar();

   $("#formulario").on("submit", function(e){
   	guardaryeditar(e);
   });
}

// Función para limpiar los campos del formulario
function limpiar(){
	$("#idcurso").val("");
	$("#nombre").val("");
	$("#descripcion").val("");
	$("#fecha_inicio").val("");
	$("#fecha_fin").val("");
	$("#fecha_alerta").val("");
	$("#estado_alerta").val("");
	$("#responsable").val("");
	$("#contribucion_proyecto").val("");
	$("#archivo_pdf").val("");
}
 
// Función para mostrar u ocultar el formulario
function mostrarform(flag){
	limpiar();
	if(flag){
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

// Función para cancelar el formulario
function cancelarform(){
	limpiar();
	mostrarform(false);
}

// Función para listar los registros
function listar(){
	var team_id = $("#idgrupo").val();
	tabla = $('#tbllistado').dataTable({
		"aProcessing": true, // Activamos el procesamiento del datatable
		"aServerSide": true, // Paginación y filtrado realizados por el server
		dom: 'Bfrtip', // Definimos los elementos del control de la tabla
		buttons: [
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdf'
		],
		"ajax": {
			url: '../ajax/cursos.php?op=listar',
			data: {idgrupo: team_id},
			type: "get",
			dataType: "json",
			error: function(e){  
				console.log(e.responseText);	
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10, // Paginación
		"order": [[0, "desc"]] // Ordenar (columna, orden)
	}).DataTable();
}

// Función para guardar y editar registros
function guardaryeditar(e){
     e.preventDefault(); // No activar la acción predeterminada 
     $("#btnGuardar").prop("disabled", true);
     var formData = new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../ajax/cursos.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,
 
     	success: function(datos){
     		bootbox.alert(datos);
     		mostrarform(false);
     		tabla.ajax.reload();
     	}
     });

     limpiar();
}

// Función para mostrar un registro en el formulario
function mostrar(id){
	$.post("../ajax/cursos.php?op=mostrar", {idcurso : id}, function(data, status){
		data = JSON.parse(data);
		mostrarform(true);

		$("#nombre").val(data.name);
		$("#descripcion").val(data.descripcion);
		$("#fecha_inicio").val(data.fecha_inicio);
		$("#fecha_fin").val(data.fecha_fin);
		$("#fecha_alerta").val(data.fecha_alerta);
		$("#estado_alerta").val(data.estado_alerta);
		$("#responsable").val(data.responsable);
		$("#contribucion_proyecto").val(data.contribucion_proyecto);
		$("#idcurso").val(data.id);
		// Para archivo PDF, no es necesario mostrar el archivo ya que no se puede cargar automáticamente un archivo en el input file
	});
}

// Función para desactivar un registro
function desactivar(id){
	bootbox.confirm("¿Está seguro de desactivar este curso?", function(result){
		if (result) {
			$.post("../ajax/cursos.php?op=desactivar", {idcurso: id}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	});
}

// Función para activar un registro
function activar(id){
	bootbox.confirm("¿Está seguro de activar este curso?", function(result){
		if (result) {
			$.post("../ajax/cursos.php?op=activar", {idcurso: id}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	});
}

init();
