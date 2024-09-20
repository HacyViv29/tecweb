<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar formulario 6</title>
</head>
<body>
    <?php
    include 'parque_vehicular.php';  // Incluir el archivo con el arreglo

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['matricula'])) {
            $matricula = $_POST['matricula'];
            if (array_key_exists($matricula, $parque_vehicular)) {
                echo "<h2>Información del Vehículo</h2>";
                echo "<pre>";
                print_r($parque_vehicular[$matricula]);
                echo "</pre>";
            } else {
                echo "<h2>No se encontró el vehículo con matrícula: $matricula</h2>";
            }
        } elseif (isset($_POST['mostrar_todos'])) {
            echo "<h2>Listado Completo de Vehículos</h2>";
            echo "<pre>";
            print_r($parque_vehicular);
            echo "</pre>";
        }
    }
    ?>

</body>
</html>