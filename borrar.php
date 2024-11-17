<?php

include("conexion.php");
include("funciones.php");
error_reporting(0);

if (isset($_POST["id_producto"])) {
    $stmt = $conexion->prepare("DELETE FROM productos WHERE id = :id");

    $resultado = $stmt->execute(
        array(
            ':id' => $_POST["id_producto"]
        )
    );

    if (!empty($resultado)) {
        echo 'Registro eliminado';
    } else {
        echo 'Error al eliminar el registro';
    }
}
?>
