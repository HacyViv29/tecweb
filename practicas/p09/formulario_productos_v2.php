<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Productos</title>
    <script src="src/main.js"></script>
</head>
<body>
    <h1>Registro de computadoras</h1>

    <p>Actualiza la información del equipo en el campo correspondiente.</p>

    <form id="formularioProductos" action="update_producto.php" method="post" onsubmit="return verifFinal();">

    <h2>Información del producto</h2>

    <fieldset>
        <legend>Computadora</legend>

        <ul>
            <input type="hidden" name="id" value="<?= isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '' ?>" />
            
            <li><label for="form-nombre">Nombre del equipo:</label> <input type="text" name="nombre" id="form-nombre" placeholder="Nombre" value="<?= isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '' ?>" onblur="verifNombre();"></li><br/>
            
            <li><label for="form-marca">Marca del equipo:</label> 
                <select id="form-marca" name="marca" onblur="verifMarca();">
                    <option value="">Selecciona una marca</option>
                    <option value="HP" <?= isset($_POST['marca']) && $_POST['marca'] == 'HP' ? 'selected' : '' ?>>HP</option>
                    <option value="Asus" <?= isset($_POST['marca']) && $_POST['marca'] == 'Asus' ? 'selected' : '' ?>>Asus</option>
                    <option value="Acer" <?= isset($_POST['marca']) && $_POST['marca'] == 'Acer' ? 'selected' : '' ?>>Acer</option>
                    <option value="Huawei" <?= isset($_POST['marca']) && $_POST['marca'] == 'Huawei' ? 'selected' : '' ?>>Huawei</option>
                </select>
            </li><br/>
            
            <li><label for="form-modelo">Modelo del equipo:</label> <input type="text" name="modelo" id="form-modelo" placeholder="Modelo"  value="<?= isset($_POST['modelo']) ? htmlspecialchars($_POST['modelo']) : '' ?>" onblur="verifModelo();"></li><br/>
            
            <li><label for="form-precio">Precio del equipo: </label><span>$</span> <input type="number" name="precio" id="form-precio"placeholder="Precio" step="0.01" value="<?= isset($_POST['precio']) ? htmlspecialchars($_POST['precio']) : '' ?>" onblur="verifPrecio();"></li><br/>
            
            <li><label for="form-detalles">Detalles del equipo</label><br><textarea name="detalles" rows="4" cols="60" id="form-detalles" placeholder="Descripción de no más de 250 caracteres de longitud" onblur="verifDetalles();"><?= isset($_POST['detalles']) ? htmlspecialchars($_POST['detalles']) : '' ?></textarea></li><br/>
            
            <li><label for="form-unidades">Unidades de equipo:</label> <input type="number" name="unidades" id="form-unidades" placeholder="Unidades" value="<?= isset($_POST['unidades']) ? htmlspecialchars($_POST['unidades']) : '' ?>" onblur="verifUnidades();"></li><br/>
            
            <li><label for="form-imagen">URL de imagen del equipo:</label> <input type="text" name="imagen" id="form-imagen" placeholder="URL imagen" value="<?= isset($_POST['imagen']) ? htmlspecialchars($_POST['imagen']) : '' ?>" onblur="verifImagen();"></li><br/>
        </ul>
    </fieldset>

    <p>
        <input type="submit" value="Agregar Producto">
        <input type="reset">
    </p>
</body>
</html>