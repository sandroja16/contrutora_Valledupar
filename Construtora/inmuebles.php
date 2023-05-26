<?php
session_start();
include('conexion.php');

// Obtener los valores de los filtros enviados por AJAX
$habitaciones = $_POST['habitaciones'];
$estrato = $_POST['estrato'];
$banos = $_POST['banos'];

// Realizar la consulta a la base de datos con los filtros
$sql = "SELECT * FROM inmuebles WHERE 1";

if (!empty($habitaciones)) {
    $sql .= " AND habitaciones = '$habitaciones'";
}

if (!empty($estrato)) {
    $sql .= " AND estrato = '$estrato'";
}

if (!empty($banos)) {
    $sql .= " AND banos = '$banos'";
}

// Ejecutar la consulta
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
     
        $id = $row['id'];
        $nombrePropiedad = $row['nombrePropiedad'];
        $tipo = $row['tipo'];
        $ciudad = $row['ciudad'];
        $direccion = $row['direccion'];
        $habitaciones = $row['habitaciones'];
        $banos = $row['banos'];
        $estrato = $row['estrato'];
        $precio = $row['precio'];
        $imagenes = explode(',', $row['imagenes']);
        $fecha = $row['fecha'];

        // Generar el código HTML para la tarjeta de inmueble
        $tarjeta = '
          <div class="tarjeta-inmueble">
            <div class="imagen" style="background-image: url(../' . $imagenes[0] . ');">
              <div class="etiqueta-precio">' . $precio . '</div>
            </div>
            <div class="nombre-propiedad">' . $nombrePropiedad . '</div>
            <div class="ubicacion">
              <i class="fa fa-map-marker"></i>
              <span>' . $direccion . ', ' . $ciudad . '</span>
            </div>
          </div>
        . <img src="' . $imagenes[0] . '">';
         
        // Imprimir la tarjeta de inmueble
        echo $tarjeta;
    }
} else {
    // No se encontraron inmuebles con los filtros especificados
    echo '<div class="mensaje">No se encontraron inmuebles con los filtros especificados.</div>';
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
