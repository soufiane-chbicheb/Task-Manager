<?php
// 1. Database connection check
if(!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Test query removed since it was causing the issue
// The error occurred because you were freeing the result twice
?>

<div class="dashboard-container" style="display: flex; flex-direction: column; gap: 20px;">
    <!-- Stats Cards Row -->
    <div class="row" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: space-between;">
        <!-- High Priority Tasks Card -->
        <div class="col-xl-4 col-md-6 mb-4 flex-item">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                High Priority Tasks</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php 
                                $high_priority_query = "SELECT COUNT(*) as count FROM crud WHERE priority = 'high' AND id = " . $_SESSION['id'];
                                $result = mysqli_query($conn, $high_priority_query);
                                if($result) {
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['count'];
                                    mysqli_free_result($result);
                                } else {
                                    echo "0";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Tasks Card -->
        <div class="col-xl-4 col-md-6 mb-4 flex-item">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Tasks</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php 
                                $pending_query = "SELECT COUNT(*) as count FROM crud WHERE status = 'pending' AND user_id = " . $_SESSION['user_id'];
                                $result = mysqli_query($conn, $pending_query);
                                if($result) {
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['count'];
                                    mysqli_free_result($result);
                                } else {
                                    echo "0";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Tasks Card -->
        <div class="col-xl-4 col-md-6 mb-4 flex-item">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Completed Tasks</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php 
                                $completed_query = "SELECT COUNT(*) as count FROM crud WHERE status = 'completed' AND user_id = " . $_SESSION['user_id'];
                                $result = mysqli_query($conn, $completed_query);
                                if($result) {
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['count'];
                                    mysqli_free_result($result);
                                } else {
                                    echo "0";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Tasks Table -->
    <div class="card shadow mb-4 flex-item">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Recent Tasks</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Due Date</th>
                            <th>Priority</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $recent_tasks_query = "SELECT * FROM crud WHERE user_id = " . $_SESSION['user_id'] . " ORDER BY created_at DESC LIMIT 5";
                        $result = mysqli_query($conn, $recent_tasks_query);
                        
                        if($result && mysqli_num_rows($result) > 0) {
                            while ($task = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($task['title']) . "</td>";
                                echo "<td>" . htmlspecialchars(substr($task['description'], 0, 50)) . "...</td>";
                                echo "<td>" . htmlspecialchars($task['due_date']) . "</td>";
                                echo "<td>";
                                if ($task['priority'] == 'high') {
                                    echo '<span class="badge bg-danger">High</span>';
                                } elseif ($task['priority'] == 'medium') {
                                    echo '<span class="badge bg-warning">Medium</span>';
                                } else {
                                    echo '<span class="badge bg-primary">Low</span>';
                                }
                                echo "</td>";
                                echo "<td>";
                                if ($task['status'] == 'completed') {
                                    echo '<span class="badge bg-success">Completed</span>';
                                } elseif ($task['status'] == 'progress') {
                                    echo '<span class="badge bg-info">In Progress</span>';
                                } else {
                                    echo '<span class="badge bg-secondary">Pending</span>';
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                            mysqli_free_result($result);
                        } else {
                            echo "<tr><td colspan='5'>No tasks found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .flex-item {
        flex: 1;
        min-width: 300px;
    }
    
    @media (max-width: 768px) {
        .flex-item {
            min-width: 100%;
        }
    }
</style>