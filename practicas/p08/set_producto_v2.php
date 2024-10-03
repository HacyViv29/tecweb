<?php
$nombre = isset($_POST['nombre'])? $_POST['nombre'] : 'Nombre_producto';
$marca  = isset($_POST['marca'])? $_POST['marca'] : 'Marca_producto';
$modelo = isset($_POST['modelo'])? $_POST['modelo'] : 'Modelo:producto';
$precio = isset($_POST['precio'])? $_POST['precio'] : 'Precio_Producto';
$detalles = isset($_POST['detalles'])? $_POST['detalles'] : 'Detalles_producto';
$unidades = isset($_POST['unidades'])? $_POST['unidades'] : 'Unidades_Producto';
$imagen   = isset($_POST['imagen'])? $_POST['imagen'] : 'img/imagen.png';

/** SE CREA EL OBJETO DE CONEXION */
@$link = new mysqli('localhost', 'root', 'Buap123', 'marketzone');	

/** comprobar la conexión */
if ($link->connect_errno) 
{
    die('Falló la conexión: '.$link->connect_error.'<br/>');
    /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */
}

/** Crear una tabla que no devuelve un conjunto de resultados */
$sql_check = "SELECT * FROM productos WHERE nombre = '$nombre' AND modelo = '$modelo' AND  marca = '$marca'";
$sql = "INSERT INTO productos VALUES (null, '{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}',0)";
$result_check = $link->query($sql_check);

if ($result_check->num_rows == 0){
    if ( $link->query($sql) ) 
    {
        echo 'Producto insertado con ID: '.$link->insert_id;

        echo '<br><br><h1>Resumen del producto insertado: </h1><br><br>';
        echo '<li>ID del Producto: '.$link->insert_id.'</li><br>';
        echo '<li>Nombre del Producto: '.$nombre.'</li><br>';
        echo '<li>Marca del Producto: '.$marca.'</li><br>';
        echo '<li>Modelo del Producto: '.$modelo.'</li><br>';
        echo '<li>Precio del Producto: $'.$precio.'</li><br>';
        echo '<li>Detalles del Producto: '.$detalles.'</li><br>';
        echo '<li>Unidades del Producto: '.$unidades.'</li><br>';
        echo '<li>URL de la imagen del Producto: '.$imagen.'</li><br>';
    }
}
else
{
    echo 'El Producto no se puede insertar, ya que es un producto repetido.<br>';
}


$link->close();
?>