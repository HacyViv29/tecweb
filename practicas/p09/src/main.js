function verifNombre(){
    var nombre = document.getElementById('form-nombre').value.trim();
    var final = true;

    if(nombre.length == 0){
        alert('El nombre es un requisito requerido.');
        final = false;
    }
    else{
        if(nombre.length > 100){
            alert('El nombre debe de tener 100 caracteres o menos.');
            final = false;
        }
    }

    return (final);
}

function verifMarca(){
    var marca = document.getElementById('form-marca').value.trim();
    var final = true;

    if(marca.length == 0){
        alert('La marca es un requisito requerido.');
        final = false;
    }

    return (final);

}

function verifModelo(){
    var modelo = document.getElementById('form-modelo').value.trim();
    var final = true;

    if(modelo.length == 0){
        alert('El modelo es un requisito requerido.');
        final = false;
    }
    else{
        if(!/^[A-Za-z0-9 ]+$/.test(modelo)){
            alert('El modelo debe de estar escrito en formato alfanumerico.');
            final = false;
        }
        else{
            if(modelo.length > 25){
                alert('El modelo debe de tener menos de 25 caracteres.');
                final = false;
            }
        }
    }

    return (final);
}

function verifPrecio(){
    var precio = document.getElementById('form-precio').value.trim();
    var final = true;

    if(precio.length == 0){
        alert('El modelo es un requisito requerido.');
        final = false;
    }
    else{
        var aux = parseFloat(precio);
        if(aux < 99.99){
            alert('El precio debe de ser mayor a $ 99.99.');
            final = false;
        }
    }

    return (final);
}

function verifDetalles(){
    var detalles = document.getElementById('form-detalles').value.trim();
    var final = true;

    if (detalles.length > 250){
        alert('Los detalles deben de tener 250 caracteres o menos.');
        final = false;
    }

    return (final);
}

function verifUnidades(){
    var unidades = document.getElementById('form-unidades').value.trim();
    var aux = parseInt(unidades);
    var final = true;

    if(unidades.length == 0){
        alert('Las unidades son un requisito requerido.');
        final = false;
    }
    else{
        if(aux < 0){
            alert('El precio debe ser mayor o igual a 0.');
            final = false;
        }
    }

    return (final);
}

function verifImagen(){
    var imagen = document.getElementById('form-imagen').value.trim();

    if(imagen.length == 0){
        document.getElementById('form-imagen').value = 'img/imagen.png';
    }
    return (true);
}

function verifFinal(){
    var final = true;

    for(var i=1; i<8; i++){
        switch(i){
            case 1: final = verifNombre();
                    if(final == false){
                        i = 8;
                    }
                    break;
            case 2: final = verifMarca();
                    if(final == false){
                        i = 8;
                    }
                    break;
            case 3: final = verifModelo();
                    if(final == false){
                        i = 8;
                    }
                    break;
            case 4: final = verifPrecio();
                    if(final == false){
                        i = 8;
                    }
                    break;
            case 5: final = verifDetalles();
                    if(final == false){
                        i = 8;
                    }
                    break;
            case 6: final = verifUnidades();
                    if(final == false){
                        i = 8;
                    }
                    break;
            case 7: final = verifImagen();
                    if(final == false){
                        i = 8;
                    }
                    break;
            default: final=false;
        }
    }

    return(final);
}

function limpiar(control){
    control.value = '';
}

function send2form() {
     // se obtiene el id de la fila donde está el botón presinado
    var rowId = event.target.parentNode.parentNode.id;

     // se obtienen los datos de la fila en forma de arreglo
    var data = document.getElementById(rowId).querySelectorAll(".row-data");
    
    /**
    querySelectorAll() devuelve una lista de elementos (NodeList) que 
    coinciden con el grupo de selectores CSS indicados.
    (ver: https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Selectors)

    En este caso se obtienen todos los datos de la fila con el id encontrado
    y que pertenecen a la clase "row-data".
     */

    var nombre = data[1].innerHTML;
    var marca = data[2].innerHTML;
    var modelo = data[3].innerHTML;
    var precio= data[4].innerHTML;
    var unidades = data[5].innerHTML;
    var detalles = data[6].innerHTML;
    var imagen = data[7].firstChild.getAttribute('src');
    
    var form = document.createElement("form");

    var nombreIn = document.createElement("input");
    nombreIn.type = 'text';
    nombreIn.name = 'nombre';
    nombreIn.value = nombre;
    form.appendChild(nombreIn);

    var marcaIn = document.createElement("input");
    marcaIn.type = 'text';
    marcaIn.name = 'marca';
    marcaIn.value = marca;
    form.appendChild(marcaIn);

    var modeloIn = document.createElement("input");
    modeloIn.type = 'text';
    modeloIn.name = 'modelo';
    modeloIn.value = modelo;
    form.appendChild(modeloIn);

    var precioIn = document.createElement("input");
    precioIn.type = 'number';
    precioIn.name = 'precio';
    precioIn.value = precio;
    form.appendChild(precioIn);

    var detallesIn = document.createElement("input");
    detallesIn.type = 'text';
    detallesIn.name = 'detalles';
    detallesIn.value = detalles;
    form.appendChild(detallesIn);

    var unidadesIn = document.createElement("input");
    unidadesIn.type = 'number';
    unidadesIn.name = 'unidades';
    unidadesIn.value = unidades;
    form.appendChild(unidadesIn);

    var imagenIn = document.createElement("input");
    imagenIn.type = 'text';
    imagenIn.name = 'imagen';
    imagenIn.value = imagen;
    form.appendChild(imagenIn);

    console.log(form);

    form.method = 'POST';
    form.action = '../p09/formulario_productos_v2.php';  

    document.body.appendChild(form);
    form.submit();
}