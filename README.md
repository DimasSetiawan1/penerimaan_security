# 🛡️ Sistem Pendukung Keputusan (SPK) Penerimaan Security (SMART + SWOT)

Sistem Pendukung Keputusan (SPK) Seleksi & Penerimaan Anggota Keamanan (Security) berbasis Web menggunakan hibridisasi metode **SMART (Simple Multi-Attribute Rating Technique)** dan evaluasi **SWOT (Strengths, Weaknesses, Opportunities, Threats)**.

Aplikasi ini dirancang untuk membantu tim **HRD (Human Resource Department)** dan **Manajemen Operasional** dalam melakukan seleksi penerimaan petugas security secara obyektif, terukur, transparan, terstruktur, serta minim bias kualitatif.

---

## 📌 Daftar Isi
- [🚀 Fitur Utama & Modul Sistem](#-fitur-utama--modul-sistem)
- [🛠️ Tech Stack & Arsitektur](#️-tech-stack--arsitektur)
- [📁 Struktur Direktori Proyek](#-struktur-direktori-proyek)
- [🧮 Metodologi Perhitungan SPK (SMART + SWOT)](#-metodologi-perhitungan-spk-smart--swot)
- [📊 Skema Basis Data & Relasi Tabel](#-skema-basis-data--relasi-tabel)
- [📋 Master Data Kriteria & Sub-Kriteria Default](#-master-data-kriteria--sub-kriteria-default)
- [⚙️ Panduan Instalasi & Memulai](#️-panduan-instalasi--memulai)
- [🔑 Akun Pengguna Default (Seeder)](#-akun-pengguna-default-seeder)

---

## 🚀 Fitur Utama & Modul Sistem

1. **🔐 Authentication & Multi-Role Support**:
   - Autentikasi aman bagi Pengguna Admin dan HRD.
   - Sesi terlindungi middleware Laravel (`auth`).

2. **📊 Dashboard Analytics (`/dashboard`)**:
   - Ringkasan statistik kandidat pelamar security.
   - Indikator status penerimaan (**Diterima**, **Pertimbangan**, **Ditolak**).
   - Visualisasi distribusi kuadran evaluasi SWOT kandidat.

3. **⚙️ Manajemen Kriteria & Sub-Kriteria (`/criteria`)**:
   - Pengaturan bobot kriteria ($W_j$) secara dinamis.
   - Deskripsi indikator sub-kriteria penilaian skala Likert (skala 1–5).

4. **👤 Manajemen Pelamar / Kandidat (`/candidates`)**:
   - CRUD data calon anggota security (Kode Pelamar auto-generate `K01`, `K02`, NIK, Nama, Gender, No HP, Alamat).
   - Input nilai kriteria (skala 1–5).
   - Input skor kuantitatif komponen SWOT ($S, W, O, T$).

5. **🧮 Matriks Perhitungan SPK Transparan (`/calculation`)**:
   - Menampilkan detail matematis alur perhitungan step-by-step:
     - Normalisasi Bobot Kriteria ($w_j$).
     - Matriks Nilai Utilitas SMART ($u_i$).
     - Perhitungan Skor Matriks SWOT (IFAS & EFAS).
     - Pembobotan Kombinasi (**70% SMART + 30% SWOT**).
     - Hasil perangkingan otomatis (*Automatic Ranking*).

6. **📄 Laporan & Cetak Dokumen (`/reports` & `/reports/print`)**:
   - Rekapitulasi peringkat & rekomendasi keputusan akhir.
   - Halaman cetak laporan resmi (*Print Friendly layout*) untuk pengesahan Manajemen.

---

## 🛠️ Tech Stack & Arsitektur

* **Framework Backend**: [Laravel 11.x](https://laravel.com) (PHP >= 8.2)
* **Frontend & UI Styling**: Laravel Blade Templates, TailwindCSS, Vite Assets Bundler
* **Icons & UI Utilities**: FontAwesome / Heroicons
* **Database Engine**: MySQL / MariaDB / SQLite
* **Design Pattern**: Model-View-Controller (MVC) & Service Layer Pattern ([`SmartSwotService.php`](app/Services/SmartSwotService.php))

---

## 📁 Struktur Direktori Proyek

```text
penerimaan_security/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Handlers Login & Logout
│   │   │   ├── CalculationController.php   # Handlers Tampilan Perhitungan Transparan
│   │   │   ├── CandidateController.php     # CRUD Kandidat & Skor
│   │   │   ├── CriteriaController.php      # Pengaturan Bobot & Sub-Kriteria
│   │   │   ├── DashboardController.php     # Analytics & Ringkasan Dashboard
│   │   │   └── ReportController.php        # Handlers Rekap & Print Laporan
│   │   └── Middleware/
│   ├── Models/
│   │   ├── CalculationResult.php          # Model Rekap Perangkingan
│   │   ├── Candidate.php                  # Model Data Pelamar
│   │   ├── CandidateScore.php             # Model Skor Kriteria Candidate
│   │   ├── Criteria.php                   # Model Kriteria Penilaian
│   │   ├── SubCriteria.php                # Model Indikator Skala 1-5
│   │   ├── SwotEvaluation.php             # Model Nilai SWOT & Kuadran
│   │   └── User.php                       # Model Pengguna System
│   └── Services/
│       └── SmartSwotService.php           # Core Engine Perhitungan SMART + SWOT
├── config/                                # Konfigurasi Framework Laravel
├── database/
│   ├── migrations/                        # Skema Tabel Basis Data
│   └── seeders/
│       └── DatabaseSeeder.php             # Initial Dummy Data & Default Criteria
├── public/                                # Web Root / Compiled Assets
├── resources/
│   ├── views/                             # Template Tampilan (Blade)
│   │   ├── auth/                          # Tampilan Login
│   │   ├── calculation/                   # Tampilan Detail Perhitungan SMART-SWOT
│   │   ├── candidates/                    # Tampilan CRUD & Form Candidate
│   │   ├── criteria/                      # Tampilan Pengaturan Kriteria
│   │   ├── reports/                       # Tampilan Rekap & Print Laporan
│   │   ├── dashboard.blade.php            # Tampilan Dashboard Utama
│   │   └── layouts/                       # Main Master Layout & Navigation
├── routes/
│   └── web.php                            # Routing Web Application
├── vite.config.js                         # Konfigurasi Bundler Frontend Vite
└── composer.json                          # Dependensi PHP/Laravel
```

---

## 🧮 Metodologi Perhitungan SPK (SMART + SWOT)

Perhitungan rekomendasi kandidat dieksekusi secara terotomatisasi oleh service [`SmartSwotService`](app/Services/SmartSwotService.php) dengan alur matematis sebagai berikut:

### 1. Perhitungan Metode SMART (Bobot Pengaruh: 70%)
* **Normalisasi Bobot Kriteria ($w_j$)**:
  $$w_j = \frac{W_j}{\sum_{k=1}^{n} W_k}$$
  *Keterangan: $W_j$ adalah bobot asli kriteria ke-$j$.*

* **Nilai Utilitas SMART ($u_i$)**:
  - Untuk Kriteria Tipe **Benefit**:
    $$u_i = \frac{C_i - C_{min}}{C_{max} - C_{min}}$$
  - Untuk Kriteria Tipe **Cost**:
    $$u_i = \frac{C_{max} - C_i}{C_{max} - C_{min}}$$
  *Keterangan: $C_i$ adalah skor mentah kandidat, $C_{min}=1$, $C_{max}=5$.*

* **Total Skor SMART ($Skor_{SMART}$)**:
  $$Skor_{SMART} = \sum_{j=1}^{n} (u_j \times w_j)$$

---

### 2. Perhitungan Evaluasi SWOT (Bobot Pengaruh: 30%)
* **Skor Faktor Internal (IFAS)**: 
  $$\text{IFAS} = S - W$$
* **Skor Faktor Eksternal (EFAS)**: 
  $$\text{EFAS} = O - T$$

* **Pemetaan Kuadran Matrix SWOT & Strategi**:
  - **Kuadran SO (Agresif)** ($\text{IFAS} \ge 0, \text{EFAS} \ge 0$): Candidate Sangat Berpotensi.
  - **Kuadran ST (Diversifikasi)** ($\text{IFAS} \ge 0, \text{EFAS} < 0$): Candidate Tangguh & Berpengalaman.
  - **Kuadran WO (Turnaround)** ($\text{IFAS} < 0, \text{EFAS} \ge 0$): Candidate Memerlukan Pelatihan Khusus.
  - **Kuadran WT (Defensif)** ($\text{IFAS} < 0, \text{EFAS} < 0$): Candidate Berisiko Tinggi.

* **Normalisasi Skor SWOT (Skala 0 s/d 1)**:
  $$Skor_{SWOT} = \frac{(S + O) + (5 - W) + (5 - T)}{20}$$

---

### 3. Combination Score (Skor Akhir Keputusan)
$$Final\_Score = (0.70 \times Skor_{SMART}) + (0.30 \times Skor_{SWOT})$$

---

### 4. Matriks Keputusan Rekomendasi Penerimaan
* **Persentase Final Score $\ge 75\%$**: **Diterima** (Rekomendasi Utama)
* **Persentase Final Score $55\% - 74\%$**: **Pertimbangan** (Cadangan / Wawancara Lanjutan)
* **Persentase Final Score $< 55\%$**: **Ditolak** (Tidak Memenuhi Standar Minimal)

---

## 📊 Skema Basis Data & Relasi Tabel

Aplikasi menggunakan 7 tabel utama dalam basis data:

1. **`users`**: Menyimpan kredensial pengguna (Admin & HRD).
2. **`criterias`**: Master kriteria penilaian (`code`, `name`, `type`, `weight`, `min_val`, `max_val`).
3. **`sub_criterias`**: Indikator deskripsi skala 1-5 per kriteria (`criteria_id`, `value`, `description`).
4. **`candidates`**: Master data biodata pelamar security (`code`, `nik`, `name`, `gender`, `phone`, `address`, `status`).
5. **`candidate_scores`**: Transactional table nilai kriteria kandidat (`candidate_id`, `criteria_id`, `score_val`).
6. **`swot_evaluations`**: Evaluation table komponen SWOT pelamar (`candidate_id`, `strengths_score`, `weaknesses_score`, `opportunities_score`, `threats_score`, `ifas_score`, `efas_score`, `quadrant`, `strategy_recommendation`).
7. **`calculation_results`**: Table rekapitulasi rangking (`candidate_id`, `smart_score`, `swot_score`, `final_score`, `rank`, `recommendation_status`).

---

## 📋 Master Data Kriteria & Sub-Kriteria Default

| Kode | Kriteria Penilaian | Tipe | Bobot Awal | Skala Nilai (1–5) & Indikator Penilaian |
|---|---|---|---|---|
| **C1** | Integritas (Catatan Kriminal / SKCK) | Benefit | 30% | 1: Kasus Berat<br>2: Kasus Ringan<br>3: Tanpa Catatan (Belum SKCK)<br>4: SKCK Bersih<br>5: SKCK Bersih + Referensi Institusi |
| **C2** | Kesehatan Fisik & Tes Fisik | Benefit | 25% | 1: Ada Penyakit Berat / Tidak Layak<br>2: Kurang Prima<br>3: Sehat (Belum MCU)<br>4: Sehat MCU<br>5: Sehat Prima + Lulus Tes Fisik |
| **C3** | Pengalaman Kerja Security | Benefit | 25% | 1: Tanpa Pengalaman<br>2: < 1 Tahun<br>3: 1–2 Tahun<br>4: 3–5 Tahun<br>5: > 5 Tahun / Perkantoran & Mall |
| **C4** | Kesiapan Shift & Fleksibilitas | Benefit | 20% | 1: Tidak Fleksibel<br>2: 2 Shift (Kendala Transpor)<br>3: Bisa Semua Shift (Belum Terbukti)<br>4: Bisa Semua Shift (Domisili Dekat)<br>5: Siap Shift Malam & Pengalaman Shift |

---

## ⚙️ Panduan Instalasi & Memulai

### Prasyarat Sistem
* **PHP** >= 8.2 (ekstensi `pdo_mysql`, `mbstring`, `openssl`, `bcmath`, `gd` aktif)
* **Composer** (v2.x)
* **Node.js** (v18.x / v20.x) & **NPM**
* **Database Server**: MySQL 8.0+ / MariaDB 10.4+ / SQLite

---

### Langkah-Langkah Setup Local Environment

1. **Clone Repositori Proyek**:
   ```bash
   git clone <repository_url>
   cd penerimaan_security
   ```

2. **Install Dependensi Composer & NPM**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment File (`.env`)**:
   Salin `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Atur koneksi database pada `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=penerimaan_security
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate App Key, Migrasi & Seed Database**:
   ```bash
   php artisan key:generate
   php artisan migrate:fresh --seed
   ```

5. **Jalankan Application Server & Asset Compiler**:
   - Terminal 1 (Laravel Local Server):
     ```bash
     php artisan serve
     ```
   - Terminal 2 (Vite Compiler):
     ```bash
     npm run dev
     ```

6. **Akses Aplikasi melalui Browser**:
   Buka URL: `http://127.0.0.1:8000`

---

## 🔑 Akun Pengguna Default (Seeder)

Gunakan akun seeder berikut untuk melakukan pengujian sistem:

| Email | Password | Peran (Role) | Hak Akses |
|---|---|---|---|
| `admin@sentraniaga.com` | `password` | Administrator | Full Access (Kelola User, Kriteria, Candidate, Perhitungan, Laporan) |
| `hrd@sentraniaga.com` | `password` | Tim HRD | HR Access (Kelola Candidate, Input Evaluasi, Perhitungan, Cetak Laporan) |

---

## 📄 Lisensi
Sistem Pendukung Keputusan (SPK) Penerimaan Security ini dikembangkan untuk mengoptimalkan proses seleksi anggota keamanan yang obyektif dan akurat.
