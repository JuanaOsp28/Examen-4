<?php
    $usuario = "root";
    $passwood = "";
    $dsn = "mysql:host=localhost;dbname=crud_usuarios";

    try {
        // Establecer la conexión con PDO
        $conexion = new PDO($dsn, $usuario, $passwood);
        
        // Configurar PDO para que lance excepciones en caso de errores
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //echo "Conexión exitosa";
    } catch (PDOException $e) {
        // Manejar errores de conexión
        echo "Error al conectar a la base de datos: " . $e->getMessage();
    }
