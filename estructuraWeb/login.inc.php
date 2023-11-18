	
<?php
if(isset($_POST["ingresar"])){
    
	if(isset($_POST["user"])&& !empty($_POST["user"]) 
	&& isset($_POST["password"])&& !empty($_POST["password"])){
  
	  $user=$_POST["user"];
	  
	  $password=$_POST["password"];
  
	  if(login($user,$password)){
	   
		$datosUser=login($user,$password);
		$_SESSION["nombre"] = $datosUser["nombre"];
		$_SESSION["apellido_1"] = $datosUser["primer_apellido"];
		$_SESSION["apellido_2"] = $datosUser["segundo_apellido"];
		$_SESSION["usuario"] = $datosUser["usuario"];
		$_SESSION["correo"] = $datosUser["correo"];
		$_SESSION["fecha_registro"] = $datosUser["fecha_registro"];
		$_SESSION["rol"] = $datosUser["rol"];
		$_SESSION["id"] = $datosUser["id"];
  
   
	  header("location: ". $_SERVER["PHP_SELF"]."?ruta=perfil");
	  
	  }else{
		$errUser="usuario o la contraseña son incorrectos";
		?>
		<script>
		Swal.fire({
		icon: "error",
		title: <?php echo "'$errUser'"; ?>,
		});
		</script>
			
<?php
}} }
?>
		<form action="<?php echo $_SERVER["PHP_SELF"]."?ruta=login" ?>" method="POST" class="form"> 

		<div class="header">Iniciar Sesion</div>

		<div class="inputs">
		<input type="text" name="user" id="user" placeholder="Usuario or Email" class="input" required>
		<input type="password" name="password" id="password" placeholder="Contraseña" class="input" required>

		<input type="submit" value="Ingresar" name="ingresar" class="sigin-btn" >		
    	<p class="signup-link">No tienes una cuenta? <a href="<?php echo $_SERVER["PHP_SELF"] . "?ruta=signup"; ?>">Registrate</a></p>
    </div>
		
		</form>
		

		