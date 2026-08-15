<?php

$dsn = "mysql:host=localhost;dbname=todolist";
$username = "root";
$password = "";

try{
    $conn = new PDO($dsn , $username . $password);
    //echo "connexion successfuly";
}
catch(PDOException $e){
    die("connexion failed :".$e->getMessage());
}





















?>