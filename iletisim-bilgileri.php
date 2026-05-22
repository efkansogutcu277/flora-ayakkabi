<?php
include("includes/baglan.php");

// Ayarları al
$sorgu = $baglan->query("SELECT * FROM ayarlar WHERE id = 1");
$ayarlar = $sorgu->fetch(PDO::FETCH_ASSOC);

if(!$ayarlar){
    $ayarlar = [];
}

// URL'ler oluştur
$whatsapp_url = !empty($ayarlar['whatsapp']) ? "https://wa.me/" . $ayarlar['whatsapp'] : "#";
$instagram_url = !empty($ayarlar['instagram']) ? "https://instagram.com/" . str_replace('@', '', $ayarlar['instagram']) : "#";
$gmail_url = !empty($ayarlar['gmail']) ? "mailto:" . $ayarlar['gmail'] : "#";
$telefon_url = !empty($ayarlar['telefon']) ? "tel:" . str_replace(' ', '', $ayarlar['telefon']) : "#";
?>