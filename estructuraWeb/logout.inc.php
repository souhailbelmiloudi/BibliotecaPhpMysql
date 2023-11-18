<?php
   //iniciamos sesión - SIEMPRE TIENE QUE ESTAR EN LA PRIMERA LÍNEA

   //eliminamos las variables de sesión
   session_unset();
   //eliminamos la sesión
   session_destroy();
   //redireccionamos a index
   
 header("Location:".$_SERVER["PHP_SELF"]."?ruta=login")

?>


