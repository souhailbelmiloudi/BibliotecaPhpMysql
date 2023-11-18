<?php
  
  // Variables de usuario
  $usuario_id=isset($_POST['usuario_id'])?$_POST['usuario_id']:"";
  $usuario_nombre=isset($_POST['usuario_nombre'])?$_POST['usuario_nombre']:"";
  $fecha_registro=isset($_POST['fecha_registro'])?$_POST['fecha_registro']:"";
  $usuario_rol=isset($_POST['usuario_rol'])?$_POST['usuario_rol']:"";

        if(isset($_POST["editar"])){

             // Comprobación de campos no vacíos
            if(isset($_POST["usuario_id"])
             && isset($_POST["usuario_nombre"])
             && isset($_POST["fecha_registro"])
             && isset($_POST["sel"])){

                // Actualizar rol del usuario
               $op = $_POST["sel"];
               $usuario_id = $_POST["usuario_id"];
               $usuario_rol = ($op == "admin") ? "admin" : "usuario"; // Actualizar rol basado en la selección
              // $usuario_id=$_POST["usuario_id"];
              if(editarUsuario($usuario_id,$usuario_rol)){
                ?>
                <script>
                    swal.fire({
                        title: "Usuario editado",
                        text: "El usuario se ha editado correctamente",
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(function() {
                        window.location.href = "index.php?ruta=perfil";
                    });
                </script>
                <?php
                }else{
                    ?>
                <script>
                    swal.fire({
                        title: "Error",
                        text: "El usuario no se ha podido editar",
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                </script>
<?php         }}}else{
      ?>
      <script>
          swal.fire({
              title: "aviso",
              text: "Solo se puede editar el rol del usuario",
              icon: 'info',
              confirmButtonText: 'Aceptar'
          });
      </script>
<?php
}
?>



<h1 class="titulos">Página de Edición de Usuario</h1>

    <section class="container">
  <header>Editar Usuario</header>
  <form class="form" action="<?php echo $_SERVER["PHP_SELF"] . "?ruta=editar_libro"; ?>" method="post">
      <div class="input-box">
          <label>ID Usuario</label>
          <input type="text" name="usuario_id" value="<?php echo $usuario_id; ?>" readonly>
      </div>
      <div class="column">
          <div class="input-box">
            <label>Nombre Usuario</label>
            <input type="text" name="usuario_nombre" value="<?php echo $usuario_nombre; ?>" readonly>
          </div>
          <div class="input-box">
            <label>fecha registro</label>
            <input type="date" name="fecha_registro" value="<?php echo $fecha_registro; ?>" readonly>
          </div>
      </div>
       
      <div class="input-box address">
        <label>Rol</label>
        <div class="column">
          <div class="select-box">
            <select  name="sel" id="">
                <option  value="<?php echo $usuario_rol; ?>"><?php echo $usuario_rol; ?></option>
               <option velue="<?php if($usuario_rol=="admin"){echo "usuario";}else{echo "admin";} ?>"><?php if($usuario_rol=="admin"){echo "usuario";}else{echo "admin";} ?></option>

            </select>
          </div>
                 
        </div>
      </div>
      <input type="submit" value="Editar" name="editar" class="btn-editar">

  </form>
</section>


   

