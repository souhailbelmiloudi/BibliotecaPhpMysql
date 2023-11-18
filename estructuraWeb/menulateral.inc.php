<nav class="sidebar">
 
      
      

      <div id="profile">
      <a href="#" class="logo">Mi Biblioteca</a>
        <div id="photo">
            <img src="./img/user.png" alt="Foto de perfil">
        </div>
        <div id="name">
            <span><?php echo $_SESSION["nombre"];?></span>
        </div>
      </div>

      <div class="menu-content">
        <ul class="menu-items">
          <!--<div class="menu-title">Hola  <?php echo $_SESSION["nombre"]; ?> </div>-->

          <li class="item">
            <a href="<?php echo $_SERVER["PHP_SELF"] . "?ruta=perfil"; ?>">Inicio</a>
          </li>

          <li class="item">
            
            <div class="submenu-item">
              <img src="https://img.icons8.com/ios-filled/50/000000/book.png" alt="Libros">
              <span>Libros </span>
              <i class="fa-solid fa-chevron-right"></i>
            </div>

            <ul class="menu-items submenu">
              <div class="menu-title">
                <i class="fa-solid fa-chevron-left"></i>
                Libros Menu
              </div>
              <li class="item">
                <a href="<?php echo $_SERVER["PHP_SELF"] . "?ruta=MiLibros"; ?>">   <?php if($_SESSION["rol"]=="admin"){ echo "Libros Activos";}else{echo "Mis Libros";}?></a>
              </li>
              <?php if($_SESSION["rol"]=="admin"){ ?>
              <li class="item">
                <a href="<?php echo $_SERVER["PHP_SELF"] . "?ruta=libros"; ?>">Llibros Inactivos</a>
              </li>
              <li class="item">
                <a href="<?php echo $_SERVER["PHP_SELF"] . "?ruta=librosPrestados"; ?>">Llibros Prestados</a>
              </li>
              <?php } ?>
              <?php if($_SESSION["rol"]!="admin"){ ?>
              <li class="item">
                <a href="<?php echo $_SERVER["PHP_SELF"] . "?ruta=prestamos"; ?>">Prestamos</a>
              </li>
              <li class="item">
                <a href="<?php echo $_SERVER["PHP_SELF"] . "?ruta=devolver"; ?>">devolucion</a>
              </li>
              <?php } ?>
            </ul>
          </li>

          <?php if($_SESSION["rol"]=="admin"){ ?>
          <li class="item">
            <div class="submenu-item">
              <img src="https://img.icons8.com/ios-filled/50/000000/settings.png" alt="Gestión">
              <span>Gestion</span>
              <i class="fa-solid fa-chevron-right"></i>
            </div>
          <?php } ?>
            <ul class="menu-items submenu">
              <div class="menu-title">
                <i class="fa-solid fa-chevron-left"></i>
                Gestion Menu
              </div>
              <li class="item">
                <a href="<?php echo $_SERVER["PHP_SELF"] . "?ruta=subirlibros"; ?>"> Subir Libros</a>
              </li>
              <li class="item">
                <a href="<?php echo $_SERVER["PHP_SELF"] . "?ruta=borrarlibros"; ?>">Borrar Libros</a>
              </li>
              
            </ul>
          </li>

          <!-- <li class="item">
            <a href="#">Cambiar Contraseña</a>
          </li> -->

          <li class="item">
            <a href="<?php echo $_SERVER["PHP_SELF"] . "?ruta=logout"; ?>">Cerrar Sesion</a>
          </li>
        </ul>
      </div>
    </nav>

    <nav class="navbar">
      <i class="fa-solid fa-bars" id="sidebar-close"></i>
   </nav>

    <main class="main">
     <?php
      

    if (isset($_GET["ruta"]) && !empty($_GET["ruta"])) {
        $ruta = getPaginaParaRuta($_GET["ruta"]);
        $paginaAdmin = obtenerPaginaSegunRol($ruta);
    echo $paginaAdmin;
        if ($paginaAdmin !== null) {
            includeAdminPage($paginaAdmin);
        }
    }
    
      
      ?>
    </main>





