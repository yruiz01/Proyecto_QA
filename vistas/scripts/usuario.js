var tabla;

// Función que se ejecuta al inicio
function init(){
    mostrarform(false);
    listar();

    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);	
    });

    $("#formularioc").on("submit",function(e)
    {
        editar_clave(e);	
    });

    // Cargar los permisos
    $.post("../ajax/usuario.php?op=permisos&id=", function(r){
        $("#permisos").html(r);
    });

    // Llamar a la función asignarRol cuando se cambie el tipo de usuario
    $("#tipo_usuario").on("change", function() {
        asignarRol();
    });
}

// Función limpiar
function limpiar()
{
    $("#idusuario").val("");
    $("#nombre_usuario").val("");
    $("#correo").val("");
    $("#telefono").val("");
    $("#password").val("");
    $("#imagenmuestra").attr("src","");
    $("#imagenactual").val("");
    $("#imagen").val("");
    $("#rol").val("");
    $("#tipo_usuario").val("");
    $("#estado").val("Activo");  // Establecer estado por defecto
}

// Función para asignar rol automáticamente basado en el tipo de usuario
function asignarRol() {
    var tipoUsuario = document.getElementById("tipo_usuario").value;
    var rolId;
    if (tipoUsuario === "Administrador") {
        rolId = 1;
    } else if (tipoUsuario === "Supervisor") {
        rolId = 2; 
    } else if (tipoUsuario === "Colaborador") {
        rolId = 3;
    }
    document.getElementById("rol").value = rolId;
}

// Función mostrar formulario
function mostrarform(flag)
{
    limpiar();
    if (flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled",false);
        // Asignar estado por defecto "Activo"
        $("#estado").val("Activo");
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
    }
}

// Función cancelar formulario
function cancelarform()
{
    limpiar();
    mostrarform(false);
}

// Función listar
function listar()
{
    tabla=$('#tbllistado').dataTable(
    {
        "aProcessing": true, // Activamos el procesamiento del datatables
        "aServerSide": true, // Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', // Definimos los elementos del control de tabla
        buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
        "ajax":
                {
                    url: '../ajax/usuario.php?op=listar',
                    type : "get",
                    dataType : "json",						
                    error: function(e){
                        console.log(e.responseText);	
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 5, // Paginación
        "order": [[ 0, "desc" ]] // Ordenar (columna, orden)
    }).DataTable();
}

// Función para guardar o editar
function guardaryeditar(e)
{
    e.preventDefault(); // No se activará la acción predeterminada del evento
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/usuario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {                    
              bootbox.alert(datos);	          
              mostrarform(false);
              tabla.ajax.reload();
        }

    });
    limpiar();
}

// Función para mostrar un registro para editar
function mostrar(idusuario)
{
    $.post("../ajax/usuario.php?op=mostrar",{idusuario : idusuario}, function(data, status)
    {
        data = JSON.parse(data);		
        mostrarform(true);

        $("#idusuario").val(data.Id_Usuario);
        $("#nombre_usuario").val(data.Nombre_Usuario);
        $("#correo").val(data.Correo);
        $("#telefono").val(data.Telefono);
        $("#imagenmuestra").attr("src","../files/usuarios/"+data.Imagen);
        $("#imagenactual").val(data.Imagen);
        $("#rol").val(data.Rol);
        $("#tipo_usuario").val(data.Tipo_usuario);
        $("#estado").val(data.Estado);
    })
}

// Función para desactivar un usuario
function desactivar(idusuario)
{
    bootbox.confirm("¿Está seguro de desactivar el Usuario?", function(result){
        if(result)
        {
            $.post("../ajax/usuario.php?op=desactivar", {idusuario : idusuario}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });	
        }
    })
}

// Función para activar un usuario
function activar(idusuario)
{
    bootbox.confirm("¿Está seguro de activar el Usuario?", function(result){
        if(result)
        {
            $.post("../ajax/usuario.php?op=activar", {idusuario : idusuario}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });	
        }
    })
}

// Función para mostrar el formulario de editar clave
function mostrar_clave(idusuario)
{
    $.post("../ajax/usuario.php?op=mostrar",{idusuario : idusuario}, function(data, status)
    {
        data = JSON.parse(data);
        $("#idusuarioc").val(data.Id_Usuario);
        $("#clavec").val(""); // Limpiamos el campo de la clave
        mostrarform_clave(true);
    })
}

// Función para cancelar la edición de clave
function cancelarform_clave()
{
    mostrarform_clave(false);
}

// Función para mostrar u ocultar el formulario de editar clave
function mostrarform_clave(flag)
{
    if (flag)
    {
        $("#formularioregistros").hide();
        $("#formulario_clave").show();
    }
    else
    {
        $("#formularioregistros").show();
        $("#formulario_clave").hide();
    }
}

// Función para editar la clave
function editar_clave(e)
{
    e.preventDefault(); // No se activará la acción predeterminada del evento
    var formData = new FormData($("#formularioc")[0]);

    $.ajax({
        url: "../ajax/usuario.php?op=editar_clave",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {                    
              bootbox.alert(datos);	          
              cancelarform_clave(); 
              tabla.ajax.reload();
        }

    });
}

init();
