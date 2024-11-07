<?php
    use backend\myapi\Productos;

    require_once __DIR__ . '/myapi/Productos.php';

    $productos = new Productos('marketzone');
    $productos->single($_POST['id']);
    echo $productos ->getData();
?>