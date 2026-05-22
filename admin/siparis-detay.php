<?php
session_start();
include("../includes/baglan.php");

if(!isset($_SESSION['admin_giris'])){
    header("Location: ../admin-giris.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: admin-siparis.php");
    exit;
}

$siparis_id = (int)$_GET['id'];

$siparisKontrol = $baglan->prepare("SELECT * FROM siparisler WHERE id = ?");
$siparisKontrol->execute([$siparis_id]);
$siparis = $siparisKontrol->fetch(PDO::FETCH_ASSOC);

if(!$siparis){
    header("Location: admin-siparis.php");
    exit;
}

$sorgu = $baglan->prepare("
    SELECT sd.*, urunler.urun_adi, urunler.resim 
    FROM siparis_detay sd
    LEFT JOIN urunler ON sd.urun_id = urunler.id
    WHERE sd.siparis_id=?
");
$sorgu->execute([$siparis_id]);
$urunler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['durum'])){
    $durum = $_POST['durum'];
    
    $guncelle = $baglan->prepare("UPDATE siparisler SET durum=? WHERE id=?");
    $guncelle->execute([$durum, $siparis_id]);
    
    $siparis['durum'] = $durum;
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kargo_firma'])){
    $kargo_firma = $_POST['kargo_firma'];
    $kargo_takip_no = $_POST['kargo_takip_no'];
    
    $guncelle = $baglan->prepare("UPDATE siparisler SET kargo_firma=?, kargo_takip_no=? WHERE id=?");
    $guncelle->execute([$kargo_firma, $kargo_takip_no, $siparis_id]);
    
    $siparis['kargo_firma'] = $kargo_firma;
    $siparis['kargo_takip_no'] = $kargo_takip_no;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Sipariş Detayı | Admin Panel</title>

<style>
body{
    margin:0;
    font-family:Arial, sans-serif;
    background:#f5f5f5;
}

.admin-container{
    max-width:900px;
    margin:0 auto;
    padding:40px 20px;
}

.header{
    margin-bottom:30px;
}

.header a{
    background:#111;
    color:white;
    padding:10px 20px;
    text-decoration:none;
    border-radius:8px;
}

.card{
    background:white;
    border-radius:12px;
    padding:25px;
    margin-bottom:20px;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
}

.card h2{
    margin-top:0;
    margin-bottom:20px;
    font-size:20px;
}

.bilgi-satir{
    display:grid;
    grid-template-columns:200px 1fr;
    margin-bottom:15px;
    gap:20px;
}

.bilgi-satir strong{
    color:#666;
}

.bilgi-satir span{
    color:#111;
}

.durum-secim{
    display:flex;
    gap:10px;
    margin-top:15px;
}

.durum-secim select{
    padding:10px 15px;
    border:1px solid #ccc;
    border-radius:6px;
    font-size:14px;
}

.durum-secim button{
    padding:10px 20px;
    background:#111;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-weight:bold;
}

.urun-liste{
    border-top:1px solid #eee;
    padding-top:20px;
}

.urun-item{
    display:grid;
    grid-template-columns:80px 1fr auto;
    gap:20px;
    align-items:center;
    margin-bottom:20px;
    padding-bottom:20px;
    border-bottom:1px solid #eee;
}

.urun-item img{
    width:80px;
    height:100px;
    object-fit:cover;
    border-radius:6px;
}

.urun-info h4{
    margin:0 0 5px;
}

.urun-info p{
    margin:5px 0;
    color:#666;
    font-size:13px;
}

.urun-fiyat{
    text-align:right;
    font-weight:bold;
}

.form-group{
    margin-bottom:15px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
}

.form-group input{
    width:100%;
    padding:10px 15px;
    border:1px solid #ccc;
    border-radius:6px;
    font-size:14px;
    box-sizing:border-box;
}

.form-group button{
    background:#0066cc;
    color:white;
    padding:10px 20px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-weight:bold;
}
</style>
</head>

<body>

<div class="admin-container">

    <div class="header">
        <a href="admin-siparis.php">← Siparişlere Dön</a>
        <h1>Sipariş #<?php echo $siparis_id; ?></h1>
    </div>

    <div class="card">
        <h2>Müşteri Bilgileri</h2>
        
        <div class="bilgi-satir">
            <strong>Ad Soyad:</strong>
            <span><?php echo htmlspecialchars($siparis['musteri_ad'] . ' ' . ($siparis['musteri_soyad'] ?? '')); ?></span>
        </div>

        <div class="bilgi-satir">
            <strong>E-posta:</strong>
            <span><?php echo htmlspecialchars($siparis['musteri_email'] ?? 'Belirtilmedi'); ?></span>
        </div>

        <div class="bilgi-satir">
            <strong>Telefon:</strong>
            <span><?php echo htmlspecialchars($siparis['telefon'] ?? 'Belirtilmedi'); ?></span>
        </div>

        <div class="bilgi-satir">
            <strong>Adres:</strong>
            <span><?php echo htmlspecialchars($siparis['adres'] ?? 'Belirtilmedi'); ?></span>
        </div>

        <div class="bilgi-satir">
            <strong>İl/İlçe:</strong>
            <span><?php echo htmlspecialchars(($siparis['ilce'] ?? '') . ' / ' . ($siparis['il'] ?? '')); ?></span>
        </div>
    </div>

    <div class="card">
        <h2>Sipariş Durumu</h2>

        <div class="bilgi-satir">
            <strong>Mevcut Durum:</strong>
            <span><?php echo htmlspecialchars($siparis['durum']); ?></span>
        </div>

        <form method="POST">
            <div class="durum-secim">
                <select name="durum" required>
                    <option value="Hazırlanıyor" <?php if($siparis['durum'] == 'Hazırlanıyor') echo 'selected'; ?>>Hazırlanıyor</option>
                    <option value="Kargoda" <?php if($siparis['durum'] == 'Kargoda') echo 'selected'; ?>>Kargoda</option>
                    <option value="Teslim Edildi" <?php if($siparis['durum'] == 'Teslim Edildi') echo 'selected'; ?>>Teslim Edildi</option>
                    <option value="İptal Edildi" <?php if($siparis['durum'] == 'İptal Edildi') echo 'selected'; ?>>İptal Edildi</option>
                </select>
                <button type="submit">Güncelle</button>
            </div>
        </form>
    </div>

    <div class="card">
        <h2>Kargo Bilgileri</h2>

        <form method="POST">
            <div class="form-group">
                <label>Kargo Firması:</label>
                <input type="text" name="kargo_firma" value="<?php echo htmlspecialchars($siparis['kargo_firma'] ?? ''); ?>" placeholder="Örn: Aras Kargo, MNG, PTT...">
            </div>

            <div class="form-group">
                <label>Takip Numarası:</label>
                <input type="text" name="kargo_takip_no" value="<?php echo htmlspecialchars($siparis['kargo_takip_no'] ?? ''); ?>" placeholder="Kargo takip numarası">
            </div>

            <button type="submit">Kargo Bilgilerini Kaydet</button>
        </form>
    </div>

    <div class="card">
        <h2>Ürünler</h2>

        <div class="urun-liste">
            <?php foreach($urunler as $urun){ ?>
                <div class="urun-item">
                    <?php if($urun['resim']){ ?>
                        <img src="../gorseller/<?php echo htmlspecialchars($urun['resim']); ?>" alt="">
                    <?php } else { ?>
                        <div style="width:80px;height:100px;background:#eee;border-radius:6px;"></div>
                    <?php } ?>

                    <div class="urun-info">
                        <h4><?php echo htmlspecialchars($urun['urun_adi'] ?? 'Bilinmeyen Ürün'); ?></h4>
                        <p>Beden: <?php echo htmlspecialchars($urun['beden'] ?? 'Standart'); ?></p>
                        <p>Adet: <?php echo $urun['adet']; ?></p>
                    </div>

                    <div class="urun-fiyat">
                        <?php echo number_format($urun['fiyat'] * $urun['adet'], 2, ',', '.'); ?> TL
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="card">
        <h2>Ödeme Özeti</h2>

        <div class="bilgi-satir">
            <strong>Ödeme Yöntemi:</strong>
            <span><?php echo htmlspecialchars($siparis['odeme_yontemi']); ?></span>
        </div>

        <div class="bilgi-satir">
            <strong>Toplam Tutar:</strong>
            <span style="font-size:18px;font-weight:bold;color:#0066cc;">
                <?php echo number_format($siparis['toplam'], 2, ',', '.'); ?> TL
            </span>
        </div>

        <div class="bilgi-satir">
            <strong>Sipariş Tarihi:</strong>
            <span><?php echo date('d.m.Y H:i', strtotime($siparis['tarih'])); ?></span>
        </div>
    </div>

</div>

</body>
</html>
