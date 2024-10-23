<?php
session_start();

// Check if the user is already logged in, redirect to dashboard
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: dashboard.php');
    exit;
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Hardcoded credentials
    $username = 'admin';
    $password = 'admin123';

    // Check the credentials
    if ($_POST['username'] === $username && $_POST['password'] === $password) {
        // Store session variable and redirect to dashboard
        $_SESSION['loggedin'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $message = 'Invalid username or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Système de qualité de l'eau</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            width: 400px;
            padding: 40px;
            background-color: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .logo-container {
            margin-bottom: 20px;
        }

        .logo {
            width: 120px;
            height: auto;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            width: 100%;
        }

        label {
            display: block;
            text-align: left;
            font-size: 14px;
            margin-bottom: 8px;
            color: #333333;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #CCCCCC;
            border-radius: 8px;
            box-sizing: border-box;
            background-color: #F9F9F9;
            font-size: 14px;
            color: #333333;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #007BFF;
            outline: none;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #A52A2A; /* Brown color */
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #6D4C41; /* Darker brown for hover effect */
        }

        .error {
            color: red;
            margin-top: 15px;
            font-size: 14px;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .login-container {
                width: 90%;
                padding: 20px;
            }

            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="daniel.png" alt="Water Quality System" class="logo">
        </div>
        <h2>Se connecter</h2>
        <form method="post">
            <label for="username">Nom d'utilisateure:</label>
            <input type="text" name="username" required>

            <label for="password">Mot de passe:</label>
            <input type="password" name="password" required>

            <input type="submit" value="Se connecter">
        </form>
        <?php if ($message) echo "<p class='error'>$message</p>"; ?>
    </div>
</body>
</html>
