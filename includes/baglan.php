<?php
$host = "localhost";
$db = "ayakabi_db";
$user = "root";
$pass = "";

try {
    $baglan = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $baglan->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . htmlspecialchars($e->getMessage()));
}
?>