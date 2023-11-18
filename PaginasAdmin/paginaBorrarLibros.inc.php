<?php

// Path: PaginasAdmin/paginaBorrarLibros.inc.php

$libro_id = isset($_POST['libro_id'])?$_POST['libro_id']:'';
$isbn = isset($_POST['isbn'])?$_POST['isbn']:'';
if (isset($_POST["borrar"])) { 
    if(isset($_POST["sel"]) && isset($_POST["valor"]) && !empty($_POST["valor"])){

        $op=$_POST["sel"];
        $valor=$_POST["valor"];
        switch ($op) {
            case 'isbn':
                $isbn=$valor;
                $id="";
                
                if(borrarLibro($id, $isbn)){
                    ?>
                    <script>
                        swal.fire({
                            title: "Libro borrado",
                            text: "El libro se ha borrado correctamente",
                            icon: "success",
                            button: "Aceptar",
                        });
                    </script>
                    <?php
                }else{
                    ?>
                    <script>
                        swal.fire({
                            title: "Libro no borrado",
                            text: "Libro no Existe en la base de datos",
                            icon: "error",
                            button: "Aceptar",
                        });
                    </script>
                    <?php
                }
                break;
            default:
                $id=$valor;
                $isbn="";
                if(borrarLibro($id, $isbn)){
                    ?>
                    <script>
                        swal.fire({
                            title: "Libro borrado",
                            text: "El libro se ha borrado correctamente",
                            icon: "success",
                            button: "Aceptar",
                        });
                    </script>
                    <?php
                }else{
                    ?>
                    <script>
                        swal.fire({
                            title: "Libro no borrado",
                            text: "Libro no Existe en la base de datos",
                            icon: "error",
                            button: "Aceptar",
                        });
                    </script>
                    <?php
                }
                break;
        }
    }else{
        ?>
        <script>
            swal.fire({
                title: "Campos vacios",
                text: "Verifica que los campos estan rellenos correctamente",
                icon: "warning",
                button: "Aceptar",
            });
        </script>
        <?php
    }
    
}



 ?>




<h1 class="titulos">Pagina Borrar libros</h1>

<form action="" class="form-page" method="post">
   
    <select name="sel" id="selsbn"   class="select">
        <option value="id">Con ID</option>
        <option value="isbn">Con ISBN</option>
    </select>
    <input type="text" name="valor" id="valor" value="<?php echo $libro_id?>"  readonly >  
    <input type="submit" value="Borrar" name="borrar" class="btn-borrar">

</form>



<script>
    //cambiar el valor del input valor segun el select
let sel = document.getElementById("selsbn");
let  valor = document.getElementById("valor");
    sel.addEventListener("change", function() {
        if (sel.value == "id") {
            
            valor.value="<?php echo $libro_id?>";
        } else {
            valor.value="<?php echo $isbn?>";
        }
    });
</script>