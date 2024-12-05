<?php

    function OpenConnection()  
        {  
            try  /*************CONECTANDO PHP CON SQL SERVER**************************** */
            {  
                $serverName = "DESKTOP-AORMAQD\SQLEXPRESS"; 
                $connectionOptions = array(
                    "Database" => "ProyectoCornejo",  
                    "UID" => "sa", 
                    "PWD" => "SQL123456"); 
                $conn = sqlsrv_connect($serverName, $connectionOptions);  
                return $conn;
                /*
                  //en mi caso no reconoce la función FormatErrors() por eso lo comente
                    
                if($conn == false)  
                    die(FormatErrors(sqlsrv_errors()));  
                */
            }  
            catch(Exception $e)  
            {  
                echo("Error en la conexion!");  
            }  
        }  
        //Esta función genera ejecuta una consulta cualquiera
            function ReadData($tsql)  
        {  
            try  
            {  
                $conn = OpenConnection();  
                $tsql ;  
                $getNames = sqlsrv_query($conn, $tsql);  
                /*if ($getNames == FALSE)  
                    die(FormatErrors(sqlsrv_errors()));  */
                $productCount = 0;  
                while($row = sqlsrv_fetch_array($getNames, SQLSRV_FETCH_ASSOC))  
                {  
                    echo($row['nombre']);  
                    echo("<br/>");  
                    $productCount++;  
                }  
                sqlsrv_free_stmt($getNames);  
                sqlsrv_close($conn); 
        
            }  
            catch(Exception $e)  
            {  
                echo("Error!");  
            }  
        } 
            


/* CONEXION A PHP MYSQL 

  $conexion = mysqli_connect("localhost", "root", "", "ferreteria_cornejo");

    /*if($conexion){
        echo 'Conectado exitosamente a la Base de Datos';//echo es una alerta e imprime un texto//
    }else{
        echo'No se ha podido conectar a la Base de Datos';
    }   */



?>