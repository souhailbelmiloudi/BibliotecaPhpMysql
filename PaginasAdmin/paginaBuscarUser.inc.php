<?php  
$listaUsuarios = []; 
$pagina = (isset($_GET['pagina'])) ? (int) $_GET['pagina'] : 1;
// Establecer el número de registros por página
$por_pagina = 5;
// Obtener los registros de la página actual
$paginacion = paginarTabla('usuario', $por_pagina, $pagina);
// Obtener los registros de la página actual
$listaUsuarios = $paginacion['registros'];
// Obtener el número total de páginas
$total_paginas = $paginacion['total_paginas'];
// Obtener el número total de registros
$total_registros = $paginacion['total_registros'];
if(isset($_POST["buscar"])){
         $select = $_POST["select"];
         $listaUsuarios = ordenar($select, $listaUsuarios);
}

?>
<h1 class="titulos">Usuarios</h1>
<form method="post" action="" class="form-page">
    <label for="select">Ordenar Por</label>
    <select name="select" id="select"  class="select">
        <option value="id">ID</option>
        <option value="usuario">Usuario</option>
        <option value="nombre">Nombre</option>
        <option value="primer_apellido">1º Apellido</option>
    </select>
    <input type="submit" value="Buscar" name="buscar">
    </form>
    <table class="tabla">
        <tr>
            <th>ID</th>
            <th>Usuarios</th>
            <th>Correo</th> 
            <th>Nombre</th>
            <th>1º Apellido</th>
            <th>2º Apellido</th>
            <th>rol</th>
            <th>Gestión</th>
        </tr>
<?php 
    if(isset($listaUsuarios)){
        foreach($listaUsuarios as $usuario){
?>
<tr>
        <td><?php echo $usuario['id']; ?></td>
        <td><?php echo $usuario['usuario']; ?></td>
        <td><?php echo $usuario['correo']; ?></td>
        <td><?php echo $usuario['nombre']; ?></td>
        <td><?php echo $usuario['primer_apellido']; ?></td>
        <td><?php echo $usuario['segundo_apellido']; ?></td>
        <td><?php echo $usuario['rol']; ?></td>
        <td>
        <form action="<?php echo $_SERVER["PHP_SELF"] . "?ruta=editar_libro"; ?>" method="post" >
            <input type="hidden" name="usuario_id" value="<?php echo $usuario['id']; ?>">
            <input type="hidden" name="usuario_nombre" value="<?php echo $usuario['nombre']; ?>">
            <input type="hidden"  name="fecha_registro" value="<?php echo $usuario['fecha_registro']; ?>">
            <input type="hidden" name="usuario_rol" value="<?php echo $usuario['rol']; ?>">
            <input type="submit" value="Editar">
        </form>
        </td>
    </tr>
    <?php
        }
    }
 ?>
</table>
<div>
<!-- Paginación  -->
<?php
if($pagina != 1){
       ?>
         <a class="paginas" href='?ruta=perfil&pagina=<?php echo ($pagina-1); ?>'><<</a>
         
         <?php
    }

    for ($i = 1; $i <= $total_paginas; $i++) {
        if ($i == $pagina) {
            ?>
            <a class="paginas active"  href='?ruta=perfil&pagina=<?php echo $i; ?>'><?php echo $i; ?></a>
            <?php
        } else {
            ?>
            <a class="paginas" href='?ruta=perfil&pagina=<?php echo $i; ?>'><?php echo $i; ?></a>
            <?php
        }
    }
    if ($pagina != $total_paginas) {
        ?>
        <a class="paginas" href='?ruta=perfil&pagina=<?php echo ($pagina+1); ?>'>>></a>
        <?php
    }
    ?>  