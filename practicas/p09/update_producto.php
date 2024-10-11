<?php
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $marca  = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $precio = $_POST['precio'];
    $detalles = $_POST['detalles'];
    $unidades = $_POST['unidades'];
    $imagen   = $_POST['imagen'];

    /* MySQL Conexion*/
    $link = mysqli_connect("localhost", "root", "Buap123", "marketzone");

    // Chequea coneccion
    if($link === false){
        die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
    }

    // Ejecuta la actualizacion del registro
    $sql = "UPDATE productos SET nombre = '$nombre', marca = '$marca', modelo = '$modelo', precio = '$precio', detalles = '$detalles', unidades = '$unidades', imagen = '$imagen'  WHERE id='$id'";
    if(mysqli_query($link, $sql)){
        echo "<h1>Registro del equipo actualizado.</h1><br>";
    } else {
        echo "ERROR: No se ejecuto $sql. " . mysqli_error($link);
    }

    // Cierra la conexion
    mysqli_close($link);
?>

<p>
    <form action="get_productos_vigentes_v2.php" method="get">
        <input type="submit" value="Regresar a Productos Vigentes" />
    </form>
    <form action="get_productos_xhtml_v2.php" method="get">
        <input type="submit" value="Regresar a Productos por tope" />
    </form>
</p>