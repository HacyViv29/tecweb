<?php
    use backend\myapi\Productos;

    require_once __DIR__ . '/myapi/Productos.php';

    $productos = new Productos('marketzone');
    $productos->search($_GET['search']);
    echo $productos ->getData();
?>