<?php
/**
 * Funcion para conectar a la base de datos
 * @return false|mysqli false si ha habido algún error o la conexión si ha ido bien
 */
function conectar()
{
    //declarar las variables de conexión

    $host = "localhost"; /* Nombre del servidor */
    $usuarioBD = "biblioteca"; /* Nombre del usuario */
    $passwordBD = "1234"; /* Contraseña */
    $nombreBD = "biblioteca"; /* Nombre de la base de datos */

    try {
        $conexion = mysqli_connect($host, $usuarioBD, $passwordBD, $nombreBD);
        return $conexion;
    } catch (Exception $e) {
        return false;
    }
}


function desconectar()
{
    $conexion = conectar();

    mysqli_close($conexion);
}

/**
 *  función para insertar un usuario en la base de datos
 * @param $user
 * @param $email
 * @param $nombre
 * @param $apellido_1
 * @param $apellido_2
 * @param $password
 * @param $rol
 * @return true|false true si se ha insertado correctamente o false si ha habido algún error
 * 
 */
function insertarUsuario($user, $email, $nombre, $apellido_1, $apellido_2, $password, $rol)
{
    $conexion = conectar();
    $fecha_registro = date("Y-m-d H:i:s");
    $sql = "INSERT INTO `usuario`(`nombre`, `primer_apellido`, `segundo_apellido`, `usuario`, `password`, `correo`, `fecha_registro`, `rol`) VALUES 
            ('$nombre', '$apellido_1', '$apellido_2', '$user', '$password', '$email', '$fecha_registro', '$rol')";
    try {

        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
          
            return true;
            
        } else {
           // Error en la consulta
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}


/**
 * Realiza el proceso de inicio de sesión de un usuario.
 *
 * @param string $user Nombre de usuario.
 * @param string $password Contraseña del usuario.
 * @return array|bool Retorna los datos del usuario si el inicio de sesión es exitoso, de lo contrario, retorna false.
 */
function login($user, $password)
{

    //Llamamos a la función para establecer conexión
    $conn = conectar();

    //consulta para validar que el usuario exista
    $comprobarUser = validarUsuario($user);
    
    if ($comprobarUser) {
        return false;
    } else {
        // recuperar el Password del user
    $sql = "SELECT password FROM usuario WHERE usuario='$user'";
        
    try {

        $resultado = mysqli_query($conn, $sql);
        $passwordBD = mysqli_fetch_assoc($resultado)['password'];
        if (password_verify($password, $passwordBD)) {
            //si es correcto, iniciar sesión

            //recuperar el datos del usuario
                $sql = "SELECT * FROM usuario WHERE usuario='$user'";

                $resultado = mysqli_query($conn, $sql);
                $datosUser = mysqli_fetch_assoc($resultado);
             


                return  $datosUser;
            } else {

                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

}


/**
 * Realiza el proceso de inicio de sesión de un usuario.
 *
 * @param string $user Nombre de usuario.
 * @param string $password Contraseña del usuario.
 * @return array|bool Retorna los datos del usuario si el inicio de sesión es exitoso, de lo contrario, retorna false.
 */
function validarUsuario($user,$email="")
{
    $conexion=conectar();
    $sql = "SELECT * FROM usuario WHERE usuario='$user' OR correo='$email'";  
    try {
        $resultado = mysqli_query($conexion, $sql);
        $numFilas = mysqli_num_rows($resultado);
        if ($numFilas > 0) {
            return false;
        } else {
            return true;
        }
    } catch (Exception $e) {
        return false;
    }

}


/**
 * funcion para ejecutar consultas a la base de datos
 * @param $conexion
 * @param $sql
 * @return array|bool false si ha habido algún error o un array con los datos de los libros
 */
function ejecutarConsulta($conexion, $sql)
{
    $librosEncontrados = array();

    try {
        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $librosEncontrados[] = $fila;
            }
            mysqli_free_result($resultado); // Libera la memoria asociada al resultado
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }

    return $librosEncontrados;
}


/**
 * funcion para calacular el total de libros
 * @param $op este parametro es para la busqueda por campo en la base de datos
 * @param $busqueda este parametro es para la busqueda por campo en la base de datos
 * 
 */

function totalLibros($op,$busqueda =false )
{
    $conexion = conectar(); 

    if ($conexion ) {
        try {
            if($busqueda==false){
                $sql = "SELECT COUNT(*) AS total FROM libros where  borrado=false  AND prestado=false;";
            }else{
                $busqueda = mysqli_real_escape_string($conexion, $busqueda); // Escapa los caracteres especiales
                $sql = "SELECT COUNT(*) AS total FROM libros where $op like '%$busqueda%' AND borrado=false  AND prestado=0 " ;
            }
            $resultado = mysqli_query($conexion, $sql);

            if ($resultado) {
                $fila = mysqli_fetch_assoc($resultado);
                $total = $fila['total'];
                mysqli_free_result($resultado);
                desconectar($conexion);
                return $total;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    return false;
}


/**
 * funcion para buscar libros 
 * @param $busqueda este parametro es para la busqueda por campo en la base de datos
 * @param $empezarDesde este parametro es para la paginacion
 * @param $tamanoPagina este parametro es para la paginacion
 * @param $op este parametro es para la busqueda por campo en la base de datos
 * @param $orderBy este parametro es para ordenar los libros por el campo que se le pase
 * @return array|bool false si ha habido algún error o un array con los datos de los libros
 */

function buscarLibrosPorTituloCon($busqueda, $empezarDesde, $tamanoPagina,$op)
{
    $conexion = conectar(); 

    if ($conexion) {
        try {
            $busqueda = mysqli_real_escape_string($conexion, $busqueda); // Escapa los caracteres especiales
            
            $sql = "SELECT * FROM libros WHERE $op LIKE '%$busqueda%' AND borrado=false  and prestado=0  LIMIT $empezarDesde, $tamanoPagina"; // Consulta con LIKE y paginación

            $librosEncontrados = ejecutarConsulta($conexion, $sql);
        

            desconectar($conexion); // Cierra la conexión a la base de datos

            return $librosEncontrados;
        } catch (Exception $e) {
            // Manejo de excepciones aquí
            return false;
        }
    }

    return false;
}

/**
 * funcion para insertar un libro en la base de datos
 * @param $titulo
 * @param $ISBN
 * @param $autor
 * @param $editorial
 * @return true|false true si se ha insertado correctamente o false si ha habido algún error
 */
function subirLibro($titulo, $ISBN, $autor, $editorial)
{
   
    try {
        $conexion = conectar();
        $sql = "INSERT INTO `libros`(`titulo`, `ISBN`, `autor`, `editorial`) VALUES 
                ('$titulo', '$ISBN', '$autor', '$editorial')";

        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
            return true;
            
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}


/**
 * funcion validarLibro para validar que el libro no este en la base de datos
 * @param $titulo
 * @param $ISBN
 * @param $autor
 * @param $editorial
 * @return true|false true si se ha insertado correctamente o false si ha habido algún error
 * 
 */

function validarLibro($titulo, $ISBN, $autor, $editorial)
{
   
    
    try {
        
        $conexion=conectar();
        $sql = "SELECT * FROM libros WHERE titulo='$titulo' AND ISBN='$ISBN' AND autor='$autor' AND editorial='$editorial'";
        $resultado = mysqli_query($conexion, $sql);
        $numFilas = mysqli_num_rows($resultado);
        if ($numFilas > 0) {
            return false;
        } else {
            return true;
        }
    } catch (Exception $e) {
        return false;
    }finally{
        mysqli_free_result($resultado);
        desconectar($conexion);
    }

}

/**
 * function borrarLibro con id o isbn
 * @param $id
 * @param $isbn
 * @return true|false true si se ha borrado correctamente o false si ha habido algún error
 */

function borrarLibro($id, $isbn)
{
    try {
        $conexion = conectar();
       // modificar el campo borrado a true en la tabla libros
       $sql = "UPDATE libros SET borrado=true WHERE id='$id' OR isbn='$isbn'";
        $resultado = mysqli_query($conexion, $sql);
        if ($resultado) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

/**
 *  function para insertar un prestamo en la base de datos
 * @param $usuario_id
 * @param $libro_id
 * @param $titulo
 * @return true|false true si se ha insertado correctamente o false si ha habido algún error
 */

function insertarPrestamo($usuario_id,$libro_id,$titulo){
    $action=true;
    $conexion = conectar();
    //fecha devolucion es la fecha actual + 15 dias
    $fecha_devolucion = date("Y-m-d H:i:s", strtotime("+15 days"));
    $sql = "INSERT INTO `prestamo`(`user_id`, `libro_id`, `fecha_devolucion`,`titulo_libro`) VALUES 
            ('$usuario_id', '$libro_id','$fecha_devolucion', '$titulo')";
    try {
        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
            libroPrestado($libro_id,$action);
            return $resultado;
        } else {
           return false;
        }
    } catch (mysqli_sql_exception $e) {
        return false;
    } finally {
        
    }
}


/**
 * function para devolver un libro
 * @param $usuario_id
 * @param $libro_id
 * @return true|false true si se ha insertado correctamente o false si ha habido algún error
 */
function Devolver_libro($libro_id,$user_id){
    $action=0;
    $sql = "UPDATE prestamo SET devuelto = TRUE WHERE libro_id = $libro_id AND user_id = $user_id";
    try {
        $conexion = conectar();
        $resultado = mysqli_query($conexion, $sql);
        
        if ($resultado) {
                    libroPrestado($libro_id,$action);
                   return $resultado;
        } else {
            return false;
        }
    } catch (mysqli_sql_exception $e) {
        return false;
    } finally {
                
    }
}

/**
 * function para ver Actualizar el estado de un libro 
 * @param $libro_id
 * @param $action 1 o true para poner el libro como prestado y 0 para ponerlo como no prestado
 * @return true|false true si se ha insertado correctamente o false si ha habido algún error
 * 
 */

function libroPrestado($libro_id,$action){
    $conexion = conectar();
    $sql = "UPDATE `libros` SET `prestado` = $action WHERE `id` = $libro_id";
  
    try {
        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
            return true;
        } else {
            return false;
        }
    } catch (mysqli_sql_exception $e) {
        return false;
    } finally {
        
    }
}

/**
 * funcion para mostrat los usuarios registrados en la base de datos devolviendo un array con los datos de los usuarios
 * @return array|false false si ha habido algún error o un array con los datos de los usuarios
 */

function mostrarUsuarios(){
    $conexion = conectar();
    $sql = "SELECT * FROM usuario";
    try {
        $resultado = mysqli_query($conexion, $sql);
        $usuarios = array();
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $usuarios[] = $fila;
            }
            return $usuarios;
            mysqli_free_result($resultado); // Libera la memoria asociada al resultado
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    } finally {
        desconectar($conexion); // Cierra la conexión a la base de datos
    }
  
}


/**
 * funcion para cambiar el rol de un usuario
 * @param $usuario_id
 * @param $usuario_rol
 * @return true|false true si se ha insertado correctamente o false si ha habido algún error
 */

function editarUsuario($usuario_id,$usuario_rol){
    if($usuario_rol=="admin" || $usuario_rol=="usuario"){
         $usuario_rol=$usuario_rol;
         $sql="UPDATE usuario SET rol='$usuario_rol' WHERE id='$usuario_id'";

        try {
            $conexion=conectar();
            $resultado=mysqli_query($conexion,$sql);

            if($resultado){
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
            return false;
        }finally{
            desconectar($conexion);
        }
    }else{
        return false;
    }
}

/**
 * funcion para ver los libros borrados
 * @return array|false false si ha habido algún error o un array con los datos de los libros
 */
function verLibrosBorrados(){
    $conexion = conectar();
    $sql = "SELECT * FROM libros WHERE borrado=true";
    try {
        $resultado = mysqli_query($conexion, $sql);
        $libros = array();
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $libros[] = $fila;
            }
            return $libros;
            mysqli_free_result($resultado); // Libera la memoria asociada al resultado
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    } finally {
        desconectar($conexion); // Cierra la conexión a la base de datos
    }
  
}


/**
 * funcion para activar un libro
 * @param $id
 * @return true|false true si se ha insertado correctamente o false si ha habido algún error
 */

function activarLibro($id){
    $conexion = conectar();
    $sql = "UPDATE libros SET borrado=0 WHERE id='$id'";
    try {
        $resultado = mysqli_query($conexion, $sql);
        if ($resultado) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    } finally {
        desconectar($conexion); // Cierra la conexión a la base de datos
    }
  
}


/**
 * function para recuperar los libros alquilados por un usuario
 * @param $iduser
 * @return array|false false si ha habido algún error o un array con los datos de los libros
 */

function consultaLibrosUser($iduser){
    $conexion=conectar();
    $sql="SELECT * FROM prestamo WHERE user_id='$iduser' AND devuelto='0'";
    try{
        $resultado=mysqli_query($conexion,$sql);
        $numFilas=mysqli_num_rows($resultado);
        if($numFilas>0){
            return $resultado;
        }else{
            return false;
        }
    }catch(Exception $e){
        return false;
    }
}


/**
 * function para paginar las tablas
 * @param $tabla
 * @param $por_pagina
 * @param $pagina
 * @param $borrado este parametro es para ver si se quiere paginar una tabla con los libros borrados
 * @return array|false false si ha habido algún error o un array con los datos de los libros o usuarios
 */

function paginarTabla($tabla, $por_pagina, $pagina , $borrado=null){
    // Establecer la conexión
    $conexion = conectar();
    // Calcular el total de registros
    if($borrado!=null){
         $consulta_total = "SELECT * FROM $tabla WHERE borrado=true";
    }else{
        $consulta_total = "SELECT * FROM $tabla";
    }

    $resultado_total = ejecutarConsulta($conexion, $consulta_total);
    $total_registros = count($resultado_total);
    // Calcular el número total de páginas
    $total_paginas = ceil($total_registros / $por_pagina);

    // Calcular el offset para la consulta
    $offset = ($pagina - 1) * $por_pagina;

    // Consulta para obtener los registros de la página actual
    if($borrado!=null){
        $consulta_pagina = "SELECT * FROM $tabla WHERE borrado=true LIMIT $por_pagina OFFSET $offset";
    }else{
        $consulta_pagina = "SELECT * FROM $tabla LIMIT $por_pagina OFFSET $offset";
    }
    //$consulta_pagina = "SELECT * FROM $tabla LIMIT $por_pagina OFFSET $offset";
    $resultado_pagina = ejecutarConsulta($conexion, $consulta_pagina);

    // Crear un array asociativo con los datos de la página y la información de paginación
    $paginacion = [
        'registros' => $resultado_pagina, // Datos de la página actual
        'pagina_actual' => $pagina,
        'total_paginas' => $total_paginas,
        'total_registros' => $total_registros
    ];

    // Retornar el array asociativo con la información de la paginación y los registros
    return $paginacion;
}

?>