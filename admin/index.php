<?php
session_start();
include("../includes/baglan.php");

if(!isset($_SESSION['admin_giris'])){
    header("Location: ../admin-giris.php");
    exit;
}

// İstatistikler
$siparisler = $baglan->query("SELECT COUNT(*) as total FROM siparisler")->fetch();
$urunler = $baglan->query("SELECT COUNT(*) as total FROM urunler")->fetch();
$kullanicilar = $baglan->query("SELECT COUNT(*) as total FROM kullanicilar")->fetch();
$toplam_ciro = $baglan->query("SELECT SUM(toplam) as total FROM siparisler")->fetch();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Paneli | Flora Ayakkabı</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial, sans-serif;
    background:#f5f5f5;
}

.admin-container{
    max-width:1400px;
    margin:0 auto;
    padding:40px 20px;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:40px;
}

.header h1{
    margin:0;
}

.logout-btn{
    background:#c60000;
    color:white;
    padding:12px 24px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    text-decoration:none;
    font-weight:bold;
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:20px;
    margin-bottom:40px;
}

.stat-card{
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
}

.stat-card h3{
    color:#666;
    font-size:14px;
    margin-bottom:10px;
}

.stat-card .number{
    font-size:32px;
    font-weight:bold;
    color:#111;
}

.menu-grid{
    display:grid;
    grid-template-columns:repeat(2, 1fr);
    gap:20px;
}

.menu-card{
    background:white;
    padding:30px;
    border-radius:12px;
    text-align:center;
    cursor:pointer;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
    transition:.3s;
    text-decoration:none;
    color:#111;
}

.menu-card:hover{
    transform:translateY(-5px);
    box-shadow:0 8px 20px rgba(0,0,0,.15);
}

.menu-card .icon{
    font-size:48px;
    margin-bottom:15px;
}

.menu-card h2{
    font-size:22px;
    margin-bottom:10px;
}

.menu-card p{
    color:#666;
    font-size:14px;
}

@media(max-width:900px){
    .stats-grid{
        grid-template-columns:repeat(2, 1fr);
    }

    .menu-grid{
        grid-template-columns:1fr;
    }
}
</style>
</head>

<body>

<div class="admin-container">

    <div class="header">
        <h1>Admin Paneli</h1>
        <a href="../admin-cikis.php" class="logout-btn">Çıkış Yap</a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Toplam Sipariş</h3>
            <div class="number"><?php echo $siparisler['total']; ?></div>
        </div>

        <div class="stat-card">
            <h3>Ürün Sayısı</h3>
            <div class="number"><?php echo $urunler['total']; ?></div>
        </div>

        <div class="stat-card">
            <h3>Kayıtlı Üyeler</h3>
            <div class="number"><?php echo $kullanicilar['total']; ?></div>
        </div>

        <div class="stat-card">
            <h3>Toplam Ciro</h3>
            <div class="number"><?php echo number_format($toplam_ciro['total'] ?? 0, 0, ',', '.'); ?> TL</div>
        </div>
    </div>

    <div class="menu-grid">
        <a href="admin-siparis.php" class="menu-card">
            <div class="icon">📦</div>
            <h2>Siparişler</h2>
            <p>Siparişleri yönet ve takip et</p>
        </a>

        <a href="urunler.php" class="menu-card">
            <div class="icon">👟</div>
            <h2>Ürünler</h2>
            <p>Ürünleri ekle, düzenle ve sil</p>
        </a>

        <a href="ayarlar.php" class="menu-card">
            <div class="icon">⚙️</div>
            <h2>Site Ayarları</h2>
            <p>Ödeme ve iletişim bilgilerini güncelle</p>
        </a>

        <a href="../index.php" class="menu-card">
            <div class="icon">🌐</div>
            <h2>Siteyi Görüntüle</h2>
            <p>Web sitesini ziyaret et</p>
        </a>
    </div>

</div>

</body>
</html>