<?php
session_start();
include("bd/conexion.php");
include("bd/functionesPhP.php");
if($conexion=conectar()){
}else{

  $errbd="Error: No se ha podido conectar a la base de datos";
  
};
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=".\css\style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Biblioteca</title>
</head>
<body>
  <section >
    <?php
    //alerta de que la connexión a la base de datos ha fallado
    if(isset($errbd) && !empty($errbd)){
      ?>
     <script>

      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '<?php echo $errbd; ?>',
        

      })


     </script>
    }
    <?php
    }


    //Gestion de rutas
    if(isset($_GET["ruta"]) && !empty($_GET["ruta"])){
      $ruta=getPaginaParaRuta($_GET["ruta"]);
      if(!isset($_SESSION["usuario"])){
        includePage("cabecera");
        includePage("menu");
        includePage($ruta);
        includePage("pie");
      }
       else{
        includePage("cabecera");
        includePage("menu");
        includePage("principal");
        includePage("pie");
       }
    }else {
      includePage("cabecera");
      includePage("menu");
      includePage("principal");
      includePage("pie");
    }
    
    ?>

  </section>  
   

  <script src="js\script.js"> </script>
 
</body>
</html>