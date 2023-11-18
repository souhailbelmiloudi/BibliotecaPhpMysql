<?php

        $libro_id = isset($_POST['libro_id'])?$_POST['libro_id']:'';
        $libro_titulo = isset($_POST['libro_titulo'])?$_POST['libro_titulo']:'';
        $user_id = $_SESSION['id'];
        $usuario_nombre = $_SESSION['nombre'];
        if(isset($_POST["devolver"]) && isset($_POST['id']) && isset($_POST['titulo']) ){
            $libro_id = $_POST['id'];
            $libro_titulo=$_POST['titulo'];
            if (!empty($libro_id) && !empty($user_id)) {
                if(Devolver_libro($libro_id,$user_id)){ ?>
                <script>
                    swal.fire({
                        title: "Devolucion realizada",
                        text: "El libro se ha devuelto correctamente",
                        icon: "success",
                        button: "Aceptar",
                    });

                </script>
            <?php }else{ ?>
                <script>
                    swal.fire({
                        title: "Devolucion no realizada",
                        text: "Ha ocurrido un error al intentar devolver el libro. Por favor, verifica los datos e inténtalo de nuevo.",
                        icon: "error",
                        button: "Aceptar",
                    });
                </script>
            <?php }
        }else{?>
            <script>
            swal.fire({
                title: "Datos faltantes",
                text: "Por favor, asegúrate de seleccionar un libro para devolver.",
                icon: "warning",
                button: "Aceptar",
            });
        </script>
         <?php }
        } else { ?>
        <script>
            Swal.fire("Hola <?php echo $usuario_nombre; ?>", "Si quieres devolver un libro, dirígete a la sección <b>Mis libros</b> y pulsa el botón devolver", "info");
        </script>
        <?php }
    
?>


<h1 class="titulos">Página de Devolución</h1>


    <form action="" class="form-page" method="post" >
        <label for="id_libro">ID  Libro</label>
        <input type="text" name="id" id="id" value="<?php if(!isset($_POST["devolver"])){ echo $libro_id ;}else{ echo "";} ?>" readonly>
        <label for="titulo">Titulo</label>
        <input type="text" name="titulo" id="titulo" value="<?php if(!isset($_POST["devolver"])){ echo $libro_titulo ;}else{ echo "";}?>" readonly>
        <input type="submit" value="Devolver" name="devolver" class="btn-borrar">

    </form>





   

