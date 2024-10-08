<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
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

    <h2>Ejercicio 2</h2>
        <p>Proporcionar los valores de $a, $b, $c como sigue:</p>
        <p>$a = “ManejadorSQL”;<br/>
        $b = 'MySQL’;<br/>
        $c = &amp;$a;</p>
        <?php
        $a = "ManejadorSQL";
        $b = 'MySQL';
        $c = &$a;
    
        echo '<p>a. Ahora muestra el contenido de cada variable</p>';

        echo '$a = '.$a;
        echo '<br>';
        echo '$b = '.$b;
        echo '<br>';
        echo '$c = '.$c;


        echo '<p>b. Agrega al código actual las siguientes asignaciones:<br>
        $a = “PHP server”; <br>
        $b = &$a;</p>';

        $a = "PHP server";
        $b = &$a;

        echo '<p>c. Vuelve a mostrar el contenido de cada uno</p>';

        echo '$a = '.$a;
        echo '<br>';
        echo '$b = '.$b;
        echo '<br>';
        echo '$c = '.$c;

        echo '<p>d. Describe en y muestra en la página obtenida qué ocurrió en el segundo bloque de
        asignaciones</p>';

        echo '<h4>Respuesta:</h4>';
        echo '<ul>';
        echo '<p>Lo que paso en el segundo bloque es que, al actualizar el valor asignado a la variable "$a", se actualiza automaticamente la variable "$c" gracias a lo asignado en el bloque 1;
        y al asignarle lo mismo a la variable "$b", hace que las tres variables tengan el mismo contenido en base a la variable "$a".</p>';
        echo '</ul>';

        unset($a, $b, $c);
        ?>

    <h2>Ejercicio 3</h2>
        <p>Muestra el contenido de cada variable inmediatamente después de cada asignación,<br/>
        verificar la evolución del tipo de estas variables (imprime todos los componentes de los<br/>
        arreglo):</p>
        <?php
        echo '<p><b>$a = “PHP5”;</b></p>';
        $a = "PHP5 ";
        echo '$a = '.$a;

        echo '<p><b>$z[] = &$a;</b></p>';
        $z[] = &$a;
        echo '$z = ';
        print_r ($z);

        echo '<p><b>$b = “5a version de PHP”</b>;</p>';
        $b = "5a version de PHP";
        echo '$b = '.$b;

        echo '<p><b>$c = $b*10;</b></p>';
        //$c = intval($b)*10; 
        @$c = $b*10;
        echo '$c = '.$c;

        echo '<p><b>$a .= $b;</b></p>';
        $a .= $b;
        echo '$a = '.$a;

        echo '<p><b>$b *= $c;</b></p>';
        //settype($b, "int");
        //$b *= $c;
        @$b *= $c;
        echo '$b = '.$b;

        echo '<p><b>$z[0] = “MySQL”</b>;</p>';
        $z[0] = "MySQL";
        echo '$z = ';
        print_r($z);
        ?>

<h2>Ejercicio 4</h2>
        <p>Lee y muestra los valores de las variables del ejercicio anterior, pero ahora con la ayuda de<br/>
        la matriz $GLOBALS o del modificador global de PHP.</p>
        <?php
        echo '<b>$a = </b>'.$GLOBALS['a'].'<br>';

        echo '<b>$z = </b>';
        print_r($GLOBALS['z']);
        echo '<br>';

        echo '<b>$b = </b>'.$GLOBALS['b'].'<br>';

        echo '<b>$c = </b>'.$GLOBALS['c'].'<br>';

        unset($a, $z, $b, $c);
        ?>

<h2>Ejercicio 5</h2>
    <p>Dar el valor de las variables $a, $b, $c al final del siguiente script:</p>
    <p>$a = “7 personas”;<br/>
    $b = (integer) $a;<br/>
    $a = “9E3”;<br/>
    $c = (double) $a;</p>
    <?php
    $a = "7 personas";
    $b = (integer) $a;
    $a = "9E3";
    $c = (double) $a;

    echo '<b>$a = </b>'.$a.'<br>';
    echo '<b>$b = </b>'.$b.'<br>';
    echo '<b>$c = </b>'.$c.'<br>';

    unset($a, $b, $c);
    ?>

<h2>Ejercicio 6</h2>
    <p>Dar y comprobar el valor booleano de las variables $a, $b, $c, $d, $e y $f y muéstralas
    usando la función var_dump("datos").</p>
    <p>$a = “0”;<br/>
    $b = “TRUE”;<br/>
    $c = FALSE;<br/>
    $d = ($a OR $b);<br/>
    $e = ($a AND $c);<br/>
    $f = ($a XOR $b);</p>
    <?php
    $a = "0";
    $b = "TRUE";
    $c = FALSE;
    $d = ($a OR $b);
    $e = ($a AND $c);
    $f = ($a XOR $b);

    echo '<b>$a = </b>';
    var_dump($a);
    echo '<br>';

    echo '<b>$b = </b>';
    var_dump($b);
    echo '<br>';

    echo '<b>$c = </b>';
    var_dump($c);
    echo '<br>';

    echo '<b>$d = </b>';
    var_dump($d);
    echo '<br>';

    echo '<b>$e = </b>';
    var_dump($e);
    echo '<br>';

    echo '<b>$f = </b>';
    var_dump($f);
    echo '<br>';

    echo '<p>Después investiga una función de PHP que permita transformar el valor booleano de $c y $e
    en uno que se pueda mostrar con un echo:</p>';

    echo '<b>$c = </b>';
    echo var_export($c);
    echo '<br>';

    echo '<b>$e = </b>';
    echo var_export($e);
    echo '<br>';

    unset($a, $b, $c, $d, $e, $f);
    ?>

<h2>Ejercicio 7</h2>
    <p>Usando la variable predefinida $_SERVER, determina lo siguiente:</p>
    <p>a. La versión de Apache y PHP<br/>
    b. El nombre del sistema operativo (servidor)<br/>
    c. El idioma del navegador (cliente).</p>
    <?php
    echo 'Version de Apache y PHP: <b>'.$_SERVER['SERVER_SOFTWARE'].'</b><br>';
    //echo 'Nombre del sistema operativo: <b>'.$_SERVER['SERVER_NAME'].'</b><br>';
    echo 'Nombre del sistema operativo: <b>'.PHP_OS.'</b><br>';
    echo 'Idioma del navehador: <b>'.$_SERVER['HTTP_ACCEPT_LANGUAGE'].'</b><br>';
    ?>
    
    <p>
        <a href="https://validator.w3.org/markup/check?uri=referer"><img
        src="https://www.w3.org/Icons/valid-xhtml11" alt="Valid XHTML 1.1" height="31" width="88" /></a>
    </p>
</body>
</html>