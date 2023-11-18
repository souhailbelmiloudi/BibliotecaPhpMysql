<?php
// Validación de registro de usuario
if (isset($_POST["registrarse"])) {
    $user = isset($_POST["user"]) ? trim($_POST["user"]) : '';
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : '';
    $nombre = isset($_POST["nombre"]) ? trim($_POST["nombre"]) : '';
    $apellido_1 = isset($_POST["apellido_1"]) ? trim($_POST["apellido_1"]) : '';
    $apellido_2 = isset($_POST["apellido_2"]) ? trim($_POST["apellido_2"]) : '';
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';
    $password2 = isset($_POST["password2"]) ? trim($_POST["password2"]) : '';
    $rol="usuario";


    // Validar que el usuario no exista (debes definir la función validarUsuario)

    if (!empty($user) && !empty($email) && !empty($password) && !empty($password2)) {
        // Validar que el correo sea válido
        if (validarEmail($email)) {
            $hashedPassword = validarPassword($password, $password2);
            if (strpos($hashedPassword, "Error:") === false) {
                // Llama a la función para validar el usuario y continuar
                if (validarUsuario($user, $email)) {

                    if (insertarUsuario($user,$email,$nombre,$apellido_1,$apellido_2,$hashedPassword,$rol)) {
                        header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=login");
                        exit;
                    } else {
                    ?>
                        <script>
                            Swal.fire({
                                icon: "error",
                                title: "Error al insertar usuario en la base de datos"
                            });
                        </script>
                    <?php
                    }
                } else {
                ?>
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "El usuario  o el correo ya existe"
                        });
                    </script>
                <?php
                }
            } else {
                ?>
                <script>
                    Swal.fire({
                        icon: "error",
                        title: "<?php echo $hashedPassword; ?>"
                    });
                </script>
                <?php
            }
        } else {
            ?>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Error: El correo no es válido"
                });
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            Swal.fire({
                icon: "error",
                title: "Error: Debe rellenar todos los campos"
            });
        </script>
        <?php
    }
}
?>




<form action="<?php $_SERVER["PHP_SELF"]?>" method="POST" id="singup" class="form">
    <div class="header">Registro</div>
    <div class="inputs">
    <input class="input" type="text" name="user" id="user" placeholder="Usuario*" required>
    <input class="input" type="email" name="email" id="email" placeholder="Email@xxxx.xx*" required>
    <input class="input" type="text" name="nombre" id="nombre" placeholder="Nombre" required >
    <div class="flex">

        <input class="input" type="text" name="apellido_1" id="apellido_1" placeholder="Primer apellido*" required>
        <input class="input" type="text" name="apellido_2" id="apellido_2" placeholder="Segundo apellido" >

    </div>
    <div class="flex">
    <input class="input" type="password" name="password" id="password" placeholder="Contraseña*" required>
    <input class="input" type="password" name="password2" id="password2" placeholder="Repetir Contraseña*" required>
    </div>
   
    </div>
    <input type="submit" value="Registrarse" name="registrarse" class="submit">
</form>


