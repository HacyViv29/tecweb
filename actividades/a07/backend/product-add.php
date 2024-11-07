<?php
    use backend\myapi\Productos;

    require_once __DIR__ . '/myapi/Productos.php';

    $productos = new Productos('marketzone');
    $productos->add($producto=json_decode(file_get_contents('php://input')));
    echo $productos ->getData();

?>