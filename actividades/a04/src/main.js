function getDatos(){
    var nombre = prompt('Nombre: ', '');
    var edad = prompt('Edad: ', 0);

    var div1 = document.getElementById('nombre');
    div1.innerHTML = '<h3>Nombre: '+nombre+'</h3>';
    
    var div2 = document.getElementById('edad');
    div2.innerHTML = '<h3>Edad: '+edad+'</h3>';
}

function ejemplo1(){
    document.write('Hola Mundo');
}

function ejemplo2(){
    var nombre = 'Juan';
    var edad = 10;
    var altura = 1.92;
    var casado = false;
    document.write(nombre);
    document.write('<br>');
    document.write(edad);
    document.write('<br>');
    document.write(altura);
    document.write('<br>');
    document.write(casado);
}

function ejemplo3(){
    var nombre;
    var edad;
    nombre = prompt('Ingresa tu nombre:', '');
    edad = prompt('Ingresa tu edad:', '');
    document.write('Hola ');
    document.write(nombre);
    document.write(' así que tienes ');
    document.write(edad);
    document.write(' años');
}

function ejemplo4(){
    var valor1;
    var valor2;
    valor1 = prompt('Introducir primer número:', '');
    valor2 = prompt('Introducir segundo número', '');
    var suma = parseInt(valor1)+parseInt(valor2);
    var producto = parseInt(valor1)*parseInt(valor2);
    document.write('La suma es ');
    document.write(suma);
    document.write('<br>');
    document.write('El producto es ');
    document.write(producto);
}