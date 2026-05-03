# SeeAuto — Araç Bakım ve Takip Sistemi
## PHP + MS SQL Server Kurulum Kılavuzu

---

## 📁 Dosya Yapısı

```
seauto/
├── index.php     ← Ana sayfa (tüm UI burada)
├── db.php        ← Veritabanı bağlantısı
├── auth.php      ← Giriş/çıkış işlemleri
├── api.php       ← Tüm CRUD işlemleri
└── README.md     ← Bu dosya
```

---

## ⚙️ Gereksinimler

1. **PHP 7.4+** (önerilen: PHP 8.x)
2. **Microsoft SQL Server PHP Driver** (sqlsrv)
3. **XAMPP / WAMP / IIS** veya herhangi bir PHP web sunucusu
4. **MS SQL Server** (LocalDB veya Express olabilir)

---

## 🔧 Kurulum Adımları

### 1. PHP sqlsrv Sürücüsünü Yükle
```
https://docs.microsoft.com/en-us/sql/connect/php/download-drivers-php-sql-server
```
- `php_sqlsrv_xx_ts.dll` ve `php_pdo_sqlsrv_xx_ts.dll` dosyalarını PHP `ext/` klasörüne kopyalayın
- `php.ini` dosyasına ekleyin:
```ini
extension=php_sqlsrv_83_ts_x64.dll
extension=php_pdo_sqlsrv_83_ts_x64.dll
```

### 2. Veritabanını Oluştur
SQL Server Management Studio (SSMS) üzerinde `vtys_proje_SON1.sql` dosyasını çalıştırın.

### 3. Projeyi Web Klasörüne Koy
- XAMPP kullanıyorsanız: `C:\xampp\htdocs\seauto\`
- WAMP kullanıyorsanız: `C:\wamp64\www\seauto\`

### 4. Bağlantı Ayarları (db.php)
```php
$serverName = ".";                          // Sunucu: "." = localhost
$database   = "AracBakimVeTakipSistemi";   // Veritabanı adı
```
Farklı bir sunucu veya instance kullanıyorsanız:
```php
$serverName = ".\SQLEXPRESS";  // SQL Express için
$serverName = "localhost";     // veya bu şekilde
```

### 5. Tarayıcıda Aç
```
http://localhost/seauto/
```

---

## 🔐 Giriş Bilgileri

### Admin
- **Kullanıcı adı:** `admin`
- **Şifre:** `admin123`

### Müşteri
- **E-posta:** Veritabanındaki `Mail` alanı
- **Şifre:** Veritabanındaki `Telefon` alanı
- Örnek: `ahmetdemr@gmail.com` / `0546 744 65 73`

---

## 📋 Özellikler

### Admin Paneli
- ✅ Dashboard (istatistikler + son bakımlar)
- ✅ Müşteri yönetimi (listeleme, ekleme, silme)
- ✅ Araç yönetimi (listeleme, ekleme, silme)
- ✅ Bakım kayıtları yönetimi (listeleme, ekleme, silme)
- ✅ Personel yönetimi
- ✅ Hizmetler yönetimi

### Müşteri Paneli
- ✅ Kendi araçlarını görüntüleme ve ekleme
- ✅ Bakım geçmişini görüntüleme
- ✅ Randevu talebi gönderme

---

## 🗄️ Veritabanı Tabloları

| Tablo | Açıklama |
|-------|----------|
| `Musteriler` | Müşteri kayıtları |
| `Araclar` | Araç kayıtları |
| `BakimKayitlari` | Bakım geçmişi |
| `Personel` | Servis çalışanları |
| `Hizmetler` | Sunulan hizmetler ve fiyatlar |

---

## 🛠️ Sorun Giderme

**"sqlsrv_connect() fonksiyonu bulunamıyor"**
→ PHP sqlsrv sürücüsü yüklenmemiş. Yukarıdaki adımları takip edin.

**"Veritabanı bağlantısı başarısız"**
→ `db.php` içindeki `$serverName` değerini kontrol edin.
→ SQL Server servisinin çalıştığından emin olun.

**"Windows Authentication" sorunu**
→ `db.php` içine SQL Authentication ekleyin:
```php
$connectionInfo = [
    "Database" => $database,
    "UID"      => "sa",
    "PWD"      => "şifreniz",
    "CharacterSet" => "UTF-8",
    "TrustServerCertificate" => true
];
```
