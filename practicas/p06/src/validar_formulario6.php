<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostar datos de vehiculos</title>
</head>
<body>
    <?php
    include 'vehiculos.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['matricula'])) {
            $matricula = $_POST['matricula'];
            if (array_key_exists($matricula, $vehiculos)) {
                echo "<h2>Información del Vehículo</h2>";
                echo "<pre>";
                print_r($vehiculos[$matricula]);
                echo "</pre>";
            } else {
                echo "<h2>No se encontró el vehículo con matrícula: $matricula</h2>";
            }
        } elseif (isset($_POST['mostrar_todos'])) {
            echo "<h2>Listado Completo de Vehículos</h2>";
            echo "<pre>";
            print_r($vehiculos);
            echo "</pre>";
        }
    }
    ?>

</body>
</html>