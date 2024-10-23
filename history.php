<?php
// history.php - Display historical water quality data

require 'db.php';

$sql = "SELECT * FROM water_quality ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr"> <!-- Changed to French -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique de la qualité de l'eau</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Add any additional styling for the PDF button here */
        .btn {
            background-color: #8D6E63; /* Bootstrap primary color */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Historique de la qualité de l'eau</h2>

        <!-- PDF Generation Button -->
        <form method="post" action="export.php">
            <input type="hidden" name="export" value="pdf">
            <button type="submit" class="btn">Générer le PDF</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>pH</th>
                    <th>Turbidité</th>
                    <th>Chlore</th>
                    <th>Conductivité</th>
                    <th>Température</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['pH'] ?></td>
                        <td><?= $row['turbidity'] ?></td>
                        <td><?= $row['chlorine'] ?></td>
                        <td><?= $row['conductivity'] ?></td>
                        <td><?= $row['temperature'] ?></td>
                        <td><?= $row['created_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
