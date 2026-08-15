<?php
include "connexion.php";

//if (!isset($_SESSION['id_user'])) {
    //header("Location: login.php");
    //exit;
//}

$id_task = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id_task <= 0) {
    header("Location: dash.php?page=tasks&msg=Invalid task ID&msg_type=danger");
    exit;
}
try {
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id_task = ? AND id_user = ?");
    $stmt->execute([$id_task, $_SESSION['id_user']]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$task) {
        header("Location: dash.php?page=tasks&msg=Task not found&msg_type=danger");
        exit;
    }
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = trim($_POST['task_name']);
    $task_desc = trim($_POST['task_desc']);
    $priority = trim($_POST['priority']);
    $due_date = trim($_POST['due_date']);
    $id_categorie = trim($_POST['id_categorie']);

    if (empty($task_name)) $errors[] = "Task name is required";
    if (empty($due_date)) $errors[] = "Due date is required";
    
    if (empty($errors)) {
        try {
            $sql = "UPDATE tasks SET 
                   titre = :titre,
                   description = :description,
                   priorite = :priorite,
                   date_fin = :date_fin,
                   id_categorie = :id_categorie
                   WHERE id_task = :id_task AND id_user = :id_user";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':titre' => $task_name,
                ':description' => $task_desc,
                ':priorite' => $priority,
                ':date_fin' => $due_date,
                ':id_categorie' => $id_categorie,
                ':id_task' => $id_task,
                ':id_user' => $_SESSION['id_user']
            ]);
            
            header("Location: dash.php?page=tasks&msg=Task updated successfully&msg_type=success");
            exit;
        } catch(PDOException $e) {
            $errors[] = "Error: " . $e->getMessage();
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Task</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label for="task_name" class="form-label">Task Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="task_name" id="task_name" 
                       value="<?= htmlspecialchars($task['titre']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="task_desc" class="form-label">Description</label>
                <textarea class="form-control" name="task_desc" id="task_desc" rows="4"><?= htmlspecialchars($task['description']) ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                    <select class="form-select" name="priority" id="priority" required>
                        <option value="Basse" <?= $task['priorite'] == 'Basse' ? 'selected' : '' ?>>Low</option>
                        <option value="Moyenne" <?= $task['priorite'] == 'Moyenne' ? 'selected' : '' ?>>Medium</option>
                        <option value="Haute" <?= $task['priorite'] == 'Haute' ? 'selected' : '' ?>>High</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="id_categorie" class="form-label">Category</label>
                    <select class="form-select" name="id_categorie" id="id_categorie">
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM categorie WHERE id_user = ?");
                        $stmt->execute([$_SESSION['id_user']]);
                        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        foreach ($categories as $category) {
                            echo '<option value="'.$category['id_categorie'].'"';
                            echo ($task['id_categorie'] == $category['id_categorie']) ? ' selected' : '';
                            echo '>'.htmlspecialchars($category['nom_categorie']).'</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="due_date" class="form-label">Due Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="due_date" id="due_date" 
                           value="<?= htmlspecialchars($task['date_fin']) ?>" required>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="dash.php?page=tasks" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Task</button>
            </div>
        </form>
    </div>
</div>