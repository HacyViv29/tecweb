// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/imagen.png"
  };

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;

    // SE LISTAN TODOS LOS PRODUCTOS
    listarProductos();
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
                            <td>${producto.nombre}</td>
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
        let productoJsonString = $('#description').val();
        let finalJSON = JSON.parse(productoJsonString);
        finalJSON['nombre'] = $('#name').val();
        $.ajax({
            url: './backend/product-add.php',
            type: 'POST',
            data: JSON.stringify(finalJSON),
            contentType: 'application/json',
            success: function(response){
                if(verifJSON(finalJSON)){
                    // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                    let respuesta = JSON.parse(response);
                    // SE CREA UNA PLANTILLA PARA CREAR INFORMACIÓN DE LA BARRA DE ESTADO
                    let template_bar = '';
                    template_bar += `
                                <li style="list-style: none;">status: ${respuesta.status}</li>
                                <li style="list-style: none;">message: ${respuesta.message}</li>
                            `;

                    // SE HACE VISIBLE LA BARRA DE ESTADO
                    $('#product-result').removeClass('d-none');
                    // SE INSERTA LA PLANTILLA PARA LA BARRA DE ESTADO
                    $('#container').html(template_bar);

                    //SE LISTAN TODOS LOS PRODUCTOS
                    listarProductos();
                }
                //$('#product-form').trigger('reset');
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
    

});

function verifJSON(json){
    var final = true;

    for(var i=1; i<8; i++){
        switch(i){
            case 1: var nombre = json['nombre'];
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

                    if(final == false){
                        i = 8;
                    }
                    break;
            case 2: var marca = json.marca;
                    let marcas = ["HP", "Asus", "Acer", "Huawei"];
                
                    if(marca.length == 0){
                        alert('La marca es un requisito requerido.');
                        final = false;
                    }
                    else{
                        if(!marcas.includes(marca)){
                            alert('Elije una de las marcas predefinidas.');
                            final = false;
                        }
                    }

                    if(final == false){
                        i = 8;
                    }
                    break;
            case 3: var modelo = json.modelo;

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

                    if(final == false){
                        i = 8;
                    }
                    break;
            case 4: var precio = json.precio;
                    
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

                    if(final == false){
                        i = 8;
                    }
                    break;
            case 5: var detalles = json.detalles;
                    var final = true;
                
                    if (detalles.length > 250){
                        alert('Los detalles deben de tener 250 caracteres o menos.');
                        final = false;
                    }

                    if(final == false){
                        i = 8;
                    }
                    break;
            case 6: var unidades = json.precio;
                    var aux = parseInt(unidades);
                    
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

                    if(final == false){
                        i = 8;
                    }
                    break;
            case 7: var imagen = json.imagen;

                    if(imagen.length == 0){
                        document.getElementById('form-imagen').value = 'img/imagen.png';
                    }

                    if(final == false){
                        i = 8;
                    }
                    break;
            default: final=false;
        }
    }

    return(final);
}