<?php
include_once __DIR__.'/database.php';

// SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
$producto = file_get_contents('php://input');
$data = array(
    'status'  => 'error',
    'message' => 'No se encontró el producto o ocurrió un error'
);

//SE VERIFICA QUE EL PRODUCTO NO ESTE VACIO
if(!empty($producto)){
     // SE TRANSFORMA EL STRING DEL JASON A OBJETO
    $jsonOBJ = json_decode($producto);

    if(isset($jsonOBJ->id)){
        // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
        $sql = "SELECT * FROM productos WHERE id = '{$jsonOBJ->id}' AND eliminado = 0";
        $result = $conexion->query($sql);
        
        //SE VERIFICA QUE EXISTA EL PRODUCTO
        if ($result->num_rows > 0) {
            $sql = "UPDATE productos SET
                        nombre = '{$jsonOBJ->nombre}',
                        marca = '{$jsonOBJ->marca}',
                        modelo = '{$jsonOBJ->modelo}',
                        precio = {$jsonOBJ->precio},
                        detalles = '{$jsonOBJ->detalles}',
                        unidades = {$jsonOBJ->unidades},
                        imagen = '{$jsonOBJ->imagen}'
                    WHERE id = '{$jsonOBJ->id}' AND eliminado = 0";
            
            if($conexion->query($sql)){
                $data['status'] =  "success";
                $data['message'] =  "Producto Actualizado correctamente";
            } else {
                $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($conexion);
            }
        }else{
            // NO SE ENCONTRÓ EL PRODUCTO
            $data['message'] = "No se encontró el producto con el nombre especificado.";
        }

        $result->free();
    } else {
        // Error si no se envió el nombre
        $data['message'] = "El nombre del producto no fue proporcionado en el JSON.";
    }

    // Cerrar la conexión
    $conexion->close();
}

// SE HACE LA CONVERSIÓN DE ARRAY A JSON
echo json_encode($data, JSON_PRETTY_PRINT);
?>