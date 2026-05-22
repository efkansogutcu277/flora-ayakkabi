<?php
session_start();
include("../includes/baglan.php");

if(!isset($_SESSION['admin_giris'])){
    header("Location: ../admin-giris.php");
    exit;
}

$sorgu = $baglan->query("SELECT * FROM urunler ORDER BY id DESC");
$urunler = $sorgu->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Ürünler | Admin Panel</title>

<style>
body{
    margin:0;
    font-family:Arial, sans-serif;
    background:#f5f5f5;
}

.admin-container{
    max-width:1200px;
    margin:0 auto;
    padding:40px 20px;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.header h1{
    margin:0;
}

.back-btn{
    background:#111;
    color:white;
    padding:10px 20px;
    text-decoration:none;
    border-radius:8px;
}

table{
    width:100%;
    background:white;
    border-collapse:collapse;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
}

th{
    background:#111;
    color:white;
    padding:15px;
    text-align:left;
    font-weight:bold;
}

td{
    padding:15px;
    border-bottom:1px solid #eee;
}

tr:hover{
    background:#f9f9f9;
}

.aksiyon{
    display:flex;
    gap:10px;
}

.edit-btn{
    background:#0066cc;
    color:white;
    padding:8px 16px;
    text-decoration:none;
    border-radius:6px;
    font-size:13px;
}

.sil-btn{
    background:#c60000;
    color:white;
    padding:8px 16px;
    border:none;
    border-radius:6px;
    font-size:13px;
    cursor:pointer;
}

.resim-thumbnail{
    width:50px;
    height:50px;
    object-fit:cover;
    border-radius:6px;
}

.fiyat{
    font-weight:bold;
    color:#111;
}

.stok{
    text-align:center;
    padding:4px 8px;
    border-radius:4px;
    background:#f0f0f0;
}
</style>
</head>

<body>

<div class="admin-container">

    <div class="header">
        <h1>Ürün Yönetimi</h1>
        <a href="index.php" class="back-btn">Panele Dön</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Resim</th>
                <th>Ürün Adı</th>
                <th>Kategori</th>
                <th>Fiyat</th>
                <th>Stok</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($urunler as $urun){ ?>
            <tr>
                <td>
                    <img src="../gorseller/<?php echo htmlspecialchars($urun['resim']); ?>" 
                         class="resim-thumbnail" alt="">
                </td>
                <td><?php echo htmlspecialchars($urun['urun_adi']); ?></td>
                <td><?php echo htmlspecialchars($urun['kategori']); ?></td>
                <td class="fiyat"><?php echo number_format($urun['fiyat'], 2, ',', '.'); ?> TL</td>
                <td class="stok"><?php echo $urun['stok']; ?></td>
                <td class="aksiyon">
                    <a href="urun-duzenle.php?id=<?php echo $urun['id']; ?>" class="edit-btn">
                        Düzenle
                    </a>
                    <a href="urun-sil.php?id=<?php echo $urun['id']; ?>" 
                       class="sil-btn" 
                       onclick="return confirm('Silmek istediğinize emin misiniz?')">
                        Sil
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</div>

</body>
</html>
