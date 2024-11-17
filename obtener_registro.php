<?php

include("conexion.php");

if (isset($_POST["id_producto"])) {
    $salida = array();
    $stmt = $conexion->prepare("SELECT * FROM productos WHERE id = :id LIMIT 1");
    $stmt->execute(array(':id' => $_POST["id_producto"]));
    $resultado = $stmt->fetchAll();

    foreach ($resultado as $fila) {
        $salida["nombre"] = $fila["nombre"];
        $salida["descripcion"] = $fila["descripcion"];
        $salida["precio"] = $fila["precio"];
        $salida["cantidad"] = $fila["cantidad"];
    }

    echo json_encode($salida);
}
?>
