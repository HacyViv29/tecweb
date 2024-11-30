<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $xml = new DOMDocument();
        $xml->load('serviciovod4.xml');
    
        // Agregar nuevo perfil
        $cuenta = $xml->getElementsByTagName('cuenta')->item(0);
        $nuevoPerfil = $xml->createElement('perfil');
        $nuevoPerfil->setAttribute('usuario', $_POST['usuario']);
        $nuevoPerfil->setAttribute('idioma', $_POST['idioma']);
        $cuenta->getElementsByTagName('perfiles')->item(0)->appendChild($nuevoPerfil);
    
        // Agregar nuevo género y títulos en películas
        $peliculas = $xml->getElementsByTagName('peliculas')->item(0);
        $nuevoGeneroPeliculas = $xml->createElement('genero');
        $nuevoGeneroPeliculas->setAttribute('nombre', $_POST['genero_pelicula']);
    
        $titulo1 = $xml->createElement('titulo', $_POST['titulo_pelicula1']);
        $titulo1->setAttribute('duracion', $_POST['duracion_pelicula1']);
        $titulo2 = $xml->createElement('titulo', $_POST['titulo_pelicula2']);
        $titulo2->setAttribute('duracion', $_POST['duracion_pelicula2']);
    
        $nuevoGeneroPeliculas->appendChild($titulo1);
        $nuevoGeneroPeliculas->appendChild($titulo2);
        $peliculas->appendChild($nuevoGeneroPeliculas);
    
        // Agregar nuevo género y títulos en series
        $series = $xml->getElementsByTagName('series')->item(0);
        $nuevoGeneroSeries = $xml->createElement('genero');
        $nuevoGeneroSeries->setAttribute('nombre', $_POST['genero_serie']);
    
        $titulo3 = $xml->createElement('titulo', $_POST['titulo_serie1']);
        $titulo3->setAttribute('duracion', $_POST['duracion_serie1']);
        $titulo4 = $xml->createElement('titulo', $_POST['titulo_serie2']);
        $titulo4->setAttribute('duracion', $_POST['duracion_serie2']);
    
        $nuevoGeneroSeries->appendChild($titulo3);
        $nuevoGeneroSeries->appendChild($titulo4);
        $series->appendChild($nuevoGeneroSeries);
    
        // Guardar el nuevo XML
        $xml->save('nuevo_catalogovod.xml');
    
        echo '<a href="nuevo_catalogovod.xml" download>Descargar nuevo catálogo VOD</a>';
    }
?>