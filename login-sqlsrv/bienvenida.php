<?php

    session_start();
    /*if(!isset($_SESSION['Usuarios_ferreteriac'])){ //si no existe la variable de session usuario
        echo'
            <script>
                alert("por favor debes iniciar sesion");
                window.location = "login.php";  
            </script>
        ';
        
        session_destroy();    /* luego destruye cualqier sesion que exista
        die();      // y ppara de ejecutar el codigo para que no siga con la pagina abajo

    }
    */

        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIENVENIDO CHARLY QL</title>
</head>
<body>
    <H2>BIENVENIDO AL MUNDO COPY-PASTE</H2>
    <a href="php/cerrar_session.php">Cerrar Sesión</a>
    

</body>
</html>
