<!DOCTYPE html public "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd" xml lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar, $_7var, myvar, $myvar, $var7, $_element1, $house*5</p>
    <?php
    $_myvar;
    $_7var;
    //myvar;    //Variable invalida
    $myvar;
    $var7;
    //$house*5;   //Variable invalida
    
    echo '<h4>Respuesta:</h4>';
    echo '<ul>';
    echo '<li>$_myvar es  una variable válida porque inicia con guión bajo y no afecta la variable.</li>';
    echo '<li>$_7var es una variable válida porque inicia con guión bajo y no afecta a la variable.</li>';
    echo '<li>myvar es una variable inválida porque no tiene el signo de dolar ($), por lo que no la detecta como variable.</li>';
    echo '<li>$myvar es una variable válida porque inicia con una letra y no afecta a la variable.</li>';
    echo '<li>$var7 es una variable válida porque inicia con una letra y no afecta a la variable.</li>';
    echo '<li>$_element1 es una variable válida porque inicia con guión bajo.</li>';
    echo '<li>$house*5 es una variable inválida porque el símbolo * no está permitido.</li>';
    echo '</ul>';

    unset($_myvar, $_7var, $myvar, $var7);
    ?>
</body>
</html>