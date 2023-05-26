<?php
include('conexion.php');
// Obtener los datos enviados desde el formulario
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];


// Verificar si el correo ya está registrado en la base de datos
$sql = "SELECT * FROM usuarios WHERE correo = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // El correo ya está registrado, enviar respuesta
    echo 'existing_email';
} else {
    // El correo no está registrado, realizar el registro en la base de datos
    $sql = "INSERT INTO usuarios (nombre, correo, contrasena) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === true) {
        // Registro exitoso, enviar respuesta
        echo 'success';
    } else {
        // Error al realizar el registro
        echo 'error';
    }
}

// Cerrar la conexión a la base de datos
$conn->close();

?>