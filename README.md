# 💻 Stored XSS Simulation – PHP + XAMPP (Tanpa Database)

## 🧠 Apa Itu Stored XSS?

**Stored Cross-Site Scripting (Stored XSS)** adalah bentuk serangan XSS di mana **skrip berbahaya disimpan secara permanen di server atau session**. Ketika pengguna lain membuka halaman yang memuat data tersebut, skrip akan dijalankan oleh browser mereka.

Stored XSS umum terjadi di fitur **komentar, profil pengguna, atau input pengguna lainnya** yang ditampilkan kembali tanpa validasi atau penyaringan.

---

## 🧪 Ringkasan Percobaan

- ✅ **Tanpa database** (menggunakan `$_SESSION` sebagai penyimpanan sementara)
- ✅ Menggunakan **PHP** dan **XAMPP**
- ✅ Simulasi komentar pengguna
- ⚠️ Komentar ditampilkan kembali **tanpa disaring**, sehingga **Stored XSS terjadi**
- 📄 Semua kode berada di **satu file: `index.php`**

---

## 🛠️ Tools & Lingkungan

| Komponen   | Keterangan                                |
|------------|--------------------------------------------|
| Server     | [XAMPP]  |
| Bahasa     | PHP                                        |
| Penyimpanan| Session PHP (`$_SESSION`)                 |
| File       | `index.php`                               |

---

## 📂 Struktur File

Hanya menggunakan satu file:

```
/htdocs/
└── index.php
```

---

## 🧪 Simulasi XSS
### Buat index.php
```php
<?php
$koneksi = mysqli_connect("localhost", "root", "", "xss_db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $komentar = $_POST['komentar'];
    // Simpan komentar tanpa filter (rawan XSS)
    mysqli_query($koneksi, "INSERT INTO komentar (isi) VALUES ('$komentar')");
    echo "<p style='color:green;'>Komentar berhasil disimpan!</p>";
}
?>

<!-- Form input -->
<form method="POST">
    <textarea name="komentar" placeholder="Tulis komentar..."></textarea><br>
    <button type="submit">Kirim</button>
</form>

<hr>

<!-- Menampilkan komentar -->
<h3>Daftar Komentar:</h3>
<?php
$data = mysqli_query($koneksi, "SELECT * FROM komentar ORDER BY id DESC");
while($row = mysqli_fetch_assoc($data)) {
    echo "<p>{$row['isi']}</p>"; // ❌ rawan Stored XSS
}
?>
```

### 💬 Masukkan komentar berikut ke dalam form:

```html
<script>alert('XSS berhasil!')</script>
```

### 🧨 Hasil:
Saat komentar ditampilkan ulang, JavaScript akan dijalankan secara otomatis di browser — ini adalah **Stored XSS**.
![alt text](<image/Screenshot 2025-05-01 095012.png>)
Hasilnya:
![alt text](<image/Screenshot 2025-05-01 095040.png>)
---

## 🛡️ Solusi untuk Mencegah XSS

Untuk menghindari XSS, gunakan fungsi **`htmlspecialchars()`** saat menampilkan data:

```php
<?= htmlspecialchars($c, ENT_QUOTES, 'UTF-8') ?>
```

Dengan ini, tag HTML seperti `<script>` akan diubah menjadi teks biasa dan tidak akan dijalankan.

---

## 📖 Referensi

- 🔍 PortSwigger: [Stored XSS](https://portswigger.net/web-security/cross-site-scripting/stored)  
- 🌐 XAMPP Official: [https://www.apachefriends.org](https://www.apachefriends.org)  
- 📘 PHP Manual – [`htmlspecialchars()`](https://www.php.net/manual/en/function.htmlspecialchars.php)

---

## ✅ Catatan Tambahan

- Karena data disimpan di `$_SESSION`, komentar akan hilang jika browser ditutup atau session berakhir.
- Ini adalah cara sederhana untuk belajar Stored XSS **tanpa mengatur database**.

---

Jika Anda ingin saya bantu buat versi aman dari `index.php` atau ingin dibuatkan versi menggunakan database seperti MySQL, tinggal beri tahu saja!