<?php
require 'db.php';

// If form is submitted, process the update
if (isset($_POST['update'])) {
    $class_id = $_POST['class_id'];
    $ph_min = $_POST['ph_min'];
    $ph_max = $_POST['ph_max'];
    $turbidity_max = $_POST['turbidity_max'];
    $conductivity_max = $_POST['conductivity_max'];
    $temperature_min = $_POST['temperature_min'];
    $temperature_max = $_POST['temperature_max'];

    // Update the class details in the database
    $stmt = $pdo->prepare("
        UPDATE water_classes 
        SET ph_min = ?, ph_max = ?, turbidity_max = ?, conductivity_max = ?, temperature_min = ?, temperature_max = ? 
        WHERE id = ?
    ");
    $stmt->execute([$ph_min, $ph_max, $turbidity_max, $conductivity_max, $temperature_min, $temperature_max, $class_id]);

    echo "<div class='success-message'>Class details updated successfully!</div>";
}

// Fetch all classes for editing
$query = $pdo->query("SELECT * FROM water_classes");
$classes = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier les classes de qualité de l'eau</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        

        <form method="POST" class="edit-form">
            <label for="class_id">Sélectionnez la classe à modifier:</label>
            <select name="class_id" id="class_id" class="form-control">
                <?php foreach ($classes as $class): ?>
                    <option value="<?= $class['id'] ?>"><?= $class['name'] ?></option>
                <?php endforeach; ?>
            </select>
            
            <h2>Mettre à jour les paramètres:</h2>

            <label for="ph_min">pH Min:</label>
            <input type="number" step="0.1" name="ph_min" id="ph_min" class="form-control" required>

            <label for="ph_max">pH Max:</label>
            <input type="number" step="0.1" name="ph_max" id="ph_max" class="form-control" required>

            <label for="turbidity_max">Turbidité Max (NTU):</label>
            <input type="number" step="0.1" name="turbidity_max" id="turbidity_max" class="form-control" required>

            <label for="conductivity_max">Conductivité Max (μS/cm):</label>
            <input type="number" step="0.1" name="conductivity_max" id="conductivity_max" class="form-control" required>

            <label for="temperature_min">Température Min (°C):</label>
            <input type="number" step="0.1" name="temperature_min" id="temperature_min" class="form-control" required>

            <label for="temperature_max">Température Max (°C):</label>
            <input type="number" step="0.1" name="temperature_max" id="temperature_max" class="form-control" required>

            <button type="submit" name="update" class="btn">Mettre à jour la classe</button>
        </form>
    </div>
</body>
</html>
