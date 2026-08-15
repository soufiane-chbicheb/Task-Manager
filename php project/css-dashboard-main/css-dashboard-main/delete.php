<?php
include "db_connection.php";

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Verify task exists
    $check_sql = "SELECT id FROM `crud` WHERE id = ?";
    $stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $delete_sql = "DELETE FROM `crud` WHERE id = ?";
        $stmt = mysqli_prepare($conn, $delete_sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: dash.php?page=tasks&msg=Tâche supprimée avec succès&msg_type=success");
            exit;
        } else {
            header("Location: dash.php?page=tasks&msg=Erreur lors de la suppression&msg_type=danger");
            exit;
        }
    } else {
        header("Location: dash.php?page=tasks&msg=Tâche non trouvée&msg_type=danger");
        exit;
    }
} else {
    header("Location: dash.php?page=tasks");
    exit;
}
?>