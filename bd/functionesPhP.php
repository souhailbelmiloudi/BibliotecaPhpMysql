<?php

/**
 * functio que dirige a la pagina que se le pasa por parametro en la carpeta estructuraWeb
 * @param {string} $pageName - El nombre del archivo de página a incluir. 
 * @return {void}
 */
function includePage($pageName) {
    include_once "./estructuraWeb/$pageName.inc.php";
}

/**
 * functio que dirige a la pagina que se le pasa por parametro en la carpeta PaginasAdmin
 * @param {string} $pageName - El nombre del archivo de página a incluir.
 * @return {void}
 */
function includeAdminPage($pageName) {
    include_once "./PaginasAdmin/$pageName.inc.php";
}

/**
 * functio que devuelve la pagina que se le pasa por parametro cuando el usuario esta logueado y inserta el menu lateral
 * @param {string} $ruta - El nombre del archivo de página a incluir.
 * @return {string} - El nombre del archivo de página a incluir.
 * 
 */
function getPaginaParaRuta($ruta) {
    if (isset($_SESSION["usuario"])) {

        includePage("menulateral");
        switch ($ruta) {
            case "prestamos":
            case "perfil":
            case "libros":
            case "subirlibros" :
            case "borrarlibros":
            case "MiLibros":
            case "devolver":
            case "editar_libro": 
            case "librosPrestados":   
                return $ruta;
            case "logout":
                return "logout";
        }
    } elseif ($ruta == "login" || $ruta == "signup") {
        return $ruta;
    }

    return "principal"; // Página por defecto
}


/**
 * functio para obtener la pagina segun el rol del usuario
 * @param {string} $ruta - El nombre del archivo de página a incluir.
 * @return {string} - El nombre del archivo de página a incluir.
 */
function obtenerPaginaSegunRol($ruta) {
    switch ($ruta) {
        case "prestamos":
            return "paginaPrestamo";
        case "perfil":
            return ($_SESSION["rol"] != "admin") ? "paginaBusacr" : "paginaBuscarUser";
        case "libros":
        case "subirlibros":
        case "borrarlibros":
        case "librosPrestados":
            return ($_SESSION["rol"] == "admin") ? "pagina" . ucfirst($ruta) : "paginaBusacr";
        case "MiLibros":
            return ($_SESSION["rol"] == "admin") ? "paginaBusacr" : "paginaLibrosUser";
        case "devolver":
            return "paginaDevolucion";
        case "editar_libro":
            return "paginaEditarUser";
        case "logout":
            includePage("logout");
            return null; 
        default:
            return ($_SESSION["rol"] == "admin") ? "paginaBuscarUser" : "paginaBusacr";
    }
}
    

/**
 * functio para ordenar un array por un campo
 * @param {string} $select - El nombre del campo por el que se va a ordenar.
 * @param {array} $lista - El array que se va a ordenar.
 * @return {array} - El array ordenado.
 */
function ordenar($select, $lista){
    $ordenar = array();
    foreach($lista as $elemento){
        $ordenar[$elemento[$select]] = $elemento;
    }
    ksort($ordenar);
    return $ordenar;
}

/**
 * functio validar la contraseña y devolverla encriptada
 * @param {string} $password - La contraseña que se va a validar.
 * @param {string} $password2 - La contraseña que se va a validar.
 * @return {string} - La contraseña encriptada o un error.
 * 
 */
 function validarPassword($password, $password2)
 {
     if ($password === $password2) {
         return password_hash($password, PASSWORD_BCRYPT);
         
     } else {
         return "Error: Las contraseñas no coinciden";
     }
 }

/**
* functio para validar el email
* @param {string} $email - El email que se va a validar.
* @return {boolean} - true si es valido y false si no lo es.
*/

 function validarEmail($email)
 {
     return filter_var($email, FILTER_VALIDATE_EMAIL);
 }


/**
 *  functio para calcular los dias que quedan para la devolucion
 * @param {string} $fecha_devolucion - La fecha de devolucion del libro.
 * @return {int} - Los dias que quedan para la devolucion.
 */

function calcularDias($fecha_devolucion){
    $fecha_actual=date("Y-m-d");
    $diasRestantes=strtotime($fecha_devolucion)-strtotime($fecha_actual);
    $diasRestantes=$diasRestantes/86400;
    $diasRestantes=floor($diasRestantes);
    return $diasRestantes;
}

/**
 * functio para validar el isbn
 * @param {string} $isbn - El isbn que se va a validar.
 * @return {boolean} - true si es valido y false si no lo es.
 */
function validarISBN13($isbn) {
    // Eliminar guiones y espacios
    $isbn = str_replace(['-', ' '], '', $isbn);

    // Expresión regular para ISBN-13
    $regex = '/^\d{13}$/';

    // Validar el ISBN-13
    if (preg_match($regex, $isbn)) {
        return true;
    } else {
        return false;
    }
}
?>