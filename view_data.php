<?php
require 'db.php'; // This line should correctly include the connection

// Fetch data from the water_quality table
$query = $pdo->query("SELECT * FROM water_quality ORDER BY created_at DESC");
$data = $query->fetchAll(PDO::FETCH_ASSOC);

function classifyWaterQuality($row) {
    // Classification logic with French translations
    if ($row['turbidity'] < 1 && $row['conductivity'] < 800) {
        return 'Classe 1 : Qualité Supérieure';
    } elseif ($row['turbidity'] < 5 && $row['conductivity'] < 1500) {
        return 'Classe 2 : Qualité Acceptable';
    } elseif ($row['turbidity'] < 15 && $row['conductivity'] < 2250) {
        return 'Classe 3 : Nécessite un Traitement Supplémentaire';
    } else {
        return 'Classe 4 : Mauvaise Qualité';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Données sur la qualité de l'eau</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file here -->
</head>
<body>
    <div class="container">
        <h1>Données sur la qualité de l'eau</h1>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>pH</th>
                    <th>Turbidité (NTU)</th>
                    <th>Chlore (mg/L)</th>
                    <th>Conductivité (µS/cm)</th>
                    <th>Température (°C)</th>
                    <th>Classe</th>
                    <th>Horodatage</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($data): ?>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['pH']; ?></td>
                            <td><?php echo $row['turbidity']; ?></td>
                            <td><?php echo $row['chlorine']; ?></td>
                            <td><?php echo $row['conductivity']; ?></td>
                            <td><?php echo $row['temperature']; ?></td>
                            <td><?php echo classifyWaterQuality($row); ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Aucune donnée disponible</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Back to Dashboard button -->
        <a href="dashboard.php" class="btn">Retour au tableau de bord</a>
    </div>
</body>
</html>
