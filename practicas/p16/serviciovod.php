<?php
libxml_use_internal_errors(true);

$xml= new DOMDocument();

if (!$xml->load('serviciovod4.xml')) {
    die('Error: No se pudo cargar el archivo XML.');
}

$xsd = 'serviciovod_ep.xsd';

if (!$xml->schemaValidate($xsd))
// o usa $xml->schemaValidateSource si prefieres usar el xsd en format string
{
    $errors = libxml_get_errors();
    $noError = 1;
    $lista = '';
    foreach ($errors as $error)
    {
        $lista = $lista.'['.($noError++).']: '.$error->message.' ';
    }
    echo $lista;
    die($noError);
}

// Generar HTML
echo '<!DOCTYPE html>';
echo '<html lang="es">';
echo '<head>';
echo '    <meta charset="UTF-8">';
echo '    <title>Catálogo VOD</title>';
echo '    <style>
            .top-section { background-color: #101010; width: 100%; }
            body { margin: 0%; font-family: Arial, sans-serif; font-size: 16px; background-color: #0F171E; color: #FFFFFF; }
            h1 { color: #00A8E1; text-align: center; padding: 20px; background-color: #232F3E; margin: 0; }
            .logo { text-align: center; margin-bottom: 20px; }
            table { width: 80%; margin: 20px auto; border-collapse: collapse; border: 1px solid #FFFFFF; }
            td, th { border: 1px solid #CCCCCC; padding: 10px; text-align: left; }
            th { background-color: #232F3E; color: #FFFFFF; }
            caption { font-size: 1.5em; margin: 15px 0; color: #00A8E1; font-weight: bold; }
        </style>';
echo '</head>';
echo '<body>';

// ENCABEZADO CON LOGO Y TÍTULO
echo '<div class="top-section">';
echo '    <div class="logo">';
echo '        <img src="PrimeLogo.png" alt="Logotipo de Prime Video" width="20%" height="10%" />';
echo '    </div>';
echo '    <h1>Catálogo Video On Demand</h1>';
echo '</div>';

// TABLA DE USUARIOS DE LA CUENTA
echo '<table>';
echo '    <caption>USUARIOS</caption>';
echo '    <thead><tr><th>Usuario</th><th>Correo</th></tr></thead>';
echo '    <tbody>';
foreach ($xml->getElementsByTagName('cuenta') as $cuenta) {
    if ($cuenta instanceof DOMElement) {
        $correo = $cuenta->getAttribute('correo');
        foreach ($cuenta->getElementsByTagName('perfil') as $perfil) {
            if ($perfil instanceof DOMElement) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($perfil->getAttribute('usuario')) . '</td>';
                echo '<td>' . htmlspecialchars($correo) . '</td>';
                echo '</tr>';
            }
        }
    }
}
echo '    </tbody>';
echo '</table>';

// TABLA DE PELICULAS
echo '<table>';
echo '    <caption>PELÍCULAS</caption>';
echo '    <thead><tr><th>Título</th><th>Duración</th><th>Género</th></tr></thead>';
echo '    <tbody>';
foreach ($xml->getElementsByTagName('peliculas') as $peliculas) {
    if ($peliculas instanceof DOMElement) {
        foreach ($peliculas->getElementsByTagName('genero') as $genero) {
            if ($genero instanceof DOMElement) {
                $nombreGenero = $genero->getAttribute('nombre');
                foreach ($genero->getElementsByTagName('titulo') as $titulo) {
                    if ($titulo instanceof DOMElement) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($titulo->nodeValue) . '</td>';
                        echo '<td>' . htmlspecialchars($titulo->getAttribute('duracion')) . '</td>';
                        echo '<td>' . htmlspecialchars($nombreGenero) . '</td>';
                        echo '</tr>';
                    }
                }
            }
        }
    }
}
echo '    </tbody>';
echo '</table>';

// TABLA DE SERIES
echo '<table>';
echo '    <caption>SERIES</caption>';
echo '    <thead><tr><th>Título</th><th>Duración</th><th>Género</th></tr></thead>';
echo '    <tbody>';
foreach ($xml->getElementsByTagName('series') as $series) {
    if ($series instanceof DOMElement) {
        foreach ($series->getElementsByTagName('genero') as $genero) {
            if ($genero instanceof DOMElement) {
                $nombreGenero = $genero->getAttribute('nombre');
                foreach ($genero->getElementsByTagName('titulo') as $titulo) {
                    if ($titulo instanceof DOMElement) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($titulo->nodeValue) . '</td>';
                        echo '<td>' . htmlspecialchars($titulo->getAttribute('duracion')) . '</td>';
                        echo '<td>' . htmlspecialchars($nombreGenero) . '</td>';
                        echo '</tr>';
                    }
                }
            }
        }
    }
}
echo '    </tbody>';
echo '</table>';
echo '</body>';
echo '</html>';
?>
