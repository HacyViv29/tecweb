<?php
    use backend\myapi\Productos;

    require_once __DIR__ . '/myapi/Productos.php';

    $productos = new Productos('marketzone');
    $productos->delete($_GET['id']);
    echo $productos ->getData();
?>