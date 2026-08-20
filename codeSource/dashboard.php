<?php
include "connexion.php";


if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$limit = 10;
$page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
$start = ($page - 1) * $limit;
$id_user = (int)$_SESSION['id_user'];

try {
    // Nombre total de tâches
    $stmt = $conn->prepare("SELECT COUNT(id_task) AS total FROM tasks WHERE id_user = ?");
    $stmt->execute([$id_user]);
    $total_row = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);

    // Requête avec jointure et pagination (en dur pour LIMIT)
    $sql = "SELECT t.*, c.nom_categorie 
            FROM tasks t 
            LEFT JOIN categorie c ON t.id_categorie = c.id_categorie 
            WHERE t.id_user = :id_user
            ORDER BY 
                CASE t.priorite 
                    WHEN 'Haute' THEN 1 
                    WHEN 'Moyenne' THEN 2 
                    WHEN 'Basse' THEN 3 
                END,
                t.date_fin ASC
            LIMIT $start, $limit";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}
?>


<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Tasks List</h5>
        <a href="dash.php?page=task" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Add Task
        </a>
    </div>
    
    <div class="card-body">
        <?php if (count($tasks) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Priority</th>
                            <th>Category</th>
                            <th>Due Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td><?= $task['id_task'] ?></td>
                                <td><?= htmlspecialchars($task['titre']) ?></td>
                                <td><?= htmlspecialchars(substr($task['description'], 0, 50)) . 
                                    (strlen($task['description']) > 50 ? '...' : '') ?></td>
                                <td>
                                    <span class="badge 
                                        <?php 
                                        switch($task['priorite']) {
                                            case 'Haute': echo 'bg-danger'; break;
                                            case 'Moyenne': echo 'bg-warning text-dark'; break;
                                            default: echo 'bg-success';
                                        }
                                        ?>">
                                        <?= $task['priorite'] ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($task['nom_categorie'] ?? 'No category') ?></td>
                                <td>
                                    <?= date('d/m/Y', strtotime($task['date_fin'])) ?>
                                    <?php if (date('Y-m-d') > $task['date_fin']): ?>
                                        <span class="badge bg-secondary">Overdue</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="dash.php?page=edit&id=<?= $task['id_task'] ?>" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <a href="delete.php?id=<?= $task['id_task'] ?>" 
                                           class="btn btn-sm btn-outline-danger delete-btn" 
                                           title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="dash.php?page=tasks&page_num=<?= $page-1 ?>">Previous</a>
                        </li>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="dash.php?page=tasks&page_num=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="dash.php?page=tasks&page_num=<?= $page+1 ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="alert alert-info">
                No tasks found. <a href="dash.php?page=task" class="alert-link">Create a new task</a>
            </div>
        <?php endif; ?>
    </div>
</div>