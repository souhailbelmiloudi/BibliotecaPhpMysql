<?php 
   if(isset($_POST["subir"])){
    //variables de los campos del formulario
        if(isset($_POST["titulo"])&& !empty($_POST["titulo"]) &&
        isset($_POST["ISBN"])&& !empty($_POST["ISBN"]) &&
        isset($_POST["autor"])&& !empty($_POST["autor"]) &&
        isset($_POST["editorial"])&& !empty($_POST["editorial"])){

            $titulo=$_POST["titulo"];
            $ISBN=$_POST["ISBN"];
            $autor=$_POST["autor"];
            $editorial=$_POST["editorial"];
            // verificamos que el ISBN sea valido de  13 digitos
            if(validarISBN13($ISBN)){
                // verificamos que el libro no exista
            if(validarLibro($titulo,$ISBN,$autor,$editorial)){
                // subimos el libro
                if(subirLibro($titulo,$ISBN,$autor,$editorial)){?>
                    <script>
                        Swal.fire({
                            icon: "success",
                            title: "Libro subido correctamente"
                        });
                    </script>
                <?php
                }else{ ?>
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "Error al subir el libro"
                        });
                    </script>
                <?php
                }
            }else{ ?>
                <script>
                    Swal.fire({
                        icon: "error",
                        title: "El libro ya existe"
                    });
                </script>
            <?php

            }
            }else{
                ?>
                <script>
                    Swal.fire({
                        icon: "error",
                        title: "El ISBN no es valido"
                    });
                </script>
            <?php
            
            }

        }else{
            ?>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Rellene todos los campos"
                });
            </script>
        <?php
        
        }
    
   }

?>


<h1 class="titulos">Pagina Subir libros</h1>

<form action="" class="form-page" method="post">
    <label for="titulo">Titulo</label>

    <input type="text" name="titulo" id="titulo">  
    <label for="ISBN">ISBN</label>
    <input type="text" name="ISBN" id="ISBN">
    <label for="autor">Autor</label>
    <input type="text" name="autor" id="autor">
    <label for="editorial">Editorial</label>
    <input type="text" name="editorial" id="editorial">
    <input type="submit" value="Subir" name="subir">

</form>

