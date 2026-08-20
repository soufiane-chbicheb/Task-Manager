<?php

session_start();

require_once 'connexion.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {

    $id_task = $_GET['id'];
    $id_user = $_SESSION['id_user'];

    $sql = "DELETE FROM tasks 
            WHERE id_task = :id_task 
            AND id_user = :id_user";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':id_task' => $id_task,
        ':id_user' => $id_user
    ]);
}

header("Location: list.php");
exit;
?>