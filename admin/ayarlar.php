<?php
session_start();
include("../includes/baglan.php");

if(!isset($_SESSION['admin_giris'])){
    header("Location: ../admin-giris.php");
    exit;
}

// Mevcut ayarları al
$sorgu = $baglan->query("SELECT * FROM ayarlar WHERE id = 1");
$ayarlar = $sorgu->fetch(PDO::FETCH_ASSOC);

if(!$ayarlar){
    // İlk kayıt oluştur
    $baglan->exec("INSERT INTO ayarlar (id) VALUES (1)");
    $ayarlar = [
        'id' => 1,
        'site_adi' => 'Flora Ayakkabı',
        'banka_adi' => '',
        'iban' => '',
        'hesap_sahibi' => '',
        'whatsapp' => '',
        'instagram' => '',
        'gmail' => '',
        'telefon' => ''
    ];
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $site_adi = $_POST['site_adi'] ?? '';
    $banka_adi = $_POST['banka_adi'] ?? '';
    $iban = $_POST['iban'] ?? '';
    $hesap_sahibi = $_POST['hesap_sahibi'] ?? '';
    $whatsapp = $_POST['whatsapp'] ?? '';
    $instagram = $_POST['instagram'] ?? '';
    $gmail = $_POST['gmail'] ?? '';
    $telefon = $_POST['telefon'] ?? '';

    $guncelle = $baglan->prepare("
        UPDATE ayarlar 
        SET site_adi=?, banka_adi=?, iban=?, hesap_sahibi=?, 
            whatsapp=?, instagram=?, gmail=?, telefon=?
        WHERE id=1
    ");
    $guncelle->execute([
        $site_adi, $banka_adi, $iban, $hesap_sahibi,
        $whatsapp, $instagram, $gmail, $telefon
    ]);

    $ayarlar = [
        'id' => 1,
        'site_adi' => $site_adi,
        'banka_adi' => $banka_adi,
        'iban' => $iban,
        'hesap_sahibi' => $hesap_sahibi,
        'whatsapp' => $whatsapp,
        'instagram' => $instagram,
        'gmail' => $gmail,
        'telefon' => $telefon
    ];
    
    $basari = "Ayarlar başarıyla kaydedildi!";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ayarlar | Admin Panel</title>

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
    max-width:900px;
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
    font-size:32px;
}

.back-btn{
    background:#111;
    color:white;
    padding:12px 24px;
    text-decoration:none;
    border-radius:8px;
    font-weight:bold;
}

.basari-mesaj{
    background:#e8f8ee;
    border:1px solid #4caf50;
    color:#16833a;
    padding:15px 20px;
    border-radius:8px;
    margin-bottom:20px;
}

.card{
    background:white;
    border-radius:12px;
    padding:30px;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
}

.section{
    margin-bottom:40px;
}

.section h2{
    font-size:20px;
    margin-bottom:20px;
    color:#111;
    border-bottom:2px solid #111;
    padding-bottom:10px;
}

.form-group{
    margin-bottom:20px;
}

label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
    color:#333;
}

input[type="text"],
input[type="email"],
input[type="tel"],
textarea{
    width:100%;
    padding:12px 15px;
    border:1px solid #ccc;
    border-radius:8px;
    font-size:14px;
    font-family:Arial, sans-serif;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="tel"]:focus,
textarea:focus{
    outline:none;
    border-color:#0066cc;
    box-shadow:0 0 0 3px rgba(0,102,204,.1);
}

textarea{
    resize:vertical;
    min-height:100px;
}

.form-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.button-group{
    display:flex;
    gap:10px;
    margin-top:30px;
}

.submit-btn{
    background:#0066cc;
    color:white;
    padding:14px 28px;
    border:none;
    border-radius:8px;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:.2s;
}

.submit-btn:hover{
    background:#0052a3;
}

.info-box{
    background:#f0f7ff;
    border-left:4px solid #0066cc;
    padding:15px 20px;
    margin-top:20px;
    border-radius:8px;
    font-size:13px;
    color:#0055c8;
}

@media(max-width:768px){
    .form-row{
        grid-template-columns:1fr;
    }

    .header{
        flex-direction:column;
        gap:15px;
    }

    .admin-container{
        padding:20px 15px;
    }

    .card{
        padding:20px;
    }
}
</style>
</head>

<body>

<div class="admin-container">

    <div class="header">
        <h1>Site Ayarları</h1>
        <a href="index.php" class="back-btn">← Panele Dön</a>
    </div>

    <?php if(isset($basari)){ ?>
        <div class="basari-mesaj">
            ✓ <?php echo $basari; ?>
        </div>
    <?php } ?>

    <div class="card">

        <form method="POST">

            <!-- Site Bilgileri -->
            <div class="section">
                <h2>📱 İletişim Bilgileri</h2>

                <div class="form-group">
                    <label for="whatsapp">WhatsApp Numarası</label>
                    <input 
                        type="tel" 
                        id="whatsapp" 
                        name="whatsapp" 
                        placeholder="905353757181"
                        value="<?php echo htmlspecialchars($ayarlar['whatsapp'] ?? ''); ?>">
                    <div class="info-box">
                        Örnek: 90 ile başlayan numarayı boşluksuz yazın
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="instagram">Instagram Hesabı</label>
                        <input 
                            type="text" 
                            id="instagram" 
                            name="instagram" 
                            placeholder="@floraayakkabi"
                            value="<?php echo htmlspecialchars($ayarlar['instagram'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="gmail">Gmail Adresi</label>
                        <input 
                            type="email" 
                            id="gmail" 
                            name="gmail" 
                            placeholder="bilgi@floraayakkabi.com"
                            value="<?php echo htmlspecialchars($ayarlar['gmail'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="telefon">Telefon Numarası</label>
                    <input 
                        type="tel" 
                        id="telefon" 
                        name="telefon" 
                        placeholder="+90 535 375 7181"
                        value="<?php echo htmlspecialchars($ayarlar['telefon'] ?? ''); ?>">
                </div>
            </div>

            <!-- Ödeme Bilgileri -->
            <div class="section">
                <h2>🏦 Ödeme Bilgileri</h2>

                <div class="form-group">
                    <label for="banka_adi">Banka Adı</label>
                    <input 
                        type="text" 
                        id="banka_adi" 
                        name="banka_adi" 
                        placeholder="Örn: Ziraat Bankası"
                        value="<?php echo htmlspecialchars($ayarlar['banka_adi'] ?? ''); ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="hesap_sahibi">Hesap Sahibinin Adı</label>
                        <input 
                            type="text" 
                            id="hesap_sahibi" 
                            name="hesap_sahibi" 
                            placeholder="Efkan SOĞUTCU"
                            value="<?php echo htmlspecialchars($ayarlar['hesap_sahibi'] ?? ''); ?>">
                    </div>

                    <div class="form-group">
                        <label for="iban">IBAN (Uluslararası Hesap Numarası)</label>
                        <input 
                            type="text" 
                            id="iban" 
                            name="iban" 
                            placeholder="TR12 0000 1234 5678 9012 3456"
                            value="<?php echo htmlspecialchars($ayarlar['iban'] ?? ''); ?>">
                    </div>
                </div>

                <div class="info-box">
                    IBAN bilgileri müşterilerinize gösterilecektir. Lütfen doğru bilgiler giriniz.
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="submit-btn">
                    💾 Ayarları Kaydet
                </button>
            </div>

        </form>

    </div>

</div>

</body>
</html>
