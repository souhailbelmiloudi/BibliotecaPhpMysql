
<nav id="menuInicio">
    <ul>
	<li><a href="<?php echo $_SERVER["PHP_SELF"] . "?ruta=principal"; ?>">Inicio</a></li>
        <?php if (isset($_SESSION["nombre"]) && !empty($_SESSION["nombre"])){ ?>
			<li><a href="<?php echo $_SERVER["PHP_SELF"] . "?ruta=perfil"; ?>">Perfil</a></li>
        <?php } else { ?>
			<li><a href="<?php echo $_SERVER["PHP_SELF"] . "?ruta=login"; ?>">Iniciar Sesión</a></li>
			<li><a href="<?php echo $_SERVER["PHP_SELF"] . "?ruta=signup"; ?>">Registro</a></li>	
        <?php } ?>
    </ul>
</nav>
