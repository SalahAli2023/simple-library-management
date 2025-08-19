<?php
// Initialize session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set default page title
$pageTitle = $pageTitle ?? 'Library Management System';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #3498db;
            --sidebar-width: 250px;
        }
        
        body {
            padding-top: 60px;
            background-color: #f8f9fa;
        }
        
        .navbar-brand {
            font-weight: 600;
        }
        
        #sidebar {
            width: var(--sidebar-width);
            height: calc(100vh - 60px);
            position: fixed;
            background: #2c3e50;
            transition: all 0.3s;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s;
        }
        
        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            
            .main-content {
                margin-left: 0;
            }
            
            #sidebar.active {
                margin-left: 0;
            }
        }
    </style>
    
    <?= $customCSS ?? '' ?>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <button class="btn btn-sm btn-outline-light me-2 d-lg-none" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-book-open me-2"></i>LibSys
            </a>
            
            <div class="d-flex">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i><?= htmlspecialchars($_SESSION['username'] ?? 'User') ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-light">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div id="sidebar" class="bg-primary d-flex flex-column flex-shrink-0 p-3 text-white">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="index.php?action=dashboard" class="nav-link <?= ($_GET['action'] ?? '') === 'dashboard' ? 'active' : 'text-white' ?>">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </li>
            <li>
                <a href="index.php?action=books" class="nav-link <?= ($_GET['action'] ?? '') === 'books' ? 'active' : 'text-white' ?>">
                    <i class="fas fa-book me-2"></i>Books
                </a>
            </li>
            <li>
                <a href="index.php?action=users" class="nav-link <?= ($_GET['action'] ?? '') === 'users' ? 'active' : 'text-white' ?>">
                    <i class="fas fa-users me-2"></i>Users
                </a>
            </li>
            <li>
                <a href="index.php?action=reports" class="nav-link <?= ($_GET['action'] ?? '') === 'reports' ? 'active' : 'text-white' ?>">
                    <i class="fas fa-chart-bar me-2"></i>Reports
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-<?= $_SESSION['flash_message']['type'] ?> alert-dismissible fade show">
                <?= htmlspecialchars($_SESSION['flash_message']['text']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>