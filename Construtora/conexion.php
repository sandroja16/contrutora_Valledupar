<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contrura_valledupar";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
