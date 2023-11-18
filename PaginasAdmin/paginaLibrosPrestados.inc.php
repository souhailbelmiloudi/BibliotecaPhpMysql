<?php
// Obtener el número de página actual
if (isset($_GET['pagina'])) {
    $pagina = $_GET['pagina'];
} else {
    $pagina = 1;
}

// Establecer el número de registros por página
$por_pagina = 5;
// Obtener los registros de la página actual
$paginacion = paginarTabla('prestamo', $por_pagina, $pagina);

// Obtener los registros de la página actual
$registros = $paginacion['registros'];

// Obtener el número total de páginas
$total_paginas = $paginacion['total_paginas'];

// Obtener el número total de registros
$total_registros = $paginacion['total_registros'];
 ?>
<h1 class="titulos">Libros Prestados</h1>

<table class="tabla">
                <tr>
                    <th>Usuario</th>
                    <th>Id Prestamo</th>
                    <th>Titulo</th>
                    <th>Fecha Devolucion</th>
                    <th>Estado</th>
                </tr>
                <?php
                if(isset($registros)){
                    foreach($registros as $libro){
                ?>
                <tr>
                    <td><?php echo $libro['user_id']; ?></td>
                    <td><?php echo $libro['id_prestamo']; ?></td>
                    <td><?php echo $libro['titulo_libro']; ?></td>
                    <td><?php echo $libro['fecha_devolucion']; ?></td>
                    <td><?php if($libro['devuelto']==0){echo "Prestado";}else{echo "Devuelto";} ?></td>
                </tr>
                <?php
                    }
                }
                ?>
                
               
</table>

<div>


<!-- paginacion -->
<?php
    if($pagina != 1){
       ?>
         <a class="paginas" href='?ruta=librosPrestados&pagina=<?php echo ($pagina-1); ?>'><<</a>
         
         <?php
    }
    ?>
    <?php
    for ($i = 1; $i <= $total_paginas; $i++) {
        if ($i == $pagina) {
            ?>
            <a class="paginas active"  href='?ruta=librosPrestados&pagina=<?php echo $i; ?>'><?php echo $i; ?></a>
            <?php
        } else {
            ?>
            <a class="paginas" href='?ruta=librosPrestados&pagina=<?php echo $i; ?>'><?php echo $i; ?></a>
            <?php
        }
    }
    if ($pagina != $total_paginas) {
        ?>
        <a class="paginas" href='?ruta=librosPrestados&pagina=<?php echo ($pagina+1); ?>'>>></a>
        <?php
    }

?>
</div>


