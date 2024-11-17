<?php
include("conexion.php");
include("funciones.php");

header('Content-Type: application/json');
error_reporting(0); // Desactivar el informe de errores

$query = "SELECT * FROM productos"; // Selección de todos los registros de la tabla productos
$salida = array();
$datos = array();

$stmt = $conexion->prepare($query);
$stmt->execute();
$resultado = $stmt->fetchAll();
$filtered_rows = $stmt->rowCount();

foreach ($resultado as $fila) {
    $sub_array = array();
    $sub_array[] = $fila["id"];
    $sub_array[] = $fila["nombre"];
    $sub_array[] = $fila["descripcion"];
    $sub_array[] = $fila["precio"];
    $sub_array[] = $fila["cantidad"];
    // Bloque de código HTML para botones de acción
    $sub_array[] = '<button type="button" name="editar" id="' . $fila["id"] . '" class="btn btn-warning btn-xs editar">Editar</button>';
    $sub_array[] = '<button type="button" name="borrar" id="' . $fila["id"] . '" class="btn btn-danger btn-xs borrar">Borrar</button>';
    
    $datos[] = $sub_array;
}

$salida = array(
    "draw" => intval($_POST["draw"] ?? 1),
    "recordsTotal" => obtener_todos_registros(),
    "recordsFiltered" => $filtered_rows,
    "data" => $datos,
);

echo json_encode($salida);
?>
