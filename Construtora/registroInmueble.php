<?php
session_start();
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $userCorreo = $_SESSION['userEmail'];
  $sql_id = "SELECT nombre FROM usuarios WHERE correo = '$userCorreo'";
  $result_id = $conn->query($sql_id);

  if ($result_id->num_rows > 0) {
    // Recorrer los resultados de la consulta
    while ($row = $result_id->fetch_assoc()) {
      $nombre = $row['nombre'];
    }

    $nombrePropiedad = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $ciudad = $_POST['ciudad'];
    $direccion = $_POST['direccion'];
    $habitaciones = $_POST['habitaciones'];
    $baños = $_POST['baños'];
    $estrato = $_POST['estrato'];
    $precio = $_POST['precio'];
    $numeroWhatsapp = $_POST['numeroWhatsapp'];

    // Crear una carpeta para las imágenes del inmueble
    $carpetaInmueble = "inmueble/" . $direccion;
    if (!file_exists($carpetaInmueble)) {
      if (!mkdir($carpetaInmueble, 0777, true)) {
        $error = "Error al crear la carpeta del inmueble";
        echo $error;
        exit;
      }
    }

    // Verificar si se ha enviado correctamente el archivo
    if (isset($_FILES['imagenes']) && !empty($_FILES['imagenes'])) {
      // Obtener información de las imágenes
      $imagenes = $_FILES['imagenes'];

      // Recorrer las imágenes y guardarlas en la carpeta del inmueble
      $imagenesGuardadas = [];
      foreach ($imagenes['name'] as $key => $nombreImagen) {
        $rutaImagen = $carpetaInmueble . "/" . $nombreImagen;
        if (!move_uploaded_file($imagenes['tmp_name'][$key], $rutaImagen)) {
          $error = "Error al guardar las imágenes del inmueble";
          echo $error;
          exit;
        }
        $imagenesGuardadas[] = $rutaImagen;
      }

      // Insertar los datos del inmueble en la tabla "inmuebles"
      $sql = "INSERT INTO inmuebles (userCorreo, nombre, nombrePropiedad, tipo, ciudad, direccion, habitaciones, banos, estrato, precio, numeroWhatsapp, imagenes) VALUES ('$userCorreo', '$nombre', '$nombrePropiedad', '$tipo', '$ciudad', '$direccion', '$habitaciones', '$baños', '$estrato', '$precio', '$numeroWhatsapp', '" . implode(",", $imagenesGuardadas) . "')";

      if ($conn->query($sql) === TRUE) {
        // Registro exitoso
        echo "exito";
      } else {
        // Ocurrió un error al insertar el registro
        $error = "Error al insertar el registro en la base de datos: " . $conn->error;
        echo $error;
      }
    } else {
      // No se han enviado archivos
      $error = "No se han enviado archivos de imágenes";
      echo $error;
    }
  } else {
    echo "Error al insertar el usuario, sesión no iniciada";
  }

  // Cerrar la conexión a la base de datos
  $conn->close();
}
?>