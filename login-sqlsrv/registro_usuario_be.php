<?php
    
    session_start();
    
    include'conexion_backend.php';
    
    $nombre_completo= $_POST['nombre_completo'];
    $rut_completo= $_POST['rut_completo'];
    $correo = $_POST['correo'];
    $contrasena =$_POST['contrasena'];
    $conexion=OpenConnection();

    //******************Validar nombre completo *******************************
   
    if (empty($nombre_completo) || strlen($nombre_completo) < 8){
        $_SESSION['error'] = "Error, el nombre completo debe tener al menos 8 caracteres sin números.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    //*************** Validar Formato de Correo******************************** */

 

    function validarCorreo($correo) {

        // formato de un correo electrónico
        $patron = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        // Comprobar si el correo coincide con el patrón
        if (preg_match($patron, $correo)) {
            return true; // El correo electrónico es válido
        } else {
            return false; // El correo electrónico es inválido
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $correo = $_POST['correo'];

        if (!validarCorreo($correo)) {
            $_SESSION['error'] = "Error, Correo electrónico no válido";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }    

    /**********************Validador del rut chileno**********************************/ 

    function validarRUT($rut_completo) {

        // Eliminar puntos y guiones del RUT
        $rut_completo = str_replace(['.', '-'], '', $rut_completo);
        
        // Extraer el dígito verificador
        $digitoVerificador = substr($rut_completo, -1);
        $rut = substr($rut_completo, 0, -1);
    
        $contar = 2;
        $acumulador = 0;
    
        // Convertir el dígito verificador a minúsculas
        $digitoVerificador = strtolower($digitoVerificador);
    
        while ($rut > 0) {
            $contardeauno = ($rut % 10) * $contar;
            $acumulador += $contardeauno;
            $rut = intval($rut / 10);
            $contar++;
    
            if ($contar == 8) {
                $contar = 2;
            }
        }
    
        $division = $acumulador % 11;
        $dig = 11 - $division;
    
        if ($dig == 10) {
            $dig2 = 'k';
        } elseif ($dig == 11) {
            $dig2 = '0';
        } else {
            $dig2 = strval($dig);
        }
    
        return $digitoVerificador == $dig2;
    }
    
    //*******Obtener el RUT  del formulario******
    $rut_completo = $_POST['rut_completo'];
    
    if (!validarRUT($rut_completo)) {
        $_SESSION['error'] = "Error, Rut No Válido"; //Si el RUT no es válido,se almacena un mensaje de error en la variable de sesión 
        header("Location: " . $_SERVER['HTTP_REFERER']);//envía una cabecera HTTP al navegador. En este caso, la cabecera indica una redirección a la página anterior
        exit(); //detiene el script
    }



    /***************Para Encriptar la contraseña******************/ 
    $contrasena= hash('sha512',$contrasena);

    /************** Query para insertar valores en la BD ***************/
    $queryreg = "INSERT INTO Usuarios_ferreteriac(nombre_completo, rut_completo, correo, contrasena)
                VALUES('$nombre_completo', '$rut_completo', '$correo','$contrasena')";


//********************Verificar que el correo no se repita en la base de datos con SQLSERVE */

    $query = "SELECT * FROM Usuarios_ferreteriac WHERE correo = ?";
    $params = array($correo);

    $stmt = sqlsrv_query($conexion, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($stmt)) {
        echo '
            <script>
                alert("Este correo ya está registrado, intente con otro diferente");
                window.location = "login.php";
            </script>
        ';
        exit();
    }

    sqlsrv_free_stmt($stmt);

    /*//*****************Verificar que el correo no se repita en la base de datos con MYSQL****************

    $verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios_ferreteriac WHERE correo ='$correo' ");

    if(mysqli_num_rows($verificar_correo) > 0){
        echo'
            <script>
                alert("Este correo ya esta Registrado, intente con otro diferente");
                window.location = "../login.php";
            </script>
        ';
        exit();//cuando el código llegue al exit,se imprime un mensaje y termina el scrips actual, por lo que no almacenará 
    }      */



        // *************CONEXION PARA ALMACENAR USUARIOS EN DB DE SQL SERVER*****************************

        $ejecutar = sqlsrv_query($conexion, $queryreg);

    if ($ejecutar) {
        echo "<script>
            alert('Usuario Registrado Exitosamente');
            location.href ='login.php';
            </script>";
    } else {
        echo "<script>
            alert('Error, intentalo de nuevo! El Usuario No ha sido almacenado');
            window.location ='login.php';
            </script>";
    }

    sqlsrv_close($conexion);

        
     /*************CONEXION PARA ALMACENAR USUARIOS EN DB DE MYSQL*****************************

    
    
        $ejecutar = mysqli_query($conexion, $queryreg);

    if($ejecutar){
        echo "<script>
                alert ('Usuario Registrado Exitosamente');
                location.href ='../login.php';
                </script> 
        ";
    }else{
        echo '<script>
                alert ("Error, intentalo de nuevo! El Usuario No ha sido almacenado");
                window.Location ="../login.php";
                </script>  
        
        
        ';
        
    }

    mysqli_close($conexion);   */

?>