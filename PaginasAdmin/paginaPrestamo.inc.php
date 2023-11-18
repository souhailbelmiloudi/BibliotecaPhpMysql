<?php
   
        $libro_id = isset($_POST['libro_id'])?$_POST['libro_id']:'';
        $libro_titulo = isset($_POST['libro_titulo'])?$_POST['libro_titulo']:'';
        $usuario_id = $_SESSION['id'];
        $usuario_nombre = $_SESSION['nombre'];

        if(isset($_POST["prestar"])){
            $libro_id_prestamo = $_POST['id'];
            $libro_titulo_prestamo = $_POST['titulo'];

            if(insertarPrestamo($usuario_id, $libro_id_prestamo,$libro_titulo_prestamo,true)){ ?>
                <script>
                    swal.fire({
                        title: "Prestamo realizado",
                        text: "El libro se ha prestado correctamente",
                        icon: "success",
                        button: "Aceptar",
                    });
                </script>
            <?php }else{ ?>
                <script>
                    swal.fire({
                        title: "Prestamo no realizado",
                        text: "El libro no se ha prestado correctamente, verifica que los datos son correctos o los campos estan rellenos",
                        icon: "error",
                        button: "Aceptar",
                    });
                </script>
            <?php } 
        }else{?>
            <script>
                Swal.fire("Hola <?php echo $usuario_nombre; ?>", "Si quieres prestar un libro,derigete a la seccion <b>Libros</b> y pulsa el boton prestar", "info");
            </script>
<?php }?>


<h1 class="titulos">Pagina Prestamos</h1>
    <form action="" class="form-page" method="post" >
        <label for="id_libro">ID  Libro</label>
        <input type="text" name="id" id="id" value="<?php echo htmlspecialchars($libro_id); ?>" readonly>
        <label for="titulo">Titulo</label>
        <input type="text" name="titulo" id="titulo" value="<?php echo htmlspecialchars($libro_titulo); ?>" readonly>
        <input type="submit" value="Prestar" name="prestar" class="btn-borrar">
    </form>


 
   

