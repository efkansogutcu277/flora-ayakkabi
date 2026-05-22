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

$sorgu = $baglan->prepare("SELECT * FROM urunler WHERE id = ?");
$sorgu->execute([$urun_id]);
$urun = $sorgu->fetch(PDO::FETCH_ASSOC);

if(!$urun){
    header("Location: urunler.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $urun_adi = $_POST['urun_adi'];
    $aciklama = $_POST['aciklama'];
    $fiyat = (float)$_POST['fiyat'];
    $kategori = $_POST['kategori'];

    $guncelle = $baglan->prepare("UPDATE urunler SET urun_adi=?, aciklama=?, fiyat=?, kategori=? WHERE id=?");
    $guncelle->execute([$urun_adi, $aciklama, $fiyat, $kategori, $urun_id]);

    header("Location: urunler.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ürün Düzenle | Admin Panel</title>

<style>
body{
    font-family:Arial, sans-serif;
    background:#f5f5f5;
    padding:40px 20px;
}

.container{
    max-width:600px;
    margin:0 auto;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,.08);
}

h1{
    margin-bottom:30px;
}

.form-group{
    margin-bottom:20px;
}

label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
}

input, select, textarea{
    width:100%;
    padding:12px 15px;
    border:1px solid #ccc;
    border-radius:8px;
    font-size:14px;
    font-family:Arial, sans-serif;
}

textarea{
    resize:vertical;
    min-height:100px;
}

.buttons{
    display:flex;
    gap:10px;
    margin-top:30px;
}

button, a{
    flex:1;
    padding:12px;
    text-align:center;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
    text-decoration:none;
}

button{
    background:#0066cc;
    color:white;
}

button:hover{
    background:#0052a3;
}

a{
    background:#ccc;
    color:#111;
}

a:hover{
    background:#bbb;
}
</style>
</head>

<body>

<div class="container">
    <h1>Ürün Düzenle</h1>

    <form method="POST">
        <div class="form-group">
            <label>Ürün Adı</label>
            <input type="text" name="urun_adi" value="<?php echo htmlspecialchars($urun['urun_adi']); ?>" required>
        </div>

        <div class="form-group">
            <label>Açıklama</label>
            <textarea name="aciklama"><?php echo htmlspecialchars($urun['aciklama'] ?? ''); ?></textarea>
        </div>

        <div class="form-group">
            <label>Fiyat</label>
            <input type="number" step="0.01" name="fiyat" value="<?php echo $urun['fiyat']; ?>" required>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori" required>
                <option value="Kadın" <?php if($urun['kategori'] == 'Kadın') echo 'selected'; ?>>Kadın</option>
                <option value="Erkek" <?php if($urun['kategori'] == 'Erkek') echo 'selected'; ?>>Erkek</option>
                <option value="Çocuk" <?php if($urun['kategori'] == 'Çocuk') echo 'selected'; ?>>Çocuk</option>
            </select>
        </div>

        <div class="buttons">
            <button type="submit">Kaydet</button>
            <a href="urunler.php">İptal</a>
        </div>
    </form>
</div>

</body>
</html>