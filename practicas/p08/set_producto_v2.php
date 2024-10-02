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
$sql = "INSERT INTO productos VALUES (null, '{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}')";
if ( $link->query($sql) ) 
{
    echo 'Producto insertado con ID: '.$link->insert_id;
}
else
{
	echo 'El Producto no pudo ser insertado =(';
}

$link->close();
?>