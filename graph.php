<?php
// Check if session is not already started before starting it
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in, otherwise redirect to login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'lover');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data for the water_quality table
$sql_quality = "SELECT pH, turbidity, chlorine, conductivity, temperature, created_at FROM water_quality";
$result_quality = $conn->query($sql_quality);

// Prepare data for the water_quality chart
$dates_quality = [];
$ph_levels = [];
$turbidity_levels = [];
$chlorine_levels = [];
$conductivity_levels = [];

if ($result_quality && $result_quality->num_rows > 0) {
    while ($row = $result_quality->fetch_assoc()) {
        $dates_quality[] = $row['created_at'];
        $ph_levels[] = $row['pH'];
        $turbidity_levels[] = $row['turbidity'];
        $chlorine_levels[] = $row['chlorine'];
        $conductivity_levels[] = $row['conductivity'];
    }
} else {
    echo "No water quality data found.";
}

// Fetch data for the water_classes table
$sql_classes = "SELECT name, ph_min, ph_max, turbidity_max, chlorine_min, chlorine_max, conductivity_max FROM water_classes";
$result_classes = $conn->query($sql_classes);

// Prepare data for the water_classes chart
$class_names = [];
$class_ph_min = [];
$class_ph_max = [];
$class_turbidity_max = [];
$class_chlorine_min = [];
$class_chlorine_max = [];
$class_conductivity_max = [];

if ($result_classes && $result_classes->num_rows > 0) {
    while ($row = $result_classes->fetch_assoc()) {
        $class_names[] = $row['name'];
        $class_ph_min[] = $row['ph_min'];
        $class_ph_max[] = $row['ph_max'];
        $class_turbidity_max[] = $row['turbidity_max'];
        $class_chlorine_min[] = $row['chlorine_min'];
        $class_chlorine_max[] = $row['chlorine_max'];
        $class_conductivity_max[] = $row['conductivity_max'];
    }
} else {
    echo "No water class data found.";
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graphiques de la qualité de l'eau</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Mesures de la qualité de l'eau au fil du temps</h2>
    <canvas id="qualityChart" width="400" height="200"></canvas>
    
    <h2 class="mt-5">Spécifications de la classe d'eau</h2>
    <canvas id="classChart" width="400" height="200"></canvas>
</div>

<script>
// Data for Water Quality Measurements Chart
const labelsQuality = <?php echo json_encode($dates_quality); ?>;
const phLevels = <?php echo json_encode($ph_levels); ?>;
const turbidityLevels = <?php echo json_encode($turbidity_levels); ?>;
const chlorineLevels = <?php echo json_encode($chlorine_levels); ?>;
const conductivityLevels = <?php echo json_encode($conductivity_levels); ?>;

// Create Water Quality Chart
const ctxQuality = document.getElementById('qualityChart').getContext('2d');
const qualityChart = new Chart(ctxQuality, {
    type: 'line',
    data: {
        labels: labelsQuality, // X-axis labels (dates)
        datasets: [
            {
                label: 'Niveaux de pH',
                data: phLevels,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            },
            {
                label: 'Niveaux de turbidité',
                data: turbidityLevels,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Niveaux de chlore',
                data: chlorineLevels,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'Niveaux de conductivité',
                data: conductivityLevels,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Data for Water Class Specifications Chart
const classLabels = <?php echo json_encode($class_names); ?>;
const phMinLevels = <?php echo json_encode($class_ph_min); ?>;
const phMaxLevels = <?php echo json_encode($class_ph_max); ?>;
const turbidityMaxLevels = <?php echo json_encode($class_turbidity_max); ?>;
const chlorineMinLevels = <?php echo json_encode($class_chlorine_min); ?>;
const chlorineMaxLevels = <?php echo json_encode($class_chlorine_max); ?>;
const conductivityMaxLevels = <?php echo json_encode($class_conductivity_max); ?>;

// Create Water Class Chart
const ctxClass = document.getElementById('classChart').getContext('2d');
const classChart = new Chart(ctxClass, {
    type: 'bar',
    data: {
        labels: classLabels, // X-axis labels (water class names)
        datasets: [
            {
                label: 'pH Min',
                data: phMinLevels,
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            },
            {
                label: 'pH Max',
                data: phMaxLevels,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Turbidité Max',
                data: turbidityMaxLevels,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'Chlore Min',
                data: chlorineMinLevels,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            },
            {
                label: 'Chlore Max',
                data: chlorineMaxLevels,
                backgroundColor: 'rgba(201, 203, 207, 0.2)',
                borderColor: 'rgba(201, 203, 207, 1)',
                borderWidth: 1
            },
            {
                label: 'Conductivité Max',
                data: conductivityMaxLevels,
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>
