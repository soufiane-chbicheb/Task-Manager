<?php
include "db_connection.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch task data
$sql = "SELECT * FROM `crud` WHERE id = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$task = mysqli_fetch_assoc($result);

if (!$task) {
    header("Location: dash.php?page=tasks&msg=Tâche non trouvée&msg_type=danger");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = mysqli_real_escape_string($conn, $_POST['task_name']);
    $task_desc = mysqli_real_escape_string($conn, $_POST['task_desc']);
    $priority = mysqli_real_escape_string($conn, $_POST['priority']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
    
    // Validate inputs
    $errors = [];
    if (empty($task_name)) $errors[] = "Le nom de la tâche est requis";
    if (empty($due_date)) $errors[] = "La date limite est requise";
    
    if (empty($errors)) {
        $update_sql = "UPDATE `crud` SET 
                      `task_name` = ?, 
                      `task_desc` = ?, 
                      `priority` = ?, 
                      `due_date` = ? 
                      WHERE id = ?";
        
        $stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $task_name, $task_desc, $priority, $due_date, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: dash.php?page=tasks&msg=Tâche mise à jour avec succès&msg_type=success");
            exit;
        } else {
            $errors[] = "Erreur lors de la mise à jour: " . mysqli_error($conn);
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Modifier la tâche</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="mb-3">
                <label for="task_name" class="form-label">Nom de la tâche <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="task_name" id="task_name" 
                       value="<?= htmlspecialchars($task['task_name']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="task_desc" class="form-label">Description</label>
                <textarea class="form-control" name="task_desc" id="task_desc" rows="4">
                    <?= htmlspecialchars($task['task_desc']) ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="priority" class="form-label">Priorité <span class="text-danger">*</span></label>
                    <select class="form-select" name="priority" id="priority" required>
                        <option value="Basse" <?= $task['priority'] == 'Basse' ? 'selected' : '' ?>>Basse</option>
                        <option value="Moyenne" <?= $task['priority'] == 'Moyenne' ? 'selected' : '' ?>>Moyenne</option>
                        <option value="Haute" <?= $task['priority'] == 'Haute' ? 'selected' : '' ?>>Haute</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="due_date" class="form-label">Date limite <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="due_date" id="due_date" 
                           value="<?= $task['due_date'] ?>" required>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="dash.php?page=tasks" class="btn btn-secondary me-2">Annuler</a>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>