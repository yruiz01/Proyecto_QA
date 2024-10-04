$("#frmAcceso").on('submit', function(e) {
    e.preventDefault();

    // Obtener los valores de los campos
    var nombre_usuario = $("#nombre_usuario").val();
    var password = $("#password").val();

    // Realizar la solicitud POST para verificar las credenciales
    $.post("../ajax/usuario.php?op=verificar", 
    {"nombre_usuario": nombre_usuario, "password": password}, 
    function(data) {
        data = JSON.parse(data);  // Asegurarse de parsear la respuesta

        if (data != null) {
            // Redirigir al escritorio si el login es correcto
            $(location).attr("href", "escritorio.php");
        } else {
            // Mostrar error si los datos son incorrectos
            bootbox.alert("Usuario y/o Password incorrectos");
        }
    });
});
