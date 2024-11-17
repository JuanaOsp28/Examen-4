<?php

include("conexion.php");

if ($_POST["operacion"] == "Crear") {
    $stmt = $conexion->prepare("INSERT INTO productos(nombre, descripcion, precio, cantidad) VALUES (:nombre, :descripcion, :precio, :cantidad)");

    $resultado = $stmt->execute(
        array(
            ':nombre'       => $_POST["nombre"],
            ':descripcion'  => $_POST["descripcion"],
            ':precio'       => $_POST["precio"],
            ':cantidad'     => $_POST["cantidad"]
        )
    );

    if (!empty($resultado)) {
        echo 'Producto creado exitosamente';
    }
}

if ($_POST["operacion"] == "Editar") {
    $stmt = $conexion->prepare("UPDATE productos SET nombre=:nombre, descripcion=:descripcion, precio=:precio, cantidad=:cantidad WHERE id=:id");

    $resultado = $stmt->execute(
        array(
            ':nombre'       => $_POST["nombre"],
            ':descripcion'  => $_POST["descripcion"],
            ':precio'       => $_POST["precio"],
            ':cantidad'     => $_POST["cantidad"],
            ':id'           => $_POST["id_producto"]
        )
    );

    if (!empty($resultado)) {
        echo 'Producto actualizado exitosamente';
    }
}
?>
