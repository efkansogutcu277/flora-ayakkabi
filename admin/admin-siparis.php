<?php
session_start();
include("../includes/baglan.php");

if(!isset($_SESSION['admin_giris'])){
    header("Location: ../admin-giris.php");
    exit;
}

$sorgu = $baglan->query("
    SELECT * FROM siparisler 
    ORDER BY tarih DESC
");
$siparisler = $sorgu->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Siparişler | Admin Panel</title>

<style>
body{
    margin:0;
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
    font-size:14px;
}

td{
    padding:15px;
    border-bottom:1px solid #eee;
    font-size:14px;
}

tr:hover{
    background:#f9f9f9;
}

.durum{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
    text-align:center;
}

.hazirlaniyor{
    background:#fff4dc;
    color:#a66a00;
}

.kargoda{
    background:#e7f0ff;
    color:#0055c8;
}

.teslim{
    background:#e8f8ee;
    color:#16833a;
}

.iptal{
    background:#ffe7e7;
    color:#c60000;
}

.detay-btn{
    background:#0066cc;
    color:white;
    padding:8px 16px;
    text-decoration:none;
    border-radius:6px;
    font-size:13px;
}

.dugum-cell{
    white-space:nowrap;
}

@media(max-width:900px){
    table{
        font-size:12px;
    }
    
    th, td{
        padding:10px;
    }
}
</style>
</head>

<body>

<div class="admin-container">

    <div class="header">
        <h1>Sipariş Yönetimi</h1>
        <a href="index.php" class="back-btn">Panele Dön</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Sipariş No</th>
                <th>Müşteri</th>
                <th>Tarih</th>
                <th>Tutar</th>
                <th>Durum</th>
                <th>Ödeme</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($siparisler as $siparis){ 
                $durumClass = "hazirlaniyor";
                
                if($siparis['durum'] == "Kargoda"){
                    $durumClass = "kargoda";
                } elseif($siparis['durum'] == "Teslim Edildi"){
                    $durumClass = "teslim";
                } elseif($siparis['durum'] == "İptal Edildi"){
                    $durumClass = "iptal";
                }
            ?>
            <tr>
                <td class="dugum-cell">#<?php echo $siparis['id']; ?></td>
                <td><?php echo htmlspecialchars($siparis['musteri_ad'] . ' ' . ($siparis['musteri_soyad'] ?? '')); ?></td>
                <td><?php echo date('d.m.Y H:i', strtotime($siparis['tarih'])); ?></td>
                <td><strong><?php echo number_format($siparis['toplam'], 2, ',', '.'); ?> TL</strong></td>
                <td>
                    <div class="durum <?php echo $durumClass; ?>">
                        <?php echo htmlspecialchars($siparis['durum']); ?>
                    </div>
                </td>
                <td><?php echo htmlspecialchars($siparis['odeme_yontemi']); ?></td>
                <td>
                    <a href="siparis-detay.php?id=<?php echo $siparis['id']; ?>" class="detay-btn">
                        Detay
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</div>

</body>
</html>
