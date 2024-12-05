<?php
    
    
session_start();
include 'conexion_backend.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si las claves existen en el array $_POST
    if (isset($_POST['correo']) && isset($_POST['contrasena'])) {
        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena'];
        $contrasena = hash('sha512', $contrasena); // para tener acceso a los datos encriptados de la BD

        /******************VALIDAR SI EL CORREO O CONTRASENA EXISTE EN LA DB *****************/ 

        try {
            $conexion = OpenConnection();
            $query = "SELECT * FROM Usuarios_ferreteriac WHERE correo = ? AND contrasena = ?";
            $params = array($correo, $contrasena);
            $stmt = sqlsrv_query($conexion, $query, $params);

            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $validar_login = array();
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $validar_login[] = $row;
            }

            if (count($validar_login) > 0) {
                //echo "Inicio de sesión exitoso";
                $_SESSION['correo'] = $correo; // Guardar el correo en la sesión
                header("Location: bienvenida.php");
                exit(); // Asegúrate de detener la ejecución del script después de redirigir
            } else {
                echo "Correo o contraseña incorrectos";
                header("Location: " . $_SERVER['HTTP_REFERER']);
            }
            sqlsrv_free_stmt($stmt);
            sqlsrv_close($conexion);
        } catch (Exception $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    } else {
        echo "Por favor, rellene todos los campos.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
} else {
    echo "Formulario no enviado.";
    header("Location: " . $_SERVER['HTTP_REFERER']);
}




/*
    
    $nr            =  mysqli_num_rows($validar_login);

    if($nr == 1) {

    $mostrar    =  mysqli_fetch_array($validar_login);
    $enviarpass =  $mostrar['pass'];
    
    $paracorreo =  $correo;
    $titulo     =  "Recuperar Password";
    $mensaje    =  "Tu Password es : ".$enviarpass;
    $tucorreo   =  "From : xxxx@gmail.com";
    
    if(mail($paracorreo, $titulo,$mensaje,$tucorreo))
    
    {  echo "<script> alert ('Contraseña enviada'); window.location ='login.php' </script>";
    }else{
    echo "<script> alert ('Error'); window.location ='login.php' </script>";
    } 
    }else{
    echo "<script> alert ('Este correo No Existe'); window.location ='login.php' </script>"; 
    }
    */

?>