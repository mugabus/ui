<?php
// alerts.php - Display alerts when water quality is unsafe

require 'db.php';

// Define thresholds for alerts (you can adjust these values)
$turbidity_threshold = 15;
$conductivity_threshold = 2250;

// Fetch water quality records exceeding the thresholds
$sql = "SELECT * FROM water_quality WHERE turbidity > ? OR conductivity > ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$turbidity_threshold, $conductivity_threshold]);
$alerts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Quality Alerts</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Water Quality Alerts</h2>
        <?php if (count($alerts) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>pH</th>
                        <th>Turbidity</th>
                        <th>Chlorine</th>
                        <th>Conductivity</th>
                        <th>Temperature</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alerts as $alert): ?>
                        <tr>
                            <td><?= $alert['id'] ?></td>
                            <td><?= $alert['pH'] ?></td>
                            <td style="color: <?= $alert['turbidity'] > $turbidity_threshold ? 'red' : 'black'; ?>;">
                                <?= $alert['turbidity'] ?>
                            </td>
                            <td><?= $alert['chlorine'] ?></td>
                            <td style="color: <?= $alert['conductivity'] > $conductivity_threshold ? 'red' : 'black'; ?>;">
                                <?= $alert['conductivity'] ?>
                            </td>
                            <td><?= $alert['temperature'] ?></td>
                            <td><?= $alert['created_at'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No alerts found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
