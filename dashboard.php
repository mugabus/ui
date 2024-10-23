<?php
session_start();

// Check if the user is logged in, otherwise redirect to login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

// Determine the current page for active state
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Système de qualité de l'eau</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="dashboard-layout">
        <!-- Sidebar Menu -->
        <aside class="sidebar">
            <div class="logo-container">
                <img src="daniel.png" alt="Water Quality System" class="logo">
            </div>
            <nav class="sidebar-menu">
                <button class="sidebar-btn <?php echo ($current_page == 'view_data.php') ? 'active' : ''; ?>" onclick="loadPage('view_data.php', this)">Afficher les données</button>
                <button class="sidebar-btn <?php echo ($current_page == 'edit_class.php') ? 'active' : ''; ?>" onclick="loadPage('edit_class.php', this)">Modifier les classes d'eau</button>

                <button class="sidebar-btn <?php echo ($current_page == 'history.php') ? 'active' : ''; ?>" onclick="loadPage('history.php', this)">Afficher l'historique</button>
                <button class="sidebar-btn <?php echo ($current_page == 'analytics.php') ? 'active' : ''; ?>" onclick="loadPage('analytics.php', this)">Afficher les analyses</button>
                <button class="sidebar-btn logout-btn" onclick="location.href='logout.php'">Déconnexion</button>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content" id="content">
    <h1>Tableau de bord de la qualité de l'eau</h1>
    <p>Bienvenue dans le système de qualité de l'eau. Veuillez choisir une action dans la barre latérale.</p>
    <?php include 'graph.php'; ?>  <!-- This will display the graph content directly below the paragraph -->
</main>

    </div>
</body>
</html>
