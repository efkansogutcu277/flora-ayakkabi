CREATE DATABASE IF NOT EXISTS ayakabi_db
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE ayakabi_db;

CREATE TABLE IF NOT EXISTS kullanicilar (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  ad VARCHAR(120) NOT NULL,
  email VARCHAR(180) NOT NULL UNIQUE,
  sifre VARCHAR(255) NOT NULL,
  tarih TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS adminler (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  kullanici_adi VARCHAR(80) NOT NULL UNIQUE,
  sifre VARCHAR(255) NOT NULL,
  tarih TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS ayarlar (
  id INT UNSIGNED PRIMARY KEY DEFAULT 1,
  site_adi VARCHAR(120) DEFAULT 'Flora Ayakkabı',
  banka_adi VARCHAR(100),
  iban VARCHAR(50),
  hesap_sahibi VARCHAR(120),
  whatsapp VARCHAR(20),
  instagram VARCHAR(100),
  gmail VARCHAR(180),
  telefon VARCHAR(20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS urunler (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  urun_adi VARCHAR(220) NOT NULL,
  aciklama TEXT NULL,
  fiyat DECIMAL(10,2) NOT NULL DEFAULT 0,
  eski_fiyat DECIMAL(10,2) NULL,
  indirim TINYINT UNSIGNED NOT NULL DEFAULT 0,
  kategori VARCHAR(80) NOT NULL,
  stok INT NOT NULL DEFAULT 0,
  resim VARCHAR(255) NOT NULL,
  resim2 VARCHAR(255) NULL,
  tarih TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_urun_kategori (kategori),
  INDEX idx_urun_fiyat (fiyat)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS urun_bedenleri (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  urun_id INT UNSIGNED NOT NULL,
  beden VARCHAR(20) NOT NULL,
  stok INT NOT NULL DEFAULT 0,
  UNIQUE KEY uniq_urun_beden (urun_id, beden),
  CONSTRAINT fk_beden_urun
    FOREIGN KEY (urun_id) REFERENCES urunler(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS urun_ozellikleri (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  urun_id INT UNSIGNED NOT NULL,
  ozellik_adi VARCHAR(120) NOT NULL,
  ozellik_degeri VARCHAR(180) NOT NULL,
  INDEX idx_ozellik_urun (urun_id),
  CONSTRAINT fk_ozellik_urun
    FOREIGN KEY (urun_id) REFERENCES urunler(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS favoriler (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  kullanici_id INT UNSIGNED NOT NULL,
  urun_id INT UNSIGNED NOT NULL,
  tarih TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_favori (kullanici_id, urun_id),
  CONSTRAINT fk_favori_kullanici
    FOREIGN KEY (kullanici_id) REFERENCES kullanicilar(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_favori_urun
    FOREIGN KEY (urun_id) REFERENCES urunler(id)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS siparisler (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  kullanici_id INT UNSIGNED NULL,
  toplam DECIMAL(10,2) NOT NULL DEFAULT 0,
  odeme_yontemi VARCHAR(80) NOT NULL DEFAULT 'Kapıda Ödeme',
  musteri_ad VARCHAR(120) NULL,
  musteri_soyad VARCHAR(120) NULL,
  musteri_email VARCHAR(180) NULL,
  telefon VARCHAR(40) NULL,
  ulke VARCHAR(80) NULL,
  il VARCHAR(80) NULL,
  ilce VARCHAR(80) NULL,
  adres TEXT NULL,
  posta_kodu VARCHAR(20) NULL,
  durum VARCHAR(40) NOT NULL DEFAULT 'Hazırlanıyor',
  tarih DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  kargo_firma VARCHAR(120) NULL,
  kargo_takip_no VARCHAR(120) NULL,
  INDEX idx_siparis_kullanici (kullanici_id),
  INDEX idx_siparis_durum (durum),
  CONSTRAINT fk_siparis_kullanici
    FOREIGN KEY (kullanici_id) REFERENCES kullanicilar(id)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS siparis_detay (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  siparis_id INT UNSIGNED NOT NULL,
  urun_id INT UNSIGNED NULL,
  beden VARCHAR(20) NULL,
  adet INT NOT NULL DEFAULT 1,
  fiyat DECIMAL(10,2) NOT NULL DEFAULT 0,
  INDEX idx_detay_siparis (siparis_id),
  CONSTRAINT fk_detay_siparis
    FOREIGN KEY (siparis_id) REFERENCES siparisler(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_detay_urun
    FOREIGN KEY (urun_id) REFERENCES urunler(id)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO ayarlar (id) VALUES (1) ON DUPLICATE KEY UPDATE id=1;

INSERT INTO adminler (kullanici_adi, sifre)
VALUES ('admin', '$2y$10$.ESzoGHtXlBRg1bRlZwE..0iVksTXVT/KM5BhNVbvHSNCsJELVv86')
ON DUPLICATE KEY UPDATE kullanici_adi = VALUES(kullanici_adi);