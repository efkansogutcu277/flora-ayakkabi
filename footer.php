<?php include("iletisim-bilgileri.php"); ?>

<footer style="background:#111;color:white;padding:60px 40px;">
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(250px, 1fr));gap:40px;max-width:1400px;margin:0 auto;">
        <div>
            <h3>Flora Ayakkabı</h3>
            <p style="color:#ccc;margin-top:10px;">Şık, rahat ve kaliteli ayakkabı modelleri.</p>
        </div>

        <div>
            <h4>Hızlı Linkler</h4>
            <a href="kadin.php" style="display:block;color:#ccc;text-decoration:none;margin-top:10px;">Kadın</a>
            <a href="erkek.php" style="display:block;color:#ccc;text-decoration:none;margin-top:8px;">Erkek</a>
            <a href="cocuk.php" style="display:block;color:#ccc;text-decoration:none;margin-top:8px;">Çocuk</a>
            <a href="indirim.php" style="display:block;color:#ccc;text-decoration:none;margin-top:8px;">İndirim</a>
        </div>

        <div>
            <h4>İletişim</h4>
            <?php if(!empty($ayarlar['whatsapp'])){ ?>
                <a href="<?php echo $whatsapp_url; ?>" target="_blank" style="display:flex;align-items:center;gap:10px;color:#ccc;text-decoration:none;margin-top:10px;">
                    <span style="font-size:20px;">💬</span> WhatsApp
                </a>
            <?php } ?>
            
            <?php if(!empty($ayarlar['instagram'])){ ?>
                <a href="<?php echo $instagram_url; ?>" target="_blank" style="display:flex;align-items:center;gap:10px;color:#ccc;text-decoration:none;margin-top:8px;">
                    <span style="font-size:20px;">📷</span> Instagram
                </a>
            <?php } ?>
            
            <?php if(!empty($ayarlar['gmail'])){ ?>
                <a href="<?php echo $gmail_url; ?>" style="display:flex;align-items:center;gap:10px;color:#ccc;text-decoration:none;margin-top:8px;">
                    <span style="font-size:20px;">✉️</span> Gmail
                </a>
            <?php } ?>
        </div>

        <div>
            <h4>Ödeme Bilgileri</h4>
            <?php if(!empty($ayarlar['banka_adi'])){ ?>
                <p style="color:#ccc;margin-top:10px;"><strong>Banka:</strong> <?php echo htmlspecialchars($ayarlar['banka_adi']); ?></p>
            <?php } ?>
            <?php if(!empty($ayarlar['hesap_sahibi'])){ ?>
                <p style="color:#ccc;margin-top:8px;"><strong>Hesap Sahibi:</strong> <?php echo htmlspecialchars($ayarlar['hesap_sahibi']); ?></p>
            <?php } ?>
            <?php if(!empty($ayarlar['iban'])){ ?>
                <p style="color:#ccc;margin-top:8px;"><strong>IBAN:</strong> <?php echo htmlspecialchars($ayarlar['iban']); ?></p>
            <?php } ?>
        </div>
    </div>

    <hr style="border:none;border-top:1px solid #333;margin-top:40px;padding-top:40px;">

    <div style="text-align:center;color:#999;font-size:14px;">
        &copy; 2026 Flora Ayakkabı. Tüm hakları saklıdır.
    </div>
</footer>