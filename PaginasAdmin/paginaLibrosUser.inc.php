<h1 class="titulos">Mis libros </h1>
<table class="tabla">
    <tr>
        <th>Título</th>
        <th>Fecha de Devolución</th>
        <th>dias restantes</th>
        <th>Gestión</th>
    </tr>
    <?php
    $iduser=$_SESSION["id"];
    $consultaLibrosUser=consultaLibrosUser($iduser);
    if($consultaLibrosUser){
        foreach($consultaLibrosUser as $libro){
        $diasRestantes=calcularDias($libro['fecha_devolucion']);
        $color = ($diasRestantes < 5) ? 'red' : 'green';

    ?>
    <tr>
        <td><?php echo $libro['titulo_libro']; ?></td>
        <td><?php echo $libro['fecha_devolucion']; ?></td>
        <td style="color: <?php echo $color; ?>"><?php echo $diasRestantes; ?></td>
        <td>
            <form action="<?php echo $_SERVER["PHP_SELF"] . "?ruta=devolver"; ?>" method="post" >
                <input type="hidden" name="libro_id" value="<?php echo $libro['libro_id']; ?>">
                <input type="hidden" name="libro_titulo" value="<?php echo $libro['titulo_libro']; ?>">
                <input type="submit" value="Devolver">
            </form>
        </td>
    </tr>
    <?php
        }
    }else{?>
        <tr>
            <td colspan="4"><h3 style="color:red; text-align:center;">No tienes libros prestados</h3></td>
        </tr>
   <?php }
    ?>
    
    
</table>
