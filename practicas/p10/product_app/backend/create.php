<?php
    include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    if(!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JASON A OBJETO
        $jsonOBJ = json_decode($producto);
        /**
         * SUSTITUYE LA SIGUIENTE LÍNEA POR EL CÓDIGO QUE REALICE
         * LA INSERCIÓN A LA BASE DE DATOS. COMO RESPUESTA REGRESA
         * UN MENSAJE DE ÉXITO O DE ERROR, SEGÚN SEA EL CASO.
         */

        //Validar que los campos obligatorios no estén vacíos
        if(isset($jsonOBJ->nombre) && isset($jsonOBJ->marca) && isset($jsonOBJ->modelo) && isset($jsonOBJ->precio) && isset($jsonOBJ->unidades)){
            $nombre = $jsonOBJ->nombre;
            $marca = $jsonOBJ->marca;
            $modelo = $jsonOBJ->modelo;
            $precio = $jsonOBJ->precio;
            $detalles = isset($jsonOBJ->detalles) ? $jsonOBJ->detalles : '';
            $unidades = $jsonOBJ->unidades;
            $imagen = isset($jsonOBJ->imagen) ? $jsonOBJ->imagen : 'img/imagen.png';

            //Se revisa si el producto ya existe
            $queryRevision = "SELECT * FROM productos WHERE nombre = ? AND eliminado = 0";
            $verif = $conexion->prepare($queryRevision);
            $verif->bind_param('s', $nombre);
            $verif->execute();
            $result = $verif->get_result();

            //Si el producto se repite
            if($result->num_rows > 0){
                echo json_encode(["success" => false, "message"=>"El producto es un producto existente."]);
            }
            else{
                //El producto no existe o esta eliminado
                $queryInserccion ="INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $insert = $conexion->prepare($queryInserccion);
                $insert->bind_param('sssdsis', $nombre, $marca, $modelo, $precio,$detalles, $unidades, $imagen);

                //Realizar la insercción
                if($insert->execute()){
                    //Caso éxitoso
                    echo json_encode(["success" => true, "message"=>"El producto se ha insertado correctamente."]);
                }
                else{
                    //Caso fallido
                    echo json_encode(["success" => false, "message"=>"El producto no ha podido ser insertado."]);
                }
                $insert->close();
            }
            $verif->close();
        }
        else{
            //Falta algun campo obligatorio
            echo json_encode(["success" => false, "message"=>"Falto por llenar algún campo obligatorio."]);
        }
    }
    else{
        //No se recibio la información
        echo json_encode(["success" => false, "message"=>"No se ha recibido ninguna información."]);
    }

    //CERRAR CONEXIÓN A LA BASE DE DATOS
    $conexion->close();
?>