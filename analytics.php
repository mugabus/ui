<?php
require 'db.php';

// Fetch data for analytics (monthly or yearly reports, averages, etc.)
$timeFrame = isset($_GET['timeframe']) ? $_GET['timeframe'] : 'monthly';

try {
    // Fetch data based on the selected timeframe (monthly or yearly)
    $sql = ($timeFrame === 'yearly') ? 
        "SELECT YEAR(created_at) as period, AVG(pH) as avg_ph, MIN(pH) as min_ph, MAX(pH) as max_ph,
                AVG(turbidity) as avg_turbidity, MIN(turbidity) as min_turbidity, MAX(turbidity) as max_turbidity,
                AVG(chlorine) as avg_chlorine, MIN(chlorine) as min_chlorine, MAX(chlorine) as max_chlorine,
                AVG(conductivity) as avg_conductivity, MIN(conductivity) as min_conductivity, MAX(conductivity) as max_conductivity,
                AVG(temperature) as avg_temperature, MIN(temperature) as min_temperature, MAX(temperature) as max_temperature
        FROM water_quality
        GROUP BY YEAR(created_at)" :
        "SELECT MONTH(created_at) as period, AVG(pH) as avg_ph, MIN(pH) as min_ph, MAX(pH) as max_ph,
                AVG(turbidity) as avg_turbidity, MIN(turbidity) as min_turbidity, MAX(turbidity) as max_turbidity,
                AVG(chlorine) as avg_chlorine, MIN(chlorine) as min_chlorine, MAX(chlorine) as max_chlorine,
                AVG(conductivity) as avg_conductivity, MIN(conductivity) as min_conductivity, MAX(conductivity) as max_conductivity,
                AVG(temperature) as avg_temperature, MIN(temperature) as min_temperature, MAX(temperature) as max_temperature
        FROM water_quality
        GROUP BY MONTH(created_at)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch the most common class (based on pH range over time)
    $sql_common_class = "SELECT CASE
        WHEN pH < 6.5 THEN 'Acidic'
        WHEN pH BETWEEN 6.5 AND 8.5 THEN 'Neutral'
        ELSE 'Basic'
        END as class,
        COUNT(*) as frequency
        FROM water_quality
        GROUP BY class
        ORDER BY frequency DESC
        LIMIT 1";

    $stmt_class = $pdo->prepare($sql_common_class);
    $stmt_class->execute();
    $commonClass = $stmt_class->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Quality Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Water Quality Analytics</h2>

        <!-- Timeframe Selector (Monthly/Yearly) -->
        

        <!-- Display Analytics Data -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th><?= ucfirst($timeFrame) ?></th>
                        <th>Avg pH</th>
                        <th>Min pH</th>
                        <th>Max pH</th>
                        <th>Avg Turbidité</th>
                        <th>Min Turbidité</th>
                        <th>Max Turbidité</th>
                        <th>Avg Chlore</th>
                        <th>Min Chlore</th>
                        <th>Max Chlore</th>
                        <th>Avg Conductivité</th>
                        <th>Min Conductivité</th>
                        <th>Max Conductivité</th>
                        <th>Avg Température</th>
                        <th>Min Température</th>
                        <th>Max Température</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['period']) ?></td>
                            <td><?= number_format($row['avg_ph'], 2) ?></td>
                            <td><?= number_format($row['min_ph'], 2) ?></td>
                            <td><?= number_format($row['max_ph'], 2) ?></td>
                            <td><?= number_format($row['avg_turbidity'], 2) ?></td>
                            <td><?= number_format($row['min_turbidity'], 2) ?></td>
                            <td><?= number_format($row['max_turbidity'], 2) ?></td>
                            <td><?= number_format($row['avg_chlorine'], 2) ?></td>
                            <td><?= number_format($row['min_chlorine'], 2) ?></td>
                            <td><?= number_format($row['max_chlorine'], 2) ?></td>
                            <td><?= number_format($row['avg_conductivity'], 2) ?></td>
                            <td><?= number_format($row['min_conductivity'], 2) ?></td>
                            <td><?= number_format($row['max_conductivity'], 2) ?></td>
                            <td><?= number_format($row['avg_temperature'], 2) ?></td>
                            <td><?= number_format($row['min_temperature'], 2) ?></td>
                            <td><?= number_format($row['max_temperature'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Display Most Common Class -->
        <div class="alert alert-info text-center mt-4">
            <strong>Most Common Class: </strong><?= htmlspecialchars($commonClass['class']) ?> (<?= $commonClass['frequency'] ?> records)
        </div>

        <!-- Export Reports Section -->
        <div class="d-flex justify-content-center mt-4">
            <form method="POST" action="export.php" class="d-flex">
                <button type="submit" name="export" value="pdf" class="btn btn-danger me-2">Export as PDF</button>
                <button type="submit" name="export" value="csv" class="btn btn-success">Export to CSV</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
