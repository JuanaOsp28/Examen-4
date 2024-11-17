<?php
//funcion para subir un archivo
function subir_imagen(){
    // Verifica si se ha enviado un archivo con el nombre "imagen_usuario"
    if(isset($_FILES["imagen_usuario"])){
        // `explode` divide el nombre del archivo en partes usando el punto (.) como delimitador
        // Esto separa el nombre del archivo de su extensión (e.g., "imagen.jpg" se convierte en ["imagen", "jpg"])
        $extension = explode('.', $_FILES["imagen_usuario"]['name']);
        
        // `rand` genera un número aleatorio, que se usará como nuevo nombre para la imagen
        // Esto ayuda a evitar que se sobrescriban archivos con el mismo nombre
        $nuevo_nombre = rand() . '.' . $extension[1];
        
        // Define la ubicación donde se almacenará la imagen, en la carpeta "img"
        $ubicacion = './img/' . $nuevo_nombre;
        
        // `move_uploaded_file` mueve el archivo subido desde su ubicación temporal a la ubicación final
        move_uploaded_file($_FILES['imagen_usuario']['tmp_name'], $ubicacion);
        
        // Retorna el nuevo nombre del archivo para que pueda ser utilizado posteriormente
        return $nuevo_nombre;
    }
}


    //funcion para obtener nombre de la imagen
    function obtener_nombre_imagen($id_usuario){
        // Incluye el archivo 'conexion.php' que establece la conexión con la base de datos
        include('conexion.php');
        // Prepara una consulta SQL para seleccionar la columna 'imagen' de la tabla 'usuarios' donde 'id' es igual al valor de $id_usuario
        $stmt = $conexion->prepare("SELECT imagen FROM usuarios WHERE id='$id_usuario'");
        $stmt->execute();
        // Ejecuta la consulta y obtiene todos los resultados como un array
        $resultado = $stmt->fetchAll();
        // Recorre los resultados obtenidos
        foreach($resultado as $fila){
            // Retorna el valor de la columna 'imagen' de la fila actual
            return $fila["imagen"];
        }
    }
    

    //funcion obtener registros
    function obtener_todos_registros(){
        include('conexion.php');
        // Prepara una consulta SQL para seleccionar todos los campos de la tabla 'usuarios'
        $stmt = $conexion->prepare("SELECT * FROM usuarios");
        //Ejecuta la consulta preparada
        $stmt->execute(); 
        // Obtiene todos los resultados de la consulta como un array asociativo
        $resultado = $stmt->fetchAll();
        // Devuelve el número de filas en el resultado utilizando rowCount()
        return $stmt->rowCount();
    }
     