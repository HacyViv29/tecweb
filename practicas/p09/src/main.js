function verifNombre(){
    var nombre = document.getElementById('form-nombre').value.trim();
    
    if(nombre.length == 0){
        alert('El nombre es un requisito requerido.');
    }
    else{
        if(nombre.length > 10){
            alert('El nombre debe de tener 100 caracteres o menos.');
        }
    }
}

function verifMarca(){
    var marca = document.getElementById('form-marca').value.trim();

    if(marca.length == 0){
        alert('La marca es un requisito requerido.');
    }

}

function verifModelo(){
    var modelo = document.getElementById('form-modelo').value.trim();

    if(modelo.length == 0){
        alert('El modelo es un requisito requerido.');
    }
    else{
        if(!/^[A-Za-z0-9]+$/.test(modelo)){
            alert('El modelo debe de estar escrito en formato alfanumerico.');
        }
        else{
            if(modelo.length > 25){
                alert('El modelo debe de tener menos de 25 caracteres.');
            }
        }
    }
}

function verifPrecio(){
    var precio = document.getElementById('form-precio').value.trim();
    
    if(precio.length == 0){
        alert('El modelo es un requisito requerido.');
    }
    else{
        var aux = parseFloat(precio);
        if(aux < 99.99){
            alert('El precio debe de ser mayor a $ 99.99.');
        }
    }
}

function verifDetalles(){
    var detalles = document.getElementById('form-detalles').value.trim();

    if (detalles.length > 250){
        alert('Los detalles deben de tener 250 caracteres o menos.');
    }
}

function verifUnidades(){
    var unidades = document.getElementById('form-unidades').value.trim();
    var aux = parseInt(unidades);

    if(unidades.length == 0){
        alert('Las unidades son un requisito requerido.');
    }
    else{
        if(aux < 0){
            alert('El precio debe ser mayor o igual a 0.');
        }
    }
}

function verifImagen(){
    var imagen = document.getElementById('form-imagen').value.trim();

    if(imagen.length == 0){
        document.getElementById('form-imagen').value = 'img/imagen.png';
    }
}

function limpiar(control){
    control.value = '';
}