<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Producto</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="src/main.js"></script>
</head>
<body>
    <h3>PRODUCTO</h3>

<br/>
<?php
    $data = array();
    if(isset($_GET['tope']))
		$tope = $_GET['tope'];

    if (!is_numeric($tope)) {
        die('El parámetro "tope" debe ser un número.');
    } 

    if (!empty($tope))
    {
        /** SE CREA EL OBJETO DE CONEXION */
        @$link = new mysqli('localhost', 'root', 'Buap123', 'marketzone');
        /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */
    
        /** comprobar la conexión */
        if ($link->connect_errno) 
        {
            die('Falló la conexión: '.$link->connect_error.'<br/>');
            //exit();
        }
    
        if ($result = $link->query("SELECT * FROM productos WHERE unidades <= $tope")) {
            /** Se extraen las tuplas obtenidas de la consulta */
            $data = $result->fetch_all(MYSQLI_ASSOC);
        }
    
        $link->close();
    }
    ?>
    <?php if( isset($data) ) : ?>

<table class="table">
    <thead class="thead-dark">
        <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre</th>
        <th scope="col">Marca</th>
        <th scope="col">Modelo</th>
        <th scope="col">Precio</th>
        <th scope="col">Unidades</th>
        <th scope="col">Detalles</th>
        <th scope="col">Imagen</th>
        <th scope="col">Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $index => $row) : ?>
        <tr id="row-<?= $index ?>">
            <th scope="row"><?= $index+1 ?></th>
            <td class="row-data"><?=$row['id']?></td>
            <td class="row-data"><?= $row['nombre'] ?></td>
            <td class="row-data"><?= $row['marca'] ?></td>
            <td class="row-data"><?= $row['modelo'] ?></td>
            <td class="row-data"><?= $row['precio'] ?></td>
            <td class="row-data"><?= $row['unidades'] ?></td>
            <td class="row-data"><?= utf8_encode($row['detalles']) ?></td>
            <td class="row-data"><img src=<?= $row['imagen'] ?> ></td>
            <td><input type="button" value="modificar"  onclick="send2form();" /></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php else : ?>

<script>
alert('No hay productos que tengan esa cantidad de producto.');
</script>

<?php endif; ?>

    </body>
</html>