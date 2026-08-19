<?php


$dsn = "mysql:host=127.0.0.1;port=3307;dbname=todolist";
$username = "root";
$password = "";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connexion failed : " . $e->getMessage());
}






?>