
# Inventory Proyek

Ini adalah repositori dari project mata kuliah Web Programming II yang berisi file-file penting untuk website Inventory Proyek. Project ini memanfaatkan beberapa teknologi untuk pengembangan web seperti PHP, Bootstrap, HTML, CSS, dan JavaScript.


## Authors

- [@hafizarul](https://www.github.com/HafizArul) : 24.02.1088
- [@rifkyokta](https://github.com/Rifkyyyezz) : 24.02.1092
- [@miqbalasd](https://github.com/miqbalasd) : 24.02.1080
- Azriel Ibrahim : 24.02.1096
## Pre-requisite

Sebelum meng-clone repo ini ada yang perlu diperlukan terlebih dahulu, yaitu :
- XAMPP : Untuk menjalankan web server Apache dan phpmyadmin
- Git Bash : Untuk clone repo ini ke komputer lokal

## Konfigurasi Database
Jika sudah instal software di atas, perlu konfigurasi database sebagai berikut :
1. Buka XAMPP Control Panel
2. Aktifkan layanan MySQL lalu tekan tombol Admin
3. Klik tab SQL dan ketik kode berikut untuk membuat database bernama `proyek_inventory`
```SQL
CREATE DATABASE proyek_inventory
```
4. Klik Go, lalu pilih database yang telah dibuat
5. Klik Import, pilih file SQL dari repo ini bernama `proyek_inventory.sql`
6. Klik Import

## Menjalankan Web Inventory Proyek
1. Buka `localhost/inventory_proyek/dashboard.php` yang akan mengarahkan ke halaman login jika belum login
2. Login dengan
- username : admin
- password : admin123
3. Akan langsung diarahkan ke Project Board
## Features

- [x] Project Board : Menampilkan data progres
- [x] CRUD data proyek, supplier, barang, barang masuk, barang keluar
- [x] Login dan logout
- [x] Edit password
- [x] Ganti nama user


## Penutup

Terima kasih telah memberikan bintang untuk repo ini dan semoga repositori ini menginspirasi Anda.

