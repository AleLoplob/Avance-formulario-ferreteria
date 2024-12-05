<?php
    
    session_start();
    include"conexion_backend.php";
    
    if(isset($_SESSION['Usuarios_ferreteriac'])){ /* Si exixte una sesion(de la tabla usuarios_ferr..) iniciada..*/
        header("location: bienvenida.php");       /*   redirigeme a ..  */  
        
    }

    if (isset($_SESSION['error'])) {
        echo '<script>alert("' . $_SESSION['Error en el inicio de sesion'] . '");</script>';
        unset($_SESSION['error']);
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro - Ferreteria</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,
500;1,700;1,900&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/css/estilos.css">
</head>
    <script>
            function validarFormulario() {
                var nombre_completo = document.getElementById('nombre_completo').value;
                if (nombre_completo.length < 8) {
                    alert("El nombre completo debe tener al menos 8 caracteres.");
                    return false;
                }
                return true;
            }
    </script>
<body>
    <main>
        <div class="contenedor__todo">

            <div class="caja__trasera">

                <div class="caja__trasera-login">
                    <h3>¿Ya tienes cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>

                <div class="caja__trasera-registro">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Registrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse">Registrarse</button>
                </div>

            </div>
            
            <!--Formulario Login y Registro-->
            <div class="contenedor__login-registro">
                <!--Login-->
                <form action="login_usuario_bend.php" method="POST" class="formulario__login">
                    
                    <h2>Iniciar Sesión</h2>
                    <input type="text" placeholder="Correo Electronico" name="correo">
                    <input type="password" placeholder="Contraseña" name="contrasena">
                    <button>Entrar</button>

                </form>

                


                <!--Registro-->
                <form action="registro_usuario_be.php" method="POST" class="formulario__registro" id=form onsubmit="return validarFormulario()"> 

                    <h2>Registrarse</h2>
                    <input type="text" placeholder="Nombre Completo" name="nombre_completo" required minlength="8">
                    <input type="text" placeholder="Run Completo sin caracteres especiales[.,-])" id="rut_completo"  name="rut_completo" required>
                <!--<input type="text" placeholder="Dv"  name="digito" size="1" required> -->                       
                    <input type="email" placeholder="Correo Electronico" name="correo" required>
                 <!--   <input type="text" placeholder="Usuario" name="usuario">  -->
                    <input type="password" placeholder="Contraseña" name="contrasena" required minlength="6">
                    <button>Registrarse</button> 

                </form>
            </div>     

        </div>

    </main>    
    <script src="assets/js/script.js"></script>
</body>
</html>