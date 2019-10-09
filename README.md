# sim-barang-pakai-habis

## Server Requirements
- PHP >= 7.1.3
- Node >= 12.11.1
- npm >= 6.11.3
- MySQL >= 5.7.27
- composer >= 1.6.5
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Petunjuk Instalasi
- Install php 
- Install mysql
- Install composer
- Install node
- Cek kesiapan (Pastikan php, composer dapat diakses secara global)
```
php -v
mysql --version
composer -v
node -v
npm -v
```
- Install package php
```sh
composer install
```
- Install package js
```sh
npm install
```
- Buat database baru
```sh
mysql -u root -p
create database sim_barang_habis_pakai
```
- Isi configurasi mysql pada file .env
salin data dari file .env.example jika belum ada
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sim_barang_habis_pakai
DB_USERNAME=root
DB_PASSWORD=
```
- Jalankan migrasi database
```sh
php artisan migration:refresh --force
```
- Buat data dummy
```sh
php artisan db:seed
```
- Jalankan server di local
```sh
php artisan serve
```
- Login dengan menggunakan akun berikut:
```
admin@example.com
admin

pengelola@example.com
pengelola

kepala@example.com
kepala
```

### References
- https://laravel.com/docs/5.8/homestead
- https://laravel.com/docs/5.8/deployment

## Dictionary
- OPD: Organisasi Perangkat Daerah
- Volume DPA: Volume Dokumen Pelaksanaan Anggaran
