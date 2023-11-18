<?php  
       $tamañoPagina = 5;
      if(!isset($_POST["buscar"])){
        $op=isset($_POST["sel"])?$_POST["sel"]:"titulo";
        $pagina =isset($_GET["pagina"])?$_GET["pagina"]:1;
        $numFilas =isset($numFilas)?$numFilas:totalLibros($op);
        $totalPaginas = ceil($numFilas / $tamañoPagina);
        $empezarDesde = ($pagina - 1) * $tamañoPagina;
        $busqueda=isset($_POST["search"])?$_POST["search"]:"";
        $buscarLibrosPorTituloCon=buscarLibrosPorTituloCon($busqueda,$empezarDesde,$tamañoPagina,$op);
      }else if(isset($_POST["buscar"])){
          $op=isset($_POST["sel"])?$_POST["sel"]:"titulo";
          $pagina =1;
          $busqueda=isset($_POST["search"])?$_POST["search"]:"id";
          $numFilas =totalLibros($op,$busqueda);
          $totalPaginas = ceil($numFilas / $tamañoPagina);
          $empezarDesde = ($pagina - 1) * $tamañoPagina;
          $buscarLibrosPorTituloCon=buscarLibrosPorTituloCon($busqueda,$empezarDesde,$tamañoPagina,$op);
      }
?>
<h1 class="titulos">Búsqueda de Libros</h1>
<form method="post" action="" class="form-page" id="buscador">
    <label for="sel">Buscar por</label>
    <select name="sel" id="sel"   class="select">
        <option value="titulo">Título</option>
        <option value="isbn">ISBN</option>
        <option value="autor">Autor</option>
        <option value="editorial">Editorial</option>
    </select>
    <input type="text" name="search" placeholder="Buscar libros por título">
    <input type="submit" value="Buscar" name="buscar">
</form>
      <!-- Mostrar páginas -->
<?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
    <a href="<?php
        $ruta = $_SESSION["rol"] == "admin" ? 'MiLibros' : 'perfil';
        echo htmlspecialchars($_SERVER['PHP_SELF'] . '?q=' . (isset($_POST["search"]) ? $_POST["search"] : '') . '&ruta=' . $ruta . '&pagina=' . $i);
    ?>" class="paginas <?php echo $i == $pagina ? 'active' : ''; ?>"><?php echo $i ?></a>
<?php } ?>
<!-- Final Mostrar páginas -->
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
    if (isset($buscarLibrosPorTituloCon)) {
        foreach ($buscarLibrosPorTituloCon as $libro) {
    ?>
        <tr>
            <td><?php echo $libro['id']; ?></td>
            <td><?php echo $libro['titulo']; ?></td>
            <td><?php echo $libro['isbn']; ?></td>
            <td><?php echo $libro['autor']; ?></td>
            <td><?php echo $libro['editorial']; ?></td>
            <td>
            <?php
            if(isset($_SESSION["rol"]) && $_SESSION["rol"] !="admin" ){
            ?>
            <form action="<?php echo $_SERVER["PHP_SELF"] . "?ruta=prestamos"; ?>" method="post" >
                    <input type="hidden" name="libro_id" value="<?php echo $libro['id']; ?>">
                    <input type="hidden" name="libro_titulo" value="<?php echo $libro['titulo']; ?>">
                    <input type="submit" value="Prestar">
           </form>
           <?php
            }else{
                
           
            ?>
            <form action="<?php echo $_SERVER["PHP_SELF"] . "?ruta=borrarlibros"; ?>" method="post" >
                    <input type="hidden" name="libro_id" value="<?php echo $libro['id']; ?>">
                    <input type="hidden" name="isbn" value="<?php echo $libro['isbn']; ?>">
                    <input type="submit" value="Borrar">
           </form>
           <?php
            }
           ?>
        </td>
        </tr>
    <?php
        }
    }
    ?>
</table>

