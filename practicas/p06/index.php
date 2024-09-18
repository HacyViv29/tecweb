<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 6</title>
</head>
<body>
    <?php
        include 'src/funciones.php';
    ?>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
    <?php
        if(isset($_GET['numero']))
        {
            $num = $_GET['numero'];
            ejer1($num);
        }
        else{
            echo '<h3>R= No se encontró numero en la URL.</h3>';
        }
        unset($num);
    ?>

    <h2>Ejercicio 2</h2>
    <p>Crea un programa para la generación repetitiva de 3 números aleatorios hasta obtener una<br> 
    secuencia compuesta por: impar, par, impar<br>
    Estos números deben almacenarse en una matriz de Mx3, donde M es el número de filas y<br>
    3 el número de columnas. Al final muestra el número de iteraciones y la cantidad de<br>
    números generados</p>
    <?php
        ejer2();
    ?>
</body>
</html>