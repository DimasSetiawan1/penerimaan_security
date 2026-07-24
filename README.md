# 🛡️ Sistem Pendukung Keputusan (SPK) Penerimaan Security

Sistem Pendukung Keputusan (SPK) Seleksi & Penerimaan Anggota Keamanan (Security) berbasis Web menggunakan kombinasi metode **SMART (Simple Multi-Attribute Rating Technique)** dan **SWOT (Strengths, Weaknesses, Opportunities, Threats)**.

Aplikasi ini dirancang untuk membantu tim HRD dan Manajemen dalam melakukan seleksi penerimaan petugas security secara obyektif, terukur, transparan, dan terstruktur.

---

## 🚀 Fitur Utama

1. **Dashboard Analytics**: Ringkasan data kandidat, statistik penerimaan (Diterima, Pertimbangan, Ditolak), dan distribusi kuadran SWOT.
2. **Manajemen Kriteria (`/criteria`)**: Pengaturan kriteria penilaian, bobot kriteria, serta deskripsi indikator sub-kriteria (skala 1–5).
3. **Manajemen Kandidat (`/candidates`)**: Pengelolaan data pelamar security, input skor kriteria, dan evaluasi SWOT.
4. **Matriks Perhitungan SPK (`/calculation`)**: Menampilkan alur perhitungan secara detail dan transparan mulai dari:
   - Normalisasi Bobot Kriteria
   - Matriks Utilitas SMART
   - Skor Matriks SWOT (IFAS & EFAS)
   - Pembobotan Kombinasi (70% SMART + 30% SWOT)
   - Perangkingan kandidat
5. **Laporan & Cetak (`/reports`)**: Rekapitulasi hasil seleksi dan fitur cetak laporan keputusan penerimaan.

---

## 🛠️ Tech Stack & Arsitektur

* **Framework Backend**: [Laravel 11.x](https://laravel.com) (PHP >= 8.2)
* **Frontend & Styling**: Blade Templates, TailwindCSS, Vite
* **Database**: MySQL / MariaDB / SQLite
* **Architecture Pattern**: MVC (Model-View-Controller) & Service Layer ([SmartSwotService.php](app/Services/SmartSwotService.php))

---

## 🧮 Metode Perhitungan SPK (SMART + SWOT)

Perhitungan rekomendasi kandidat dilakukan secara otomatis oleh sistem melalui 4 tahapan utama:

### 1. Perhitungan Metode SMART (Bobot 70%)
* **Normalisasi Bobot Kriteria ($w_j$)**:
  $$w_j = \frac{W_j}{\sum W_k}$$
* **Nilai Utilitas ($u_i$)**:
  $$u_i = \frac{C_i - C_{min}}{C_{max} - C_{min}} \quad (\text{Tipe Benefit})$$
* **Skor Total SMART**:
  $$\text{Skor SMART} = \sum (u_i \times w_j)$$

### 2. Perhitungan Evaluasi SWOT (Bobot 30%)
* **Faktor Internal (IFAS)**: $\text{IFAS} = S - W$
* **Faktor Eksternal (EFAS)**: $\text{EFAS} = O - T$
* **Penentuan Kuadran & Strategi**:
  - **SO (Agresif)**: $\text{IFAS} \ge 0, \text{EFAS} \ge 0$
  - **ST (Diversifikasi)**: $\text{IFAS} \ge 0, \text{EFAS} < 0$
  - **WO (Turnaround)**: $\text{IFAS} < 0, \text{EFAS} \ge 0$
  - **WT (Defensif)**: $\text{IFAS} < 0, \text{EFAS} < 0$
* **Normalisasi Skor SWOT (Skala 0 - 1)**:
  $$\text{Skor SWOT} = \frac{(S + O) + (5 - W) + (5 - T)}{20}$$

### 3. Combination Score (Nilai Akhir)
$$\text{Final Score} = (0.70 \times \text{Skor SMART}) + (0.30 \times \text{Skor SWOT})$$

### 4. Keputusan Rekomendasi
* **Persentase $\ge 75\%$**: **Diterima**
* **Persentase $55\% - 74\%$**: **Pertimbangan**
* **Persentase $< 55\%$**: **Ditolak**

---

## 📋 Kriteria Penilaian Default

| Kode | Kriteria Penilaian | Tipe | Bobot Awal | Skala Nilai (1–5) |
|---|---|---|---|---|
| **C1** | Integritas (Catatan Kriminal / SKCK) | Benefit | 30% | 1 (Kasus Berat) s/d 5 (SKCK Bersih + Referensi) |
| **C2** | Kesehatan & Tes Fisik | Benefit | 25% | 1 (Tidak Layak) s/d 5 (Sehat Prima + Lulus Tes Fisik) |
| **C3** | Pengalaman Kerja Security | Benefit | 25% | 1 (Tanpa Pengalaman) s/d 5 (> 5 Thn / Ex-Perkantoran/Mall) |
| **C4** | Kesiapan Shift & Fleksibilitas | Benefit | 20% | 1 (Tidak Fleksibel) s/d 5 (Siap Semua Shift & Malam) |

---

## 🗄️ Struktur Basis Data

* `users`: Data pengguna sistem (Admin & HRD).
* `criterias`: Master kriteria & bobot.
* `sub_criterias`: Parameter & indikator detail kriteria skala 1–5.
* `candidates`: Data biodata pelamar security.
* `candidate_scores`: Nilai skor kriteria kandidat.
* `swot_evaluations`: Evaluasi faktor S, W, O, T kandidat.
* `calculation_results`: Hasil perhitungan SMART, SWOT, skor akhir, rank, dan status rekomendasi.

---

## ⚙️ Panduan Instalasi & Memulai

### Prasyarat System
* PHP >= 8.2
* Composer
* Node.js & NPM
* Database Engine (MySQL/MariaDB/SQLite)

### Langkah-Langkah Setup

1. **Clone / Download Repositori**
   ```bash
   git clone <repository_url>
   cd penerimaan_security
   ```

2. **Install Dependensi Composer & NPM**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment (`.env`)**
   Salin file `.env.example` ke `.env`:
   ```bash
   cp .env.example .env
   ```
   Sesuaikan konfigurasi database pada file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=penerimaan_security
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key, Migrasi & Seed Database**
   ```bash
   php artisan key:generate
   php artisan migrate:fresh --seed
   ```

5. **Jalankan Development Server & Asset Bundler**
   ```bash
   # Terminal 1 - Laravel Server
   php artisan serve

   # Terminal 2 - Asset Compiler (Vite)
   npm run dev
   ```

6. **Akses Aplikasi**
   Buka browser dan akses alamat: `http://127.0.0.1:8000`

---

## 🔑 Akun Default (Seeder)

| Email | Password | Role |
|---|---|---|
| `admin@sentraniaga.com` | `password` | Administrator |
| `hrd@sentraniaga.com` | `password` | Tim HRD |

---

## 📄 Lisensi
Proyek ini dibuat untuk keperluan SPK Seleksi Penerimaan Security.
