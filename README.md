/*saya Ajipati Alaga Putra dengan NIM 2409682
mengerjakan TP5 dalam mata kuliah DPBO
untuk keberkahannya maka saya tidak akan melakukan kecurangan
sepertu yang telah di spesifikasikan Aamiin.*/

# 📚 Sistem Perpustakaan

## Deskripsi
Website ini adalah **sistem manajemen perpustakaan sederhana**.  
Fitur utama:  
- Mengelola **Penulis** (Authors)  
- Mengelola **Buku** (Books)  
- Mengelola **Anggota** (Members)  

Setiap entitas memiliki **CRUD (Create, Read, Update, Delete)**.  
Website dibuat menggunakan **PHP & MySQL** dengan **Prepared Statement** untuk seluruh query, sehingga aman dari SQL Injection.

---

## Database

### Nama Database
`perpustakaan`

### Tabel dan Struktur

#### 1. authors – Data Penulis
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id    | INT, AUTO_INCREMENT, PRIMARY KEY | ID unik penulis |
| name  | VARCHAR(100) | Nama penulis |
| email | VARCHAR(100) | Email penulis |

#### 2. books – Data Buku
| Kolom     | Tipe | Keterangan |
|-----------|------|-----------|
| id        | INT, AUTO_INCREMENT, PRIMARY KEY | ID unik buku |
| title     | VARCHAR(150) | Judul buku |
| author_id | INT | Foreign key ke tabel `authors` |
| year      | INT | Tahun terbit buku |

**Relasi:** `books.author_id` → `authors.id`

#### 3. members – Data Anggota
| Kolom   | Tipe | Keterangan |
|---------|------|-----------|
| id      | INT, AUTO_INCREMENT, PRIMARY KEY | ID unik anggota |
| name    | VARCHAR(100) | Nama anggota |
| address | VARCHAR(150) | Alamat anggota |

---

## Flow Sistem

1. **Dashboard (`index.php`)**  
   - Menu navigasi ke **Manajemen Penulis**, **Buku**, dan **Anggota**.

2. **CRUD All-in-One (authors.php / books.php / members.php)**  
   - Halaman menampilkan **form input** di atas tabel data.  
   - Klik **Simpan** → data ditambahkan (**Create**)  
   - Klik **Edit** → form muncul dengan data yang dipilih (**Update**)  
   - Klik **Hapus** → data dihapus (**Delete**)  
   - Semua query menggunakan **Prepared Statement**  
   - Tabel menampilkan semua data (**Read**) sekaligus

3. **Relasi Books → Authors**  
   - Saat menambah atau edit buku, admin bisa memilih penulis dari dropdown (diambil dari tabel `authors`)  
   - Tabel buku menampilkan nama penulis menggunakan **JOIN**.

4. **Navigasi**  
   - Semua halaman CRUD memiliki tombol **Kembali ke Dashboard**  
   - Struktur folder sederhana, semua file berada di satu folder → tidak ada masalah path atau Not Found.

## Dokumentasi
