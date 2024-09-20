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

    <h2>Ejercicio 3</h2>
    <p>Utiliza un ciclo while para encontrar el primer número entero obtenido aleatoriamente,
    pero que además sea múltiplo de un número dado.<br>
    -Crear una variante de este script utilizando el ciclo do-while.<br>
    -El número dado se debe obtener vía GET.</p>
    <?php
        if(isset($_GET['numero'])){
            $num = $_GET['numero'];
            if($num > 0){
                ejer3($num);
                ejer3_dowhile($num);
            }
            else{
                echo '<h3>R= Introduce un numero mayor que 0, por favor.</h3>';
            }
        }
        else{
            echo '<h3>R= No se encontró numero en la URL.</h3>';
        }
    ?>

    <h2>Ejercicio 4</h2>
    <p>Crear un arreglo cuyos índices van de 97 a 122 y cuyos valores son las letras de la ‘a’<br>
    a la ‘z’. Usa la función chr(n) que devuelve el caracter cuyo código ASCII es n para poner<br>
    el valor en cada índice..</p>
    <?php
        ejer4();
    ?>

    <h2>Ejercicio 5</h2>
    <p>Usar las variables $edad y $sexo en una instrucción if para identificar una persona de<br>
    sexo “femenino”, cuya edad oscile entre los 18 y 35 años y mostrar un mensaje de<br>
    bienvenida apropiado.</p>
    <?php
        echo '<a href="formulario_5.html">Acceso al formulario para identificar una persona</a>';
    ?>

    <h2>Ejercicio 6</h2>
    <p>Crea en código duro un arreglo asociativo que sirva para registrar el parque vehicular de<br>
    una ciudad. Cada vehículo debe ser identificado por:<br><pre>
        •Matricula<br>
        • Auto<br>
            o Marca<br>
            o Modelo (año)<br>
            o Tipo (sedan|hachback|camioneta)<br>
        • Propietario<br>
            o Nombre<br>
            o Ciudad<br>
            o Dirección
    </pre>
    La matrícula debe tener el siguiente formato LLLNNNN, donde las L pueden ser letras de<br>
    la A-Z y las N pueden ser números de 0-9.</p>
    <?php
        echo '<a href="formulario_6.html">Acceso al formulario para buscar el vehiculo.</a>';
    ?>
</body>
</html>