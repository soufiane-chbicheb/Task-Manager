<?php
include "connexion.php";

$errors = [];
$task_name = $task_desc = $priority = $due_date = $id_categorie = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = trim($_POST['task_name']);
    $task_desc = trim($_POST['task_desc']);
    $priority = trim($_POST['priority']);
    $due_date = trim($_POST['due_date']);
    $id_categorie = trim($_POST['id_categorie']);
    $id_user = $_SESSION['id_user'];

    if (empty($task_name)) {
        $errors[] = "Task name is required";
    }

    if (empty($due_date)) {
        $errors[] = "Due date is required";
    }

    if (empty($errors)) {
        try {
            $sql = "INSERT INTO tasks (id_user, titre, description, date_fin, priorite, id_categorie) 
                    VALUES (:id_user, :titre, :description, :date_fin, :priorite, :id_categorie)";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':id_user' => $id_user,
                ':titre' => $task_name,
                ':description' => $task_desc,
                ':date_fin' => $due_date,
                ':priorite' => $priority,
                ':id_categorie' => $id_categorie
            ]);

            header("Location: dash.php?page=tasks&msg=Task created successfully&msg_type=success");
            exit();
        } catch(PDOException $e) {
            $errors[] = "Error: " . $e->getMessage();
        }
    }
}
?>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">Create New Task</h5>
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
                           value="<?= htmlspecialchars($task_name) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="task_desc" class="form-label">Description</label>
                    <textarea class="form-control" name="task_desc" id="task_desc" rows="4"><?= htmlspecialchars($task_desc) ?></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                        <select class="form-select" name="priority" id="priority" required>
                            <option value="Basse" <?= ($priority === 'Basse') ? 'selected' : '' ?>>Low</option>
                            <option value="Moyenne" <?= ($priority === 'Moyenne' || empty($priority)) ? 'selected' : '' ?>>Medium</option>
                            <option value="Haute" <?= ($priority === 'Haute') ? 'selected' : '' ?>>High</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <!--<label for="id_categorie" class="form-label">Category</label>
                       <select class="form-select" name="id_categorie" id="id_categorie">--->
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM categorie WHERE id_user = ?");
                            $stmt->execute([$_SESSION['id_user']]);
                            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            foreach ($categories as $category) {
                                echo '<option value="'.$category['id_categorie'].'"';
                                echo '>'.htmlspecialchars($category['nom_categorie']).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="due_date" class="form-label">Due Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="due_date" id="due_date" 
                               value="<?= htmlspecialchars($due_date) ?>" required>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="dash.php?page=tasks" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Add Task</button>
                </div>
            </form>
        </div>
    </div>
</div>