<?php
    include("conexion.php");
    include("funciones.php");

    header('Content-Type: application/json');
    error_reporting(0); //Desactivar el informe de errores

    $query="";
    $salida=array();
    $datos=array();
    $query="SELECT * FROM usuarios";
    
    
  /*  
    //FILTRO DE BÚSQUEDA
    if (isset($_POST["search"]["value"])) {
        $searchValue = $_POST["search"]["value"];
        $query .= ' WHERE nombre LIKE :search OR apellido LIKE :search ';
    }

    //FILTRO DE ORDENAMIENTO
    if(isset($_POST["order"])){
        $column = $_POST['order'][0]['column']; // Índice de la columna a ordenar
        $dir = $_POST["order"][0]['dir']; // Dirección de ordenamiento (asc/desc)
        $query .= ' ORDER BY ' . $column . ' ' . $dir . ' ';
    } else {
        $query .= ' ORDER BY id DESC ';
    }

    //FILTRO DE PAGINACIÓN 
    if($_POST["length"] != -1){
        $start = $_POST["start"];
        $length = $_POST["length"];
        $query .= ' LIMIT :start, :length';
    }*/

    $stmt= $conexion-> prepare( $query );

    $stmt->execute();
    $resultado=$stmt->fetchAll();
    $filtered_rows=$stmt->rowCount();

    foreach($resultado as $fila){
        $imagen ='';
        if($fila["imagen"] !='')
        {
            $imagen = '<img src="img/' . $fila["imagen"] . '" class="img-thumbnail" width="50" height="50">';
        }else{
            $imagen= '';
        }

        $sub_array=array();
        $sub_array[]=$fila["id"];
        $sub_array[]=$fila["nombre"];
        $sub_array[]=$fila["apellido"];
        $sub_array[]=$fila["telefono"];
        $sub_array[]=$fila["email"];
        $sub_array[]=$imagen;
        $sub_array[]=$fila["fecha_creacion"];
        //Bloque de código html 
        $sub_array[] = '<button type="button" name="editar" id="' . $fila["id"] . '" class="btn btn-warning btn-xs editar">Editar</button>';
        $sub_array[] = '<button type="button" name="borrar" id="' . $fila["id"] . '" class="btn btn-danger btn-xs borrar">Borrar</button>';
   
        $datos[]=$sub_array;

    }

    $salida=array(
        "draw"=> intval($_POST["draw"]),
        "recordsTotal" => obtener_todos_registros(),
        "recordsFiltered"=> $filtered_rows,
        "data"=> $datos,
    );

    echo json_encode($salida);

