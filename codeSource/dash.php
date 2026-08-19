<?php 
session_start();
ob_start();
include "connexion.php";

//if(!isset($_SESSION['id_user'])) {
    //header("Location: login.php");
    //exit;
//}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Gestion des tâches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --dark-color: #5a5c69;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--secondary-color);
        }
        
        .sidebar {
            background: linear-gradient(180deg, var(--dark-color) 10%, rgb(230,102,52) 100%);
            min-height: 100vh;
            width: 250px;
            position: fixed;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            padding: 1rem;
            margin: 0 0.5rem;
            border-radius: 0.35rem;
        }
        
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }
        
        .sidebar-brand {
            height: 4.375rem;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: 800;
            padding: 1.5rem 1rem;
            text-align: center;
            letter-spacing: 0.05rem;
            z-index: 1;
            color: #fff;
        }
        
        .user-profile {
            text-align: center;
            padding: 1.5rem 0;
        }
        
        .user-profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.2);
        }
        
        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
        }
        
        .topbar {
            height: 4.375rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            background-color: #fff;
        }
        
        .content-container {
            padding: 1.5rem;
        }
        
        .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.35rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- السايدبار -->
    <div class="sidebar">
        <div class="sidebar-brand">
           Task Management
        </div>
        
        <div class="user-profile">
            <img src="img/user.png" alt="User Profile">
            <h5 class="text-white mt-2 mb-0"><?php echo $_SESSION['username'] ?? 'User'; ?></h5>
        </div>
        
        <nav class="mt-4">
            <ul class="nav flex-column">
                <!---<li class="nav-item">
                    <a class="nav-link <?php echo (!isset($_GET['page'])) ? 'active' : '' ?>" href="dash.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>-->
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'task') ? 'active' : ''; ?>" 
                    href="dash.php?page=task">
                        <i class="fas fa-fw fa-plus-circle"></i>
                        <span>Add task</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (isset($_GET['page'])) && $_GET['page'] == 'tasks' ? 'active' : ''; ?>" 
                    href="dash.php?page=tasks">
                        <i class="fas fa-fw fa-tasks"></i>
                        <span>My tasks</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-fw fa-sign-out-alt"></i>
                        <span>logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    
    <!-- المحتوى الرئيسي -->
    <div class="main-content">
        <div class="content-container">
            <?php
            if (isset($_GET['msg'])) {
                $msg_type = $_GET['msg_type'] ?? 'success';
                echo '<div class="alert alert-'.$msg_type.' alert-dismissible fade show">';
                echo htmlspecialchars($_GET['msg']);
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                echo '</div>';
            }
            
            $page = $_GET['page'] ?? 'home';
            
            switch ($page) {
                case 'task':
                    include 'add_task.php';
                    break;
                case 'edit':
                    include 'edit.php';
                    break;
                case 'tasks':
                    include 'list.php';
                    break;
                //case 'home':
                //default:
                    //include 'dashboard_home.php';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if(!confirm('Are you sure you want to delete this task?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
<?php ob_end_flush(); ?>