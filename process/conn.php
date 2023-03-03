<?php
    $servername = 'localhost';
    $username = 'root';
    $pass = '';
    try {
        $conn = new PDO ("mysql:host=$servername;dbname=test_project_exercise",$username,$pass);

         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
  
    }catch(PDOException $e){
        echo 'NO CONNECTION'.$e->getMessage();
    }
?>