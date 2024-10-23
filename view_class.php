<?php
// Connect to the database
require 'db.php';

// Fetch the most recent water quality data
$sql = "SELECT * FROM water_quality ORDER BY created_at DESC LIMIT 1";
$stmt = $pdo->query($sql);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

// Determine the class based on the water quality data
$class = '';
$color = '';

if ($data) {
    $ph = $data['pH'];
    $turbidity = $data['turbidity'];
    $chlorine = $data['chlorine'];
    $conductivity = $data['conductivity'];
    $temperature = $data['temperature'];

    if ($turbidity < 1 && $conductivity < 800) {
        $class = 'Class 1: Superior Quality Water';
        $color = '#66BB6A'; // Green for best quality
    } elseif ($turbidity < 5 && $conductivity < 1500) {
        $class = 'Class 2: Acceptable Quality Water';
        $color = '#FFA726'; // Orange for acceptable quality
    } elseif ($turbidity < 15 && $conductivity < 2250) {
        $class = 'Class 3: Acceptable but Requires Treatment';
        $color = '#FF7043'; // Darker orange for treatment required
    } else {
        $class = 'Class 4: Poor Quality Water';
        $color = '#EF5350'; // Red for poor quality
    }
} else {
    $class = 'No data available';
    $color = '#CCCCCC'; // Grey if no data
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Water Class</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .class-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            background-color: <?php echo $color; ?>;
            color: white;
            text-align: center;
        }
        .class-container h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .class-container p {
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="class-container">
    <h1><?php echo $class; ?></h1>
    <?php if ($data): ?>
        <p><strong>pH:</strong> <?php echo $data['pH']; ?></p>
        <p><strong>Turbidité:</strong> <?php echo $data['turbidity']; ?> NTU</p>
        <p><strong>Résiduel de chlore:</strong> <?php echo $data['chlorine']; ?> mg/l</p>
        <p><strong>Conductivité:</strong> <?php echo $data['conductivity']; ?> μS/cm</p>
        <p><strong>Température:</strong> <?php echo $data['temperature']; ?>°C</p>
    <?php else: ?>
        <p>Aucune donnée disponible sur la qualité de l'eau.</p>
    <?php endif; ?>
</div>

</body>
</html>
