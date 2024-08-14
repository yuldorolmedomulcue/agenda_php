<?php
//<!----------------------------------------Paso 1--------------------------------------------->

    //Configurar datos de acceso a la Base de datos
    $host = "localhost";
    $dbname = "agenda1";
    $dbuser = "postgres";
    $userpass = "1234";
    
    $dsn = "pgsql:host=$host;port=5432;dbname=$dbname;user=$dbuser;password=$userpass";
    
    try{
     //Crear conexión a postgress
     $conn = new PDO($dsn);
    
     //Mostrar mensaje si la conexión es correcta
     if($conn){
    //   echo "Conectado a la base $dbname correctamente!"; 
     echo "\n";
     }
    }catch (PDOException $e){
     //Si hay error en la conexión mostrarlo
     echo $e->getMessage();
    }