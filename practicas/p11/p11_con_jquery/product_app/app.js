// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
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
            success: function(renponse){
                // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
                let respuesta = JSON.parse(client.responseText);
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
