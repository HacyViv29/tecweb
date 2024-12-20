// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

// FUNCIÓN CALLBACK DE BOTÓN "Buscar por ID"
function buscarID(e) {
    /**
     * Revisar la siguiente información para entender porqué usar event.preventDefault();
     * http://qbit.com.mx/blog/2013/01/07/la-diferencia-entre-return-false-preventdefault-y-stoppropagation-en-jquery/#:~:text=PreventDefault()%20se%20utiliza%20para,escuche%20a%20trav%C3%A9s%20del%20DOM
     * https://www.geeksforgeeks.org/when-to-use-preventdefault-vs-return-false-in-javascript/
     */
    e.preventDefault();

    // SE OBTIENE EL ID A BUSCAR
    var id = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);    // similar a eval('('+client.responseText+')');
            
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if(Object.keys(productos).length > 0) {
                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                let descripcion = '';
                    descripcion += '<li>precio: '+productos.precio+'</li>';
                    descripcion += '<li>unidades: '+productos.unidades+'</li>';
                    descripcion += '<li>modelo: '+productos.modelo+'</li>';
                    descripcion += '<li>marca: '+productos.marca+'</li>';
                    descripcion += '<li>detalles: '+productos.detalles+'</li>';
                
                // SE CREA UNA PLANTILLA PARA CREAR LA(S) FILA(S) A INSERTAR EN EL DOCUMENTO HTML
                let template = '';
                    template += `
                        <tr>
                            <td>${productos.id}</td>
                            <td>${productos.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;

                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            }
        }
    };
    client.send("id="+id);
}


// FUNCIÓN CALLBACK DE BOTÓN "Buscar Productos"
function buscarProductos(e) {
    /**
     * Revisar la siguiente información para entender porqué usar event.preventDefault();
     * http://qbit.com.mx/blog/2013/01/07/la-diferencia-entre-return-false-preventdefault-y-stoppropagation-en-jquery/#:~:text=PreventDefault()%20se%20utiliza%20para,escuche%20a%20trav%C3%A9s%20del%20DOM
     * https://www.geeksforgeeks.org/when-to-use-preventdefault-vs-return-false-in-javascript/
     */
    e.preventDefault();

    // SE OBTIENEN LAS VARIABLES A BUSCAR
    var dato = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);

            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);    // similar a eval('('+client.responseText+')');

            // SE LIMPIA LA TABLA ANTES DE INSERTAR NUEVOS RESULTADOS
            document.getElementById("productos").innerHTML = "";

            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if(productos.length > 0) {
                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                let template = '';
                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += `<li>precio: ${producto.precio !== undefined ? producto.precio : 'No disponible'}</li>`;
                    descripcion += `<li>unidades: ${producto.unidades !== undefined ? producto.unidades : 'No disponible'}</li>`;
                    descripcion += `<li>modelo: ${producto.modelo !== undefined ? producto.modelo : 'No disponible'}</li>`;
                    descripcion += `<li>marca: ${producto.marca !== undefined ? producto.marca : 'No disponible'}</li>`;
                    descripcion += `<li>detalles: ${producto.detalles !== undefined ? producto.detalles : 'No disponible'}</li>`;

                // SE CREA UNA PLANTILLA PARA CREAR LA(S) FILA(S) A INSERTAR EN EL DOCUMENTO HTML
                template += `
                        <tr>
                            <td>${producto.id !== undefined ? producto.id : 'No disponible'}</td>
                            <td>${producto.nombre !== undefined ? producto.nombre : 'No disponible'}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;
                });

                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            }
            else{
                
                // Caso cuando no hay productos con esa descripción
                document.getElementById("productos").innerHTML = '<tr><td colspan="3">No se encontraron productos.</td></tr>';
            }
        }
    };
    client.send("dato=" + encodeURIComponent(dato));
}

// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();

    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = document.getElementById('description').value;
    // SE CONVIERTE EL JSON DE STRING A OBJETO
    var finalJSON = JSON.parse(productoJsonString);
    // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
    finalJSON['nombre'] = document.getElementById('name').value;
    
    //VALIDAR EL OBJETO JSON ANTES DE ENVIARLO AL BD
    if(!verifJSON(finalJSON)){
        //Si falla la validación, se cancela la operación
        return;
    }
    
    // SE OBTIENE EL STRING DEL JSON FINAL
    productoJsonString = JSON.stringify(finalJSON,null,2);

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log(client.responseText);
            let response = JSON.parse(client.responseText);
            if(response.success){
                //Mensaje de éxito de la operación
                window.alert(response.message);
            }
            else{
                window.alert('Error: '+ response.message);
            }
        }
    };
    client.send(productoJsonString);
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try{
        objetoAjax = new XMLHttpRequest();
    }catch(err1){
        /**
         * NOTA: Las siguientes formas de crear el objeto ya son obsoletas
         *       pero se comparten por motivos historico-académicos.
         */
        try{
            // IE7 y IE8
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(err2){
            try{
                // IE5 y IE6
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(err3){
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}

function verifNombre(){
    var nombre = document.getElementById('name').value.trim();
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

function verifMarca(json){
    var marca = json.marca;
    var final = true;
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

    return (final);

}

function verifModelo(json){
    var modelo = json.modelo;
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

function verifPrecio(json){
    var precio = json.precio;
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

function verifDetalles(json){
    var detalles = json.detalles;
    var final = true;

    if (detalles.length > 250){
        alert('Los detalles deben de tener 250 caracteres o menos.');
        final = false;
    }

    return (final);
}

function verifUnidades(json){
    var unidades = json.precio;
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

function verifImagen(json){
    var imagen = json.imagen;

    if(imagen.length == 0){
        document.getElementById('form-imagen').value = 'img/imagen.png';
    }
    return (true);
}

function verifJSON(json){
    var final = true;

    for(var i=1; i<8; i++){
        switch(i){
            case 1: final = verifNombre(json);
                    if(final == false){
                        i = 8;
                    }
                    break;
            case 2: final = verifMarca(json);
                    if(final == false){
                        i = 8;
                    }
                    break;
            case 3: final = verifModelo(json);
                    if(final == false){
                        i = 8;
                    }
                    break;
            case 4: final = verifPrecio(json);
                    if(final == false){
                        i = 8;
                    }
                    break;
            case 5: final = verifDetalles(json);
                    if(final == false){
                        i = 8;
                    }
                    break;
            case 6: final = verifUnidades(json);
                    if(final == false){
                        i = 8;
                    }
                    break;
            case 7: final = verifImagen(json);
                    if(final == false){
                        i = 8;
                    }
                    break;
            default: final=false;
        }
    }

    return(final);
}