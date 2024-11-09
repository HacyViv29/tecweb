function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    //var JsonString = JSON.stringify(baseJSON,null,2);
    //document.getElementById("description").value = JsonString;

    // SE LISTAN TODOS LOS PRODUCTOS
    listarProductos();
    resetForm();
}

function resetForm(){
    document.getElementById('name').value = '';
    document.getElementById('precio').value = '';
    document.getElementById('unidades').value = '';
    document.getElementById('modelo').value = '';
    document.getElementById('marca').value = '';
    document.getElementById('detalles').value = '';
    document.getElementById('imagen').value = 'img/imagen.png';

    //var JsonString = JSON.stringify(baseJSON,null,2);
    //document.getElementById("description").value = JsonString;
}

function listarProductos(){
    $.ajax({
        url: './backend/product-list.php',
        type: 'GET',
        success: function(response){
            let productos = JSON.parse(response);
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if(Object.keys(productos).length > 0) {
                // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                let template = '';

                productos.forEach(producto => {
                    // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                    let descripcion = '';
                    descripcion += '<li>precio: '+producto.precio+'</li>';
                    descripcion += '<li>unidades: '+producto.unidades+'</li>';
                    descripcion += '<li>modelo: '+producto.modelo+'</li>';
                    descripcion += '<li>marca: '+producto.marca+'</li>';
                    descripcion += '<li>detalles: '+producto.detalles+'</li>';
                
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>
                                <a href="#" class="product-item">${producto.nombre}</a>
                            </td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                $('#products').html(template);
            }
        }
    });
}

$(document).ready(function() {
    init();
    let edit = false;
    $('#product-form button[type="submit"]').text('Agregar Producto');
    
    // SE ASIGNA EL EVENTO CLICK AL BOTON DE BUSCAR
    $("#search").keyup(function() {
        if($('#search').val()){
            let search = $('#search').val();
            $.ajax({
                url: './backend/product-search.php',
                type: 'GET',
                data: {search},
                success: function(response) {
                    let productos = JSON.parse(response);
                    
                    // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
                    if(Object.keys(productos).length > 0) {
                        // SE CREA UNA PLANTILLA PARA CREAR LAS FILAS A INSERTAR EN EL DOCUMENTO HTML
                        let template = '';
                        let template_bar = '';

                        productos.forEach(producto => {
                            // SE COMPRUEBA QUE SE OBTIENE UN OBJETO POR ITERACIÓN
                            //console.log(producto);

                            // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                            let descripcion = '';
                            descripcion += '<li>precio: '+producto.precio+'</li>';
                            descripcion += '<li>unidades: '+producto.unidades+'</li>';
                            descripcion += '<li>modelo: '+producto.modelo+'</li>';
                            descripcion += '<li>marca: '+producto.marca+'</li>';
                            descripcion += '<li>detalles: '+producto.detalles+'</li>';
                        
                            template += `
                                <tr productId="${producto.id}">
                                    <td>${producto.id}</td>
                                    <td>${producto.nombre}</td>
                                    <td><ul>${descripcion}</ul></td>
                                    <td>
                                        <button class="product-delete btn btn-danger">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            `;

                            template_bar += `
                                <li>${producto.nombre}</il>
                            `;
                        });
                        // SE HACE VISIBLE LA BARRA DE ESTADO
                        $('#product-result').removeClass('d-none');
                        // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                        $('#container').html(template_bar);  
                        // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                        $('#products').html(template);
                    }
                }
            });
        }
    });

    // SE ASIGNA EL EVENTO CLICK AL BOTON DE AGREGAR
    $('#product-form').submit(function(e){
        e.preventDefault();
        
        if(!verifFinal(edit)){
            return;
        }

        //SE OBTIENEN LOS VALORES DE LOS INPUTS
        let nombre = document.getElementById('name').value;
        let precio = document.getElementById('precio').value;
        let unidades = document.getElementById('unidades').value;
        let modelo = document.getElementById('modelo').value;
        let marca = document.getElementById('marca').value;
        let detalles = document.getElementById('detalles').value;
        let imagen = document.getElementById('imagen').value;
        let id = document.getElementById('productId').value;
    
        // CREAR UN OBJETO JSON
        let finalJSON = {
            'nombre': nombre,
            'precio': precio,
            'unidades': unidades,
            'modelo': modelo,
            'marca': marca,
            'detalles': detalles,
            'imagen': imagen,
            'id': id
        };
        
        //Derterminar la URL del archivo PHP
        let url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
        
        $.ajax({
            url: url,
            type: 'POST',
            data: JSON.stringify(finalJSON), // Convertir el objeto JSON a string
            contentType: 'application/json; charset=utf-8', // Enviar como JSON
            success: function(response) {
                console.log(response);  // Mostrar la respuesta del servidor

                let template_bar = '';
                let respuesta = JSON.parse(response);
                
                template_bar += `
                        <li style="list-style: none;">status: ${respuesta.status}</li>
                        <li style="list-style: none;">message: ${respuesta.message}</li>
                    `;
                
                $('#product-result').removeClass('d-none');
                $('#container').html(template_bar);
                
                edit = false;  // Reiniciar el modo de edición
                $('#product-form button[type="submit"]').text('Agregar Producto');
                resetForm();
                listarProductos();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud:', textStatus, errorThrown);  // Manejo de errores
            }
        });
    });

    // SE ASIGNA EL EVENTO CLICK AL BOTON DE ELIMINAR
    $(document).on('click', '.product-delete', function() {
        if (confirm('De verdad deseas eliminar el Producto?')) {
            let id = $(this).closest('tr').attr('productId');

            $.ajax({
                url: './backend/product-delete.php',
                type: 'GET',
                data: {id},
                success: function(response){
                    // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                    let respuesta = JSON.parse(response);
                    // SE CREA UNA PLANTILLA PARA CREAR INFORMACIÓN DE LA BARRA DE ESTADO
                    let template_bar = `
                        <li>status: ${respuesta.status}</li>
                        <li>message: ${respuesta.message}</li>
                    `;

                    // SE HACE VISIBLE LA BARRA DE ESTADO
                    $('#product-result').removeClass('d-none');
                    // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                    $('#container').html(template_bar);
                    
                    // SE LISTAN TODOS LOS PRODUCTOS
                    listarProductos();
                }
            });
        }
    });
    
    $(document).on('click', '.product-item', function(){
        let id = $(this)[0].parentElement.parentElement.getAttribute('productId');

        $.post('./backend/product-single.php', {id}, function(response){
            const product = JSON.parse(response);
            $('#productId').val(product[0].id);

            $('#name').val(product[0].nombre);
            
            $('#precio').val(product[0].precio);

            $('#unidades').val(product[0].unidades);

            $('#modelo').val(product[0].modelo);

            $('#marca').val(product[0].marca);

            $('#detalles').val(product[0].detalles);

            $('#imagen').val(product[0].imagen);

            edit = true;
            $('#product-form button[type="submit"]').text('Actualizar Producto');
        })
    });

    // VALIDAR NOMBRE
    $("#name").on("blur",function() {
        verifNombre(edit).then(function(isValid) {
            if (isValid) {
                ocultarBarraEstado();
            }
        });
    });

    // VALIDAR PRECIO
    $("#precio").on("blur", function() {
        if(verifPrecio()){
            ocultarBarraEstado();
        }
    });

    //VALIDAR UNIDADES
    $("#unidades").on("blur", function() {
        if(verifUnidades()){
            ocultarBarraEstado();
        }
    });

    // VALIDAR MODELO
    $("#modelo").on("blur",function() {
        if(verifModelo()){
            ocultarBarraEstado();
        }
    });

    //VALIDAR MARCA
    $("#marca").on("blur",function() {
        if(verifMarca()){
            ocultarBarraEstado();
        }
    });

    //VALIDAR DETALLES
    $("#detalles").on("blur",function() {
        if(verifDetalles()){
            ocultarBarraEstado();
        }
    });

    //VALIDAR IMAGEN
    $("#imagen").on("blur",function() {
        if(verifImagen()){
            ocultarBarraEstado();
        }
    });
});


async function verifNombre(edit){
    var final = true;
    let status = 'success';
    let message = "Validación exitosa"
    var nombre = document.getElementById('name').value;
    
    if(nombre.length == 0){
        status = 'error';
        message = 'El nombre es un requisito requerido.';
        final = false;
    } 
    else{
        if(nombre.length > 100){
            status = 'error';
            message = 'El nombre debe de tener 100 caracteres o menos.';
            final = false;
        }
        else{
            if (edit == false) {
                try {
                    // Esperamos la respuesta de la validación asincrónica
                    const product = await verificarAsy(nombre);

                    if (product && product.length > 0) {
                        status = "error";
                        message = "El nombre ya está registrado";
                        final = false;
                    }
                } catch (error) {
                }
            }
        }
    }

    console.log(status);
    console.log(message);
    console.log(final);

    if(final == false){
        mostrarBarraVerif(status, message);
    }

    return (final);
}

function verificarAsy(nombre) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: "./backend/product-singleByName.php",  // ruta al archivo PHP
            data: { name: nombre },
            success: function(response) {
                console.log("Respuesta del servidor:", response); // Ver la respuesta antes de parsear
                try {
                    let product = JSON.parse(response);
                    resolve(product);  // Resolvemos la promesa con la respuesta
                } catch (e) {
                    reject("Error al parsear la respuesta del servidor");
                }
            },
            error: function(xhr, status, error) {
                reject(error);  // Rechazamos la promesa si hay un error
            }
        });
    });
}


function verifPrecio(){
var final = true;
let status = 'success';
let message = "Validación exitosa"
var precio = document.getElementById('precio').value;

    if(precio.length == 0){
        status = 'error';
        message = 'El modelo es un requisito requerido.';
        final = false;
    }
    else{
        var aux = parseFloat(precio);
        if(aux < 99.99){
            status = 'error';
            message = 'El precio debe de ser mayor a $ 99.99.';
            final = false;
        }
    }
    
    if(final == false){
        mostrarBarraVerif(status, message);
    }

    return (final);
}

function verifUnidades(){
    var final = true;
    let status = 'success';
    let message = "Validación exitosa"
    var unidades = document.getElementById('unidades').value;
    var aux = parseInt(unidades);
    
    if(unidades.length == 0){
        status = 'error';
        message = 'Las unidades son un requisito requerido.';
        final = false;
    }
    else{
        if(aux < 0){
            status = 'error';
            message = 'Las unidades deben ser mayor o igual a 0.';
            final = false;
        }
    }

    if(final == false){
        mostrarBarraVerif(status, message);
    }

    return (final);
}

function verifModelo(){
    var final = true;
    let status = 'success';
    let message = "Validación exitosa"
    var modelo = document.getElementById('modelo').value;
    
    if(modelo.length == 0){
        status = 'error';
        message = 'El modelo es un requisito requerido.';
        final = false;
    }
    else{
        if(!/^[A-Za-z0-9 ]+$/.test(modelo)){
            status = 'error';
            message = 'El modelo debe de estar escrito en formato alfanumerico.';
            final = false;
        }
        else{
            if(modelo.length > 25){
                status = 'error';
                message = 'El modelo debe de tener menos de 25 caracteres.';
                final = false;
            }
        }
    }

    if(final == false){
        mostrarBarraVerif(status, message);
    }

    return (final);
}

function verifMarca(){
    var final = true;
    let status = 'success';
    let message = "Validación exitosa"
    var marca = document.getElementById('marca').value;
    let marcas = ["HP", "Asus", "Acer", "Huawei"];
    
    if(marca.length == 0){
        status = 'error';
        message = 'La marca es un requisito requerido.';
        final = false;
    }
    else{
        if(!marcas.includes(marca)){
            status = 'error';
            message = 'Elije una de las marcas predefinidas.';
            final = false;
        }
    }

    if(final == false){
        mostrarBarraVerif(status, message);
    }

    return (final);
}

function verifDetalles(){
    var final = true;
    let status = 'success';
    let message = "Validación exitosa"
    var detalles = document.getElementById('detalles').value;
    
    if(detalles.length == 0){
        document.getElementById('detalles').value = "S/D"
    }
    else{
        if (detalles.length > 250){
            status = 'error';
            message = 'Los detalles deben de tener 250 caracteres o menos.';
            final = false;
        }
    }

    if(final == false){
        mostrarBarraVerif(status, message);
    }

    return (final);
}

function verifImagen(){
    var final = true;
    let status = 'success';
    let message = "Validación exitosa"
    var imagen = document.getElementById('imagen').value;
    
    if(imagen.length == 0){
        imagen = 'img/imagen.png';
    }

    if(final == false){
        mostrarBarraVerif(status, message);
    }

    return (final);
}

function mostrarBarraVerif(status, message){
    let template_bar = '';
    template_bar += `
        <li style="list-style: none;">status: ${status}</li>
        <li style="list-style: none;">message: ${message}</li>
    `;
    // SE HACE VISIBLE LA BARRA DE ESTADO
    document.getElementById("product-result").className = "card my-4 d-block";
    // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
    document.getElementById("container").innerHTML = template_bar;
}

function ocultarBarraEstado(){
    // SE OCULTA LA BARRA DE ESTADO
    document.getElementById("product-result").className = "d-none";
}

function verifFinal(edit){
    var final = true;

    for(var i=1; i<8; i++){
        switch(i){
            case 1: final = verifNombre(edit);
                    if(final == false){
                        i = 8;
                    }
                    break;
            case 2: final = verifPrecio();
                    if(final == false){
                        i = 8;
                    }
                    break;
            case 3: final = verifUnidades();
                    if(final == false){
                        i = 8;
                    }
                    break;
            case 4: final = verifModelo();
                    if(final == false){
                        i = 8;
                    }
                    break;
            case 5: final = verifMarca();
                    if(final == false){
                        i = 8;
                    }
                    break; 
            case 6: final = verifDetalles();
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
