# Gule (Gerbang Undang-undang Legal Elektronik)

Gule adalah asisten hukum berbasis AI yang membantu pengelolaan dan pencarian peraturan perundang-undangan secara cerdas. Aplikasi ini menggunakan sistem **RAG (Retrieval-Augmented Generation)** untuk menjawab pertanyaan pengguna hanya berdasarkan basis data dokumen hukum yang telah diunggah.

## Fitur Utama
- **Dashboard Modern**: Visualisasi ringkasan data hukum.
- **Upload PDF**: Ekstraksi teks otomatis dari file PDF hukum.
- **AI Chatbot**: Bertanya langsung pada AI yang bersumber dari dokumen hukum di bank data.
- **Bank Data**: Manajemen dokumen hukum (Tambah, Lihat, Hapus).
- **Keamanan**: Proteksi CSRF global dan validasi backend untuk file upload.

---

## Prasyarat (Prerequisites)
- **PHP**: 8.2 atau lebih tinggi.
- **MySQL/MariaDB**: 5.7+ (Wajib mendukung Full-Text Search).
- **Composer**: Versi 2.x.
- **Google Gemini API Key**: [Dapatkan di sini](https://aistudio.google.com/app/apikey).

---

## Panduan Instalasi (Development)

1. **Clone & Install Dependensi**:
   ```bash
   composer install
   ```

2. **Konfigurasi Environment**:
   Salin file `env` menjadi `.env` dan sesuaikan konfigurasinya:
   ```bash
   cp env .env
   ```
   Edit `.env`:
   - `CI_ENVIRONMENT = development`
   - `database.default.hostname = localhost`
   - `database.default.database = gule`
   - `database.default.username = root`
   - `database.default.password = `
   - `GEMINI_API_KEY = YOUR_GOOGLE_GEMINI_API_KEY`

3. **Setup Database**:
   Buat database bernama `gule` di MySQL, lalu jalankan migrasi:
   ```bash
   php spark migrate
   ```

4. **Jalankan Server Lokal**:
   ```bash
   php spark serve
   ```
   Akses aplikasi di: `http://localhost:8080`

---

## Panduan Instalasi (Production)

1. **Upload File**: Unggah semua file ke server production (direkomendasikan menggunakan Git).
2. **Setup .env**:
   Pastikan `CI_ENVIRONMENT = production`.
   Gunakan password database yang kuat.
3. **Optimasi Composer**:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```
4. **Izin Direktori (Permissions)**:
   Pastikan direktori `writable/` dapat ditulisi oleh server (misal: `www-data`):
   ```bash
   chmod -R 775 writable
   chown -R www-data:www-data writable
   ```
5. **Konfigurasi Web Server**:
   Arahkan **Document Root** ke folder `public/`, bukan ke folder root proyek.
6. **Keamanan**: Generate encryption key untuk aplikasi:
   ```bash
   php spark key:generate
   ```

---

## Skema Database SQL (Manual)

Jika Anda ingin membuat tabel secara manual tanpa fitur migrasi CI4, gunakan script SQL berikut:

```sql
CREATE DATABASE IF NOT EXISTS gule;
USE gule;

-- Tabel Dokumen
CREATE TABLE documents (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    filename VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    year INT(4),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Potongan Teks (Chunks) untuk RAG
CREATE TABLE document_chunks (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    document_id INT(11) UNSIGNED,
    chunk_content TEXT,
    metadata VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FULLTEXT(chunk_content)
) ENGINE=InnoDB;

-- Tabel Riwayat Chat
CREATE TABLE chat_history (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(100) NOT NULL,
    sender ENUM('user', 'bot') DEFAULT 'user',
    message TEXT,
    `references` TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

---

## Tech Stack
- **Framework**: CodeIgniter 4.7
- **Database**: MySQL (Full-Text Engine)
- **AI Engine**: Google Gemini Pro (RAG System)
- **Frontend**: Tailwind CSS v3
- **Libraries**:
  - `smalot/pdfparser`: PDF extraction
  - `google-gemini-php/client`: AI integration
