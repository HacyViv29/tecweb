<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar formulario 5</title>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $edad = $_POST['edad'];
    $sexo = $_POST['sexo'];

    if ($sexo == 'femenino' && $edad >= 18 && $edad <= 35) {
        echo "<h2>Bienvenida, usted está en el rango de edad permitido.</h2>";
    } else {
        echo "<h2>Lo siento, no cumple con los criterios.</h2>";
    }
}
?>
</body>
</html>