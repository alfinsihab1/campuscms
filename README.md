<p align="center">
  <a href="https://packagist.org/packages/ajifatur/faturcms"><img src="https://poser.pugx.org/ajifatur/faturcms/d/total.svg" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/ajifatur/faturcms"><img src="https://poser.pugx.org/ajifatur/faturcms/v/stable.svg" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/ajifatur/faturcms"><img src="https://poser.pugx.org/ajifatur/faturcms/license.svg" alt="License"></a>
</p>


## Perkenalan

FaturCMS adalah **Content Management System (CMS)** yang menyediakan fitur referral. Referral yaitu sistem dimana kita mengajak orang lain untuk mendaftar menjadi member, dan kita mendapatkan keuntungan darinya. FaturCMS juga dilengkapi produk-produk digital seperti e-book, video, tools, dan lain sebagainya yang bisa dipromosikan beserta dengan referral tadi. FaturCMS  dibangun di atas framework [Laravel](https://laravel.com).

## Persyaratan
- PHP >= 7.2
- DBMS MySQL
- Laravel >= 7.0

## Instalasi

### Instal dari Composer:

Untuk menginstal FaturCMS, jalankan perintah composer di bawah ini dan kamu akan mendapatkan versi terbaru:

```sh
composer require ajifatur/faturcms
```

### Instal Konfigurasi:

Untuk menginstal konfigurasi FaturCMS, jalankan perintah composer di bawah ini:

```sh
php artisan faturcms:install
```

### Route Home:

Tambahkan nama route __site.home__ pada halaman *home* Anda. Contohnya seperti ini:

```php
Route::get('/', function(){
  return view('welcome');
})->name('site.home');
```

### File .env:

Ganti konfigurasi *database* pada file __.env___ Anda:

```sh
DB_HOST="your_database_host"
DB_PORT="your_database_port"
DB_DATABASE="your_database_name"
DB_USERNAME="your_database_username"
DB_PASSWORD="your_database_password"
```

## Update

Untuk mengupdate konfigurasi FaturCMS, jalankan perintah composer di bawah ini:

```sh
php artisan faturcms:update
```

## Mitra Kami
- [PersonalityTalk](https://psikologanda.com)
- [Kompetensiku](https://kompetensiku.id)

## Lisensi
FaturCMS bersifat open source dengan lisensi [ MIT](https://opensource.org/licenses/MIT).
