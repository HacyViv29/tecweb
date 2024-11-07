<?php
    use backend\myapi\Productos;

    include_once __DIR__ . '/myapi/Productos.php';

    $productos = new Productos('marketzone');
    $productos->list();
    echo $productos -> getData();
?>