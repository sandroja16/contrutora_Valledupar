<?php
session_start();
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);

    try {

        $sql = "SELECT * FROM usuarios WHERE correo = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['contrasena'] === $password) {
                $_SESSION['userEmail'] = $email;
                echo 'exito';
            } else {
                echo 'contrasena_incorrecta';
            }
        } else {
            echo 'correo_no_existe';
        }
    } catch (Exception $e) {
        echo 'error';
    }

    $conn->close();
}
?>