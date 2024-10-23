<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Water Quality Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Enter Water Quality Parameters</h1>
    <form action="process.php" method="post">
        <label for="pH">pH:</label>
        <input type="number" step="0.01" name="pH" required><br><br>

        <label for="turbidity">Turbidity (NTU):</label>
        <input type="number" step="0.01" name="turbidity" required><br><br>

        <label for="chlorine">Residual Chlorine (mg/l):</label>
        <input type="number" step="0.01" name="chlorine" required><br><br>

        <label for="conductivity">Conductivity (μS/cm):</label>
        <input type="number" step="0.01" name="conductivity" required><br><br>

        <label for="temperature">Temperature (°C):</label>
        <input type="number" step="0.01" name="temperature" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
