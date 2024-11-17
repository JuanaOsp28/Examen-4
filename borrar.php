<?php

    include("conexion.php");
    include("funciones.php");
    error_reporting(0);

    if (isset(($_POST["id_usuario"]))) {
        $imagen = obtener_nombre_imagen($_POST["id_usuario"]);
        if ($imagen !='') {
            unlink("img/".$_POST[$imagen]);
        }

        $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id=:id");

        $resultado = $stmt->execute(

            array(
                ':id'    => $_POST["id_usuario"]
            )
        );

        if (!empty($resultado)) {
            echo 'Registro eliminado';
        }
    }