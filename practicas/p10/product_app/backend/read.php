<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();
    // SE VERIFICA HABER RECIBIDO EL ID
    if( isset($_POST['id']) ) {
        $id = $_POST['id'];
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        if ( $result = $conexion->query("SELECT * FROM productos WHERE id = '{$id}'") ) {
            // SE OBTIENEN LOS RESULTADOS
			$row = $result->fetch_array(MYSQLI_ASSOC);

            if(!is_null($row)) {
                // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                foreach($row as $key => $value) {
                    $data[$key] = utf8_encode($value);
                }
            }
			$result->free();
		} else {
            die('Query Error: '.mysqli_error($conexion));
        }
		$conexion->close();
    }
    else{
        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
        } else {
            $nombre = ''; // Valor predeterminado si no se recibe 'nombre'
        }

        // Verificar si existe el valor de 'marca' en el $_POST y asignar un valor
        if (isset($_POST['marca'])) {
            $marca = $_POST['marca'];
        } else {
            $marca = ''; // Valor predeterminado si no se recibe 'marca'
        }

        // Verificar si existe el valor de 'detalles' en el $_POST y asignar un valor
        if (isset($_POST['detalles'])) {
            $detalles = $_POST['detalles'];
        } else {
            $detalles = ''; // Valor predeterminado si no se recibe 'detalles'
        }
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        if ( $result = $conexion->query("SELECT * FROM productos WHERE nombre like '{$nombre}' OR marca like '{$marca}' OR detalles like '{$detalles}'") ) {
            // SE OBTIENEN LOS RESULTADOS
			$row = $result->fetch_array(MYSQLI_ASSOC);

            if(!is_null($row)) {
                // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                foreach($row as $key => $value) {
                    $data[$key] = utf8_encode($value);
                }
            }
			$result->free();
		} else {
            die('Query Error: '.mysqli_error($conexion));
        }
		$conexion->close();
    }
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>