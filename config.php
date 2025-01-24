<?php
$host = 'localhost';
$dbname = 'intership_monitoring'; // Nama database
$user = 'root'; // Username database
$pass = ''; // Password database

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
