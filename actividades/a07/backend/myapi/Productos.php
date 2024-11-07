<?php
    namespace backend\myapi;
    use backend\myapi\DataBase;

    require_once __DIR__ . '/DataBase.php';

    class Productos extends DataBase {
        private $data;

        public function __construct( $db, $user='root', $pass='Buap123') {
            $this->data = array();
            parent::__construct( $db, $user, $pass);
        }

        public function add($jsonOBJ){
            $this->data = array(
                'status'  => 'error',
                'message' => 'Ya existe un producto con ese nombre'
            );
            if(!empty($jsonOBJ)) {
                // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
                $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
                $result = $this->conexion->query($sql);
                
                if ($result->num_rows == 0) {
                    $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
                    if($this->conexion->query($sql)){
                        $this->data['status'] =  "success";
                        $this->data['message'] =  "Producto agregado";
                    } else {
                        $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
                    }
                }

                $result->free();
                $this->conexion->close();
            }
        }

        public function delete($id){
            // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
            $this->data = array(
                'status'  => 'error',
                'message' => 'La consulta falló'
            );
            // SE VERIFICA HABER RECIBIDO EL ID
            if(isset($id)) {
                // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
                $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
                if ( $this->conexion->query($sql) ) {
                    $this->data['status'] =  "success";
                    $this->data['message'] =  "Producto eliminado";
                } else {
                    $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
                }
                $this->conexion->close();
            } 
        }

        public function edit($jsonOBJ){
            $this->data = array(
                'status'  => 'error',
                'message' => 'No se encontró el producto o ocurrió un error'
            );

            //SE VERIFICA QUE EL PRODUCTO NO ESTE VACIO
            if(!empty($jsonOBJ)){

                if(isset($jsonOBJ->id)){
                    // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
                    $sql = "SELECT * FROM productos WHERE id = '{$jsonOBJ->id}' AND eliminado = 0";
                    $result = $this->conexion->query($sql);
                    
                    //SE VERIFICA QUE EXISTA EL PRODUCTO
                    if ($result->num_rows > 0) {
                        $sql = "UPDATE productos SET
                                    nombre = '{$jsonOBJ->nombre}',
                                    marca = '{$jsonOBJ->marca}',
                                    modelo = '{$jsonOBJ->modelo}',
                                    precio = {$jsonOBJ->precio},
                                    detalles = '{$jsonOBJ->detalles}',
                                    unidades = {$jsonOBJ->unidades},
                                    imagen = '{$jsonOBJ->imagen}'
                                WHERE id = '{$jsonOBJ->id}' AND eliminado = 0";
                        
                        if($this->conexion->query($sql)){
                            $this->data['status'] =  "success";
                            $this->data['message'] =  "Producto Actualizado correctamente";
                        } else {
                            $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
                        }
                    }else{
                        // NO SE ENCONTRÓ EL PRODUCTO
                        $this->data['message'] = "No se encontró el producto con el nombre especificado.";
                    }

                    $result->free();
                } else {
                    // Error si no se envió el nombre
                    $this->data['message'] = "El nombre del producto no fue proporcionado en el JSON.";
                }
                $this->conexion->close();
            }
        }

        public function list(){
            $this->data = array();
            // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
            if ( $result = $this->conexion->query("SELECT * FROM productos WHERE eliminado = 0") ) {
                // SE OBTIENEN LOS RESULTADOS
                $rows = $result->fetch_all(MYSQLI_ASSOC);

                if(!is_null($rows)) {
                    // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                    foreach($rows as $num => $row) {
                        foreach($row as $key => $value) {
                            $this->data[$num][$key] = utf8_encode($value);
                        }
                    }
                }
                $result->free();
            } else {
                die('Query Error: '.mysqli_error($this->conexion));
            }
            $this->conexion->close();
        }

        public function search($dato){
            $this->data = array();
            // SE VERIFICA HABER RECIBIDO EL ID
            if( isset($dato) ) {
                $search = $dato;
                // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
                $sql = "SELECT * FROM productos WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0";
                if ( $result = $this->conexion->query($sql) ) {
                    // SE OBTIENEN LOS RESULTADOS
                    $rows = $result->fetch_all(MYSQLI_ASSOC);

                    if(!is_null($rows)) {
                        // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                        foreach($rows as $num => $row) {
                            foreach($row as $key => $value) {
                                $data[$num][$key] = utf8_encode($value);
                            }
                        }
                    }
                    $result->free();
                } else {
                    die('Query Error: '.mysqli_error($this->conexion));
                }
                $this->conexion->close();
            } 
        }

        public function single($id){
            if(isset($id)){
                $this->data = array();
        
                // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
                $sql = "SELECT * FROM productos WHERE id = '{$id}'";
                if ( $result = $this->conexion->query($sql) ) {
                    // SE OBTIENEN LOS RESULTADOS
                    $rows = $result->fetch_all(MYSQLI_ASSOC);
        
                    if(!is_null($rows)) {
                        // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                        foreach($rows as $num => $row) {
                            foreach($row as $key => $value) {
                                $this->data[$num][$key] = utf8_encode($value);
                            }
                        }
                    }
                    $result->free();
                } else {
                    die('Query Error: '.mysqli_error($this->conexion));
                }
                $this->conexion->close();
            }
        }

        public function singleByName($nombre){
            if(isset($nombre)){
                $this->data = array();
        
                // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
                $sql = "SELECT * FROM productos WHERE nombre = '{$nombre}'";
                if ( $result = $this->conexion->query($sql) ) {
                    // SE OBTIENEN LOS RESULTADOS
                    $rows = $result->fetch_all(MYSQLI_ASSOC);
        
                    if(!is_null($rows)) {
                        // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                        foreach($rows as $num => $row) {
                            foreach($row as $key => $value) {
                                $this->data[$num][$key] = utf8_encode($value);
                            }
                        }
                    }
                    $result->free();
                } else {
                    die('Query Error: '.mysqli_error($this->conexion));
                }
                $this->conexion->close();
            }
        }

        public function getData(){
            return json_encode($this->data, JSON_PRETTY_PRINT);
        }

    }
?>