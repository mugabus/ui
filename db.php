<?php
// db.php

$host = 'localhost';
$dbname = 'lover'; // Replace with your actual database name
$username = 'root'; // Default XAMPP username
$password = ''; // Default XAMPP password is an empty string

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
