
<?php
// Lógica para activar libros
if(isset($_POST["activar"])){
    $id=$_POST["id"];
    if(activarLibro($id)){
    ?>
    <script>
        Swal.fire({
            title: "Libro activado",
            text: "El libro se ha activado correctamente",
            icon: "success",
            button: "Aceptar",
        });
    </script>
    <?php
    }else{
        ?>
    <script>
        Swal.fire({
            title: "Error",
            text: "El libro no se ha podido activar",
            icon: "error",
            button: "Aceptar",
        });
    </script>
<?php } 
}

// Lógica de paginación

$pagina = (isset($_GET['pagina'])) ? (int) $_GET['pagina'] : 1;
// Establecer el número de registros por página
$por_pagina = 5;
// Obtener los registros de la página actual
$paginacion = paginarTabla('libros', $por_pagina, $pagina, 'borrado');
// Obtener los registros de la página actual
$verLibrosBorrados = $paginacion['registros'];
// Obtener el número total de páginas
$total_paginas = $paginacion['total_paginas'];
// Obtener el número total de registros
$total_registros = $paginacion['total_registros'];

        
?>

<h1 class="titulos">Pagina Libros Inactivos </h1>
      <table class="tabla">
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>ISBN</th>
        <th>Autor</th>
        <th>Editorial</th>
        <th>Gestión</th>
    </tr>

    <?php
    if (isset($verLibrosBorrados)) {
        foreach ($verLibrosBorrados as $libro) {
    ?>
        <tr>
            <td><?php echo $libro['id']; ?></td>
            <td><?php echo $libro['titulo']; ?></td>
            <td><?php echo $libro['isbn']; ?></td>
            <td><?php echo $libro['autor']; ?></td>
            <td><?php echo $libro['editorial']; ?></td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $libro['id']; ?>">
                    <input type="submit" value="Activar" name="activar" class="btn-editar">
                </form>
            </td>
        </tr>
    <?php
        }
    }
    ?>  
</table>

<!-- paginacion -->
<?php
if($pagina != 1){
       ?>
         <a class="paginas" href='?ruta=libros&pagina=<?php echo ($pagina-1); ?>'><<</a>
         
         <?php
    }

    for ($i = 1; $i <= $total_paginas; $i++) {
        if ($i == $pagina) {
            ?>
            <a class="paginas active"  href='?ruta=libros&pagina=<?php echo $i; ?>'><?php echo $i; ?></a>
            <?php
        } else {
            ?>
            <a class="paginas" href='?ruta=libros&pagina=<?php echo $i; ?>'><?php echo $i; ?></a>
            <?php
        }
    }
    if ($pagina != $total_paginas) {
        ?>
        <a class="paginas" href='?ruta=libros&pagina=<?php echo ($pagina+1); ?>'>>></a>
        <?php
    }
    ?>  
 
<!-- Final paginacion -->



