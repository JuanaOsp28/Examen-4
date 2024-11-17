<?php
// Función para obtener el total de registros
function obtener_todos_registros() {
    include('conexion.php');
    $stmt = $conexion->prepare("SELECT * FROM productos");
    $stmt->execute();
    return $stmt->rowCount();
}
?>
