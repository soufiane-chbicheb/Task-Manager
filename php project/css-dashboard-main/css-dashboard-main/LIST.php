<?php
include "db_connection.php";

// Pagination
$limit = 10;
$page = isset($_GET['page_num']) ? (int)$_GET['page_num'] : 1;
$start = ($page - 1) * $limit;

// Get total records
$total_query = "SELECT COUNT(id) AS total FROM `crud`";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Get tasks with pagination
$sql = "SELECT * FROM `crud` ORDER BY 
        CASE priority 
            WHEN 'Haute' THEN 1 
            WHEN 'Moyenne' THEN 2 
            WHEN 'Basse' THEN 3 
        END, due_date ASC 
        LIMIT $start, $limit";
$result = mysqli_query($conn, $sql);
?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Liste des tâches</h5>
        <a href="dash.php?page=task" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Ajouter une tâche
        </a>
    </div>
    
    <div class="card-body">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Priorité</th>
                            <th>Date limite</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['task_name']) ?></td>
                                <td><?= htmlspecialchars(substr($row['task_desc'], 0, 50)) . (strlen($row['task_desc']) > 50 ? '...' : '') ?></td>
                                <td>
                                    <span class="badge 
                                        <?php 
                                        switch($row['priority']) {
                                            case 'low': echo 'bg-danger'; break;
                                            case 'Moyenne': echo 'bg-warning text-dark'; break;
                                            default: echo 'bg-success';
                                        }
                                        ?>">
                                        <?= $row['priority'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?= date('d/m/Y', strtotime($row['due_date'])) ?>
                                    <?php if (date('Y-m-d') > $row['due_date']): ?>
                                        <span class="badge bg-secondary">En retard</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="dash.php?page=edit&id=<?= $row['id'] ?>" 
                                           class="btn btn-sm btn-outline-primary" 
                                           data-bs-toggle="tooltip" 
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <a href="delete.php?id=<?= $row['id'] ?>" 
                                           class="btn btn-sm btn-outline-danger delete-btn" 
                                           data-bs-toggle="tooltip" 
                                           title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="dash.php?page=tasks&page_num=<?= $page-1 ?>">Précédent</a>
                        </li>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="dash.php?page=tasks&page_num=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="dash.php?page=tasks&page_num=<?= $page+1 ?>">Suivant</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="alert alert-info">
                Aucune tâche trouvée. <a href="dash.php?page=task" class="alert-link">Créer une nouvelle tâche</a>
            </div>
        <?php endif; ?>
    </div>
</div>