<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require_once "db_connection.php";

// Initialize variables and error array
$task_name = $task_desc = $priority = $due_date = '';
$errors = [];

// Process form when submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $task_name = trim($_POST['task_name'] ?? '');
    $task_desc = trim($_POST['task_desc'] ?? '');
    $priority = trim($_POST['priority'] ?? 'Moyenne');
    $due_date = trim($_POST['due_date'] ?? '');

    // Server-side validation
    if (empty($task_name)) {
        $errors[] = "Le nom de la tâche est requis";
    } elseif (strlen($task_name) > 255) {
        $errors[] = "Le nom de la tâche est trop long (max 255 caractères)";
    }

    if (empty($due_date)) {
        $errors[] = "La date limite est requise";
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $due_date)) {
        $errors[] = "Format de date invalide (YYYY-MM-DD requis)";
    } elseif (strtotime($due_date) < strtotime(date('Y-m-d'))) {
        $errors[] = "La date limite ne peut pas être dans le passé";
    }

    if (!in_array($priority, ['Basse', 'Moyenne', 'Haute'])) {
        $errors[] = "Priorité invalide";
    }

    // If no errors, proceed with database insertion
    if (empty($errors)) {
        // Prepare SQL with prepared statement
        $sql = "INSERT INTO `crud` (`task_name`, `task_desc`, `priority`, `due_date`, `created_at`) 
                VALUES (?, ?, ?, ?, NOW())";

        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            die("Erreur de préparation de la requête: " . mysqli_error($conn));
        }

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssss", $task_name, $task_desc, $priority, $due_date);

        // Execute statement
        if (mysqli_stmt_execute($stmt)) {
            // Success - redirect to tasks list
            header("Location: dash.php?page=tasks&msg=Tâche créée avec succès&msg_type=success");
            exit();
        } else {
            $errors[] = "Erreur lors de la création de la tâche: " . mysqli_stmt_error($stmt);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}

// Close connection (optional, as PHP will close it automatically)
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Tâche</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Créer une nouvelle tâche</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <h5 class="alert-heading">Erreurs:</h5>
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
                               value="<?php echo htmlspecialchars($task_name); ?>" required maxlength="255">
                        <div class="form-text">Maximum 255 caractères</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="task_desc" class="form-label">Description</label>
                        <textarea class="form-control" name="task_desc" id="task_desc" rows="4"><?php echo htmlspecialchars($task_desc); ?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label">Priorité <span class="text-danger">*</span></label>
                            <select class="form-select" name="priority" id="priority" required>
                                <option value="Basse" <?php echo ($priority === 'Basse') ? 'selected' : ''; ?>>Basse</option>
                                <option value="Moyenne" <?php echo ($priority === 'Moyenne' || empty($priority)) ? 'selected' : ''; ?>>Moyenne</option>
                                <option value="Haute" <?php echo ($priority === 'Haute') ? 'selected' : ''; ?>>Haute</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label for="status" class="form-label">Statut <span class="text-danger">*</span></label>
                          <select class="form-select" name="status" id="status" required>
                           <option value="En attente" <?php echo ($status === 'En attente' || empty($status)) ? 'selected' : ''; ?>>En attente</option>
                           <option value="En cours" <?php echo ($status === 'En cours') ? 'selected' : ''; ?>>En cours</option>
                           <option value="Terminée" <?php echo ($status === 'Terminée') ? 'selected' : ''; ?>>Terminée</option>
                          </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="due_date" class="form-label">Date limite <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="due_date" id="due_date" 
                                   value="<?php echo htmlspecialchars($due_date); ?>" required 
                                   min="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-4">
                        <a href="dash.php?page=tasks" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary">Ajouter la tâche</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>