<?php
    //Ejercicio 1
    //Escribir programa para comprobar si un número es un múltiplo de 5 y 7.
    function ejer1($num){
        
        if ($num%5==0 && $num%7==0)
        {
            echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
        }
        else
        {
            echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
        }
    }

    //Ejercicio 2
    /*Crea un programa para la generación repetitiva de 3 números aleatorios hasta obtener una secuencia 
    compuesta por: impar, par, impar.
    Estos números deben almacenarse en una matriz de Mx3, donde M es el número de filas y
    3 el número de columnas. Al final muestra el número de iteraciones y la cantidad de
    números generados: 12 números obtenidos en 4 iteraciones. */
    function ejer2(){
        $matriz = [];
        $iteraciones = 0;
        $fin = false;

        while(!$fin){
            $iteraciones++;
            $numal = [];

            for($i=0; $i<3; $i++){
                $numal[] = rand(1, 999);    
            }

            $matriz[] = $numal;

            if($numal[0] % 2 != 0 && $numal[1] % 2 == 0 && $numal[2] % 2 != 0) {
                $fin = true;
            }
        }
        $totalnum = $iteraciones*3;

        echo "<h3>Matriz generada:</h3>";
        echo "<table border='1'>";
            foreach ($matriz as $fila) {
                echo "<tr>";
                foreach ($fila as $num) {
                    echo "<td>$num</td>";
                }
                echo "</tr>";
            }
        echo "</table>";

        echo '<h3>R= '.$totalnum.' números obtenidos en '.$iteraciones.' iteraciones.</h3>';

    }

    //Ejercicio 3
    /*Utiliza un ciclo while para encontrar el primer número entero obtenido aleatoriamente,
    pero que además sea múltiplo de un número dado.
    -Crear una variante de este script utilizando el ciclo do-while.
    -El número dado se debe obtener vía GET.*/
    function ejer3($num){
        $encontrado = false;
        $contador = 0;
        while(!$encontrado){
            $numal = rand(1,100);
            $contador++;

            if($numal % $num == 0){
                $encontrado = true;
            }
        }
        echo '<h3>R= El primer multiplo de '.$num.' es '.$numal.'</h3>';
    }
?>