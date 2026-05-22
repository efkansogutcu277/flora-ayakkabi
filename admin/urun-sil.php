<?php
session_start();
include("../includes/baglan.php");

if(!isset($_SESSION['admin_giris'])){
    header("Location: ../admin-giris.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: urunler.php");
    exit;
}

$urun_id = (int)$_GET['id'];

$sil = $baglan->prepare("DELETE FROM urunler WHERE id = ?");
$sil->execute([$urun_id]);

header("Location: urunler.php");
exit;
?>