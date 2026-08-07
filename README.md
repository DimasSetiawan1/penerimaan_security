# 🛡️ Sistem Penilaian & Seleksi Penerimaan Pelamar Security (Sentra Niaga Bekasi)

Sistem Seleksi & Evaluasi Pelamar Security berbasis Web yang dirancang secara profesional untuk membantu tim **HRD (Human Resource Department)** dan **Manajemen Operasional PT Sentra Niaga Bekasi** dalam melakukan seleksi penerimaan petugas security secara obyektif, terukur, transparan, terstruktur, serta bebas bias kualitatif.

Aplikasi ini mengintegrasikan pembobotan kriteria terstandarisasi dengan analisis profil kualifikasi pelamar secara otomatis.

---

## 📌 Daftar Isi

- [🚀 Fitur Utama & Modul Sistem](#-fitur-utama--modul-sistem)
- [🛠️ Tech Stack & Arsitektur](#️-tech-stack--arsitektur)
- [📁 Struktur Direktori Proyek](#-struktur-direktori-proyek)
- [🧮 Metodologi Perhitungan & Evaluasi Kelayakan](#-metodologi-perhitungan--evaluasi-kelayakan)
- [📊 Skema Basis Data & Relasi Tabel (ERD)](#-skema-basis-data--relasi-tabel-erd)
- [📋 Master Data Kriteria & Indikator Penilaian Default](#-master-data-kriteria--indikator-penilaian-default)
- [⚙️ Panduan Instalasi & Memulai](#️-panduan-instalasi--memulai)
- [🔑 Akun Pengguna Default (Seeder)](#-akun-pengguna-default-seeder)

---

## 🚀 Fitur Utama & Modul Sistem

1. **🔐 Authentication & Multi-Role Support**:
    - Autentikasi aman bagi Pengguna Admin dan Tim HRD.
    - Sesi terlindungi middleware Laravel (`auth`).

2. **📊 Dashboard Overview & Statistik (`/dashboard`)**:
    - Ringkasan statistik kandidat pelamar security.
    - Indikator status rekomendasi kelayakan (**Diterima**, **Pertimbangan**, **Ditolak**).
    - Visualisasi grafik peringkat pelamar dan distribusi kategori kualifikasi.

3. **📋 Standar Indikator Penilaian (`/criteria`)**:
    - Tampilan kriteria penilaian terstandarisasi yang ditetapkan oleh perusahaan (_Fixed Database Standard_).
    - Penjelasan indikator penilaian pada skala 1–5 untuk menjaga konsistensi evaluasi.

4. **👤 Data Pelamar & Evaluasi Integrated (`/candidates`)**:
    - Formulir input satu pintu (_Single Unified Form_) yang menggabungkan biodata pelamar (Kode Pelamar auto-generate `K01`, `K02`, NIK, Nama, Gender, Phone, Alamat) dan pilihan indikator kualifikasi.
    - Penilaian potensi dan profil dikalkulasi secara otomatis oleh sistem dari pilihan indikator tanpa perlu input manual terpisah.

5. **🧮 Detail & Matriks Evaluasi (`/calculation`)**:
    - Menampilkan detail matriks kalkulasi step-by-step secara transparan:
        - Pembobotan Kriteria Penilaian Ter-normalisasi.
        - Transformasi Skala Penilaian Indikator.
        - Analisis Profil & Adaptabilitas (Faktor Internal & Eksternal).
        - Visualisasi Peta Matriks Kualifikasi Pelamar.
        - Hasil Perangkingan & Evaluasi Akhir (70% Kriteria + 30% Analisis Potensi).

6. **📄 Laporan & Cetak Dokumen (`/reports` & `/reports/print`)**:
    - Rekapitulasi peringkat dan rekomendasi keputusan akhir penerimaan.
    - Halaman cetak laporan resmi berformat Kop Surat resmi untuk pengesahan Manajemen.

---

## 🛠️ Tech Stack & Arsitektur

- **Framework Backend**: [Laravel 11.x](https://laravel.com) (PHP >= 8.2)
- **Frontend & UI Styling**: Laravel Blade Templates, TailwindCSS, Vite Assets Bundler
- **Icons & UI Utilities**: FontAwesome 6, Chart.js, Alpine.js
- **Database Engine**: MySQL / MariaDB / SQLite
- **Design Pattern**: Model-View-Controller (MVC) & Service Layer Pattern ([`SmartSwotService.php`](app/Services/SmartSwotService.php))

---

## 📁 Struktur Direktori Proyek

```text
penerimaan_security/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Handlers Login & Logout
│   │   │   ├── CalculationController.php   # Handlers Detail & Matriks Evaluasi
│   │   │   ├── CandidateController.php     # Handlers Input Data Pelamar & Evaluasi
│   │   │   ├── CriteriaController.php      # Display Standar Indikator Penilaian
│   │   │   ├── DashboardController.php     # Analytics & Ringkasan Dashboard
│   │   │   └── ReportController.php        # Handlers Rekap & Print Laporan
│   │   └── Middleware/
│   ├── Models/
│   │   ├── CalculationResult.php          # Model Rekap Perangkingan
│   │   ├── Candidate.php                  # Model Data Pelamar
│   │   ├── CandidateScore.php             # Model Skor Indikator Candidate
│   │   ├── Criteria.php                   # Model Kriteria Penilaian
│   │   ├── SubCriteria.php                # Model Indikator Skala 1-5
│   │   ├── SwotEvaluation.php             # Model Evaluasi Profil & Adaptabilitas
│   │   └── User.php                       # Model Pengguna System
│   └── Services/
│       └── SmartSwotService.php           # Service Engine Calculation Engine
├── config/                                # Konfigurasi Framework Laravel
├── database/
│   ├── migrations/                        # Skema Tabel Basis Data
│   └── seeders/
│       └── DatabaseSeeder.php             # Master Data & Initial Default User/Criteria
├── public/                                # Web Root / Compiled Assets
├── resources/
│   ├── views/                             # Template Tampilan (Blade)
│   │   ├── auth/                          # Tampilan Login
│   │   ├── calculation/                   # Tampilan Detail & Matriks Evaluasi
│   │   ├── candidates/                    # Tampilan Form & Data Pelamar
│   │   ├── criteria/                      # Tampilan Standar Indikator Penilaian
│   │   ├── reports/                       # Tampilan Rekap & Print Laporan
│   │   ├── dashboard.blade.php            # Tampilan Dashboard Utama
│   │   └── layouts/                       # Main Master Layout & Navigation
├── routes/
│   └── web.php                            # Routing Web Application
├── vite.config.js                         # Konfigurasi Bundler Frontend Vite
└── composer.json                          # Dependensi PHP/Laravel
```

---

## 🧮 Metodologi Perhitungan & Evaluasi Kelayakan

Kalkulasi rekomendasi kelayakan pelamar dieksekusi secara terotomatisasi oleh service [`SmartSwotService`](app/Services/SmartSwotService.php) dengan alur matematis sebagai berikut:

### 1. Evaluasi Bobot Indikator Penilaian (Bobot Pengaruh: 70%)

- **Normalisasi Bobot Kriteria ($w_j$)**:
  $$w_j = \frac{W_j}{\sum_{k=1}^{n} W_k}$$
  _Keterangan: $W_j$ adalah bobot asli kriteria ke-$j$._

- **Nilai Skala Utilitas Ter-normalisasi ($u_i$)**:
    - Untuk Kriteria Tipe **Benefit**:
      $$u_i = \frac{C_i - C_{min}}{C_{max} - C_{min}}$$
      _Keterangan: $C_i$ adalah skor pilihan indikator pelamar, $C_{min}=1$, $C_{max}=5$.\_

- **Total Skor Indikator ($Skor_{Indikator}$)**:
  $$Skor_{Indikator} = \sum_{j=1}^{n} (u_j \times w_j)$$

---

### 2. Evaluasi Profil & Adaptabilitas Otomatis (Bobot Pengaruh: 30%)

Nilai evaluasi potensi dikalkulasi secara **otomatis dari pilihan sub-kriteria pelamar (C1–C4)**:

- **Faktor Kekuatan (Strengths / $S$)**: Rata-rata kriteria integritas, kesehatan fisik, dan pengalaman kerja ($S = \frac{C1 + C2 + C3}{3}$).
- **Faktor Kelemahan (Weaknesses / $W$)**: Inverse kelemahan ($W = 6 - S$).
- **Faktor Peluang (Opportunities / $O$)**: Kesiapan shift & adaptabilitas kerja ($O = C4$).
- **Faktor Ancaman (Threats / $T$)**: Inverse ancaman ($T = 6 - C4$).

- **Perhitungan Skor Ter-normalisasi Potensi**:
  $$Skor_{Potensi} = \frac{(S + O) + (5 - W) + (5 - T)}{20}$$

---

### 3. Perhitungan Skor Akhir Kelayakan

$$Skor_{Akhir} = (0.70 \times Skor_{Indikator}) + (0.30 \times Skor_{Potensi})$$

---

### 4. Matriks Keputusan Rekomendasi Penerimaan

- **Skor Akhir Kelayakan $\ge 75\%$**: **Diterima** (Rekomendasi Utama)
- **Skor Akhir Kelayakan $55\% - 74\%$**: **Pertimbangan** (Cadangan / Wawancara Lanjutan)
- **Skor Akhir Kelayakan $< 55\%$**: **Ditolak** (Belum Memenuhi Standar Minimal)

---

## 📊 Skema Basis Data & Relasi Tabel (ERD)

### 1. Diagram Relasi Antar Tabel (Entity Relationship Diagram - ERD)

```mermaid
erDiagram
    users {
        bigint id PK
        string name
        string email UK
        string password
        string role
        timestamp created_at
        timestamp updated_at
    }

    criterias {
        bigint id PK
        string code UK
        string name
        enum type
        float weight
        float min_val
        float max_val
        timestamp created_at
        timestamp updated_at
    }

    sub_criterias {
        bigint id PK
        bigint criteria_id FK
        integer value
        text description
        timestamp created_at
        timestamp updated_at
    }

    candidates {
        bigint id PK
        string code UK
        string nik
        string name
        enum gender
        string phone
        text address
        enum status
        timestamp created_at
        timestamp updated_at
    }

    candidate_scores {
        bigint id PK
        bigint candidate_id FK
        bigint criteria_id FK
        integer score_val
        timestamp created_at
        timestamp updated_at
    }

    swot_evaluations {
        bigint id PK
        bigint candidate_id FK
        float strengths_score
        float weaknesses_score
        float opportunities_score
        float threats_score
        float ifas_score
        float efas_score
        enum quadrant
        string strategy_recommendation
        text notes
        timestamp created_at
        timestamp updated_at
    }

    calculation_results {
        bigint id PK
        bigint candidate_id FK
        float smart_score
        float swot_score
        float final_score
        integer rank
        enum recommendation_status
        timestamp created_at
        timestamp updated_at
    }

    criterias ||--o{ sub_criterias : "memiliki (1:N)"
    criterias ||--o{ candidate_scores : "dinilai pada (1:N)"
    candidates ||--o{ candidate_scores : "memiliki nilai (1:N)"
    candidates ||--|| swot_evaluations : "dianalisis profil (1:1)"
    candidates ||--|| calculation_results : "menghasilkan (1:1)"
```

### 📌 Penjelasan Kardinalitas Relasi Antar Tabel:

1. **`criterias` → `sub_criterias` ($1 : N$)**: Satu kriteria memiliki 5 indikator sub-kriteria (skala Likert 1–5).
2. **`criterias` → `candidate_scores` ($1 : N$)**: Satu kriteria dipetakan ke transaksi penilaian pelamar.
3. **`candidates` → `candidate_scores` ($1 : N$)**: Satu pelamar memiliki 4 record pilihan indikator kriteria (C1–C4).
4. **`candidates` → `swot_evaluations` ($1 : 1$)**: Satu pelamar memiliki 1 record evaluasi profil potensi yang ter-generate otomatis.
5. **`candidates` → `calculation_results` ($1 : 1$)**: Satu pelamar menghasilkan 1 record rekapitulasi nilai akhir, peringkat, dan status keputusan penerimaan.
6. **`users`**: Tabel independen untuk sistem autentikasi dan manajemen hak akses (Admin & HRD).

---

### 2. Kamus Data & Spesifikasi Tabel (Database Data Dictionary)

a. Tabel `users`

**Nama Tabel** : _users_  
**Nama Database** : _penerimaan_security_  
**Jumlah Field** : _9 field_  
**Primary Key** : _id_  
**Fungsi** : mengelola data akun pengguna sistem (Admin & HRD)  
**Format** : _SQL_

**TABEL: 4.1. Users**

| No  | Field Name        | Data Type | Width | Keterangan                    |
| --- | ----------------- | --------- | ----- | ----------------------------- |
| 1   | Id                | Bigint    | 20    | Primary Key                   |
| 2   | Name              | Varchar   | 255   | Nama lengkap pengguna         |
| 3   | Email             | Varchar   | 255   | Alamat email (login)          |
| 4   | Email_verified_at | Timestamp | -     | Waktu verifikasi email        |
| 5   | Password          | Varchar   | 255   | Kata sandi terenkripsi (Hash) |
| 6   | Role              | Varchar   | 255   | Hak akses (`admin` / `hrd`)   |
| 7   | Remember_token    | Varchar   | 100   | Token sesi "remember me"      |
| 8   | Created_at        | Timestamp | -     | Waktu data dibuat             |
| 9   | Updated_at        | Timestamp | -     | Waktu data diperbarui         |

---

b. Tabel `criterias`

**Nama Tabel** : _criterias_  
**Nama Database** : _penerimaan_security_  
**Jumlah Field** : _9 field_  
**Primary Key** : _id_  
**Fungsi** : mengelola data master kriteria penilaian terstandarisasi  
**Format** : _SQL_

**TABEL: 4.2. Criterias**

| No  | Field Name | Data Type | Width | Keterangan                           |
| --- | ---------- | --------- | ----- | ------------------------------------ |
| 1   | Id         | Bigint    | 20    | Primary Key                          |
| 2   | Code       | Varchar   | 255   | Kode kriteria (C1, C2, C3, C4)       |
| 3   | Name       | Varchar   | 255   | Nama kriteria penilaian              |
| 4   | Type       | Enum      | -     | Sifat kriteria (`benefit` / `cost`)  |
| 5   | Weight     | Float     | -     | Nilai bobot kriteria ($W_j$) dalam % |
| 6   | Min_val    | Float     | -     | Nilai minimum indikator ($C_{min}$)  |
| 7   | Max_val    | Float     | -     | Nilai maksimum indikator ($C_{max}$) |
| 8   | Created_at | Timestamp | -     | Waktu data dibuat                    |
| 9   | Updated_at | Timestamp | -     | Waktu data diperbarui                |

---

c. Tabel `sub_criterias`

**Nama Tabel** : _sub_criterias_  
**Nama Database** : _penerimaan_security_  
**Jumlah Field** : _6 field_  
**Primary Key** : _id_  
**Fungsi** : mengelola parameter indikator skala nilai 1 s/d 5 kriteria  
**Format** : _SQL_

**TABEL: 4.3. Sub_criterias**

| No  | Field Name  | Data Type | Width | Keterangan                            |
| --- | ----------- | --------- | ----- | ------------------------------------- |
| 1   | Id          | Bigint    | 20    | Primary Key                           |
| 2   | Criteria_id | Bigint    | 20    | Foreign Key (`criterias.id`)          |
| 3   | Value       | Int       | 11    | Skala nilai indikator (1, 2, 3, 4, 5) |
| 4   | Description | Text      | -     | Deskripsi kualitatif indikator        |
| 5   | Created_at  | Timestamp | -     | Waktu data dibuat                     |
| 6   | Updated_at  | Timestamp | -     | Waktu data diperbarui                 |

---

d. Tabel `candidates`

**Nama Tabel** : _candidates_  
**Nama Database** : _penerimaan_security_  
**Jumlah Field** : _10 field_  
**Primary Key** : _id_  
**Fungsi** : mengelola biodata lengkap pelamar anggota security  
**Format** : _SQL_

**TABEL: 4.4. Candidates**

| No  | Field Name | Data Type | Width | Keterangan                              |
| --- | ---------- | --------- | ----- | --------------------------------------- |
| 1   | Id         | Bigint    | 20    | Primary Key                             |
| 2   | Code       | Varchar   | 255   | Kode unik pelamar (K01, K02, dst)       |
| 3   | Nik        | Varchar   | 255   | NIK pelamar                             |
| 4   | Name       | Varchar   | 255   | Nama lengkap pelamar                    |
| 5   | Gender     | Enum      | -     | Jenis kelamin (`L` / `P`)               |
| 6   | Phone      | Varchar   | 255   | Nomor HP / WhatsApp                     |
| 7   | Address    | Text      | -     | Alamat domisili                         |
| 8   | Status     | Enum      | -     | Status evaluasi (`Draft` / `Evaluated`) |
| 9   | Created_at | Timestamp | -     | Waktu data dibuat                       |
| 10  | Updated_at | Timestamp | -     | Waktu data diperbarui                   |

---

e. Tabel `candidate_scores`

**Nama Tabel** : _candidate_scores_  
**Nama Database** : _penerimaan_security_  
**Jumlah Field** : _6 field_  
**Primary Key** : _id_  
**Fungsi** : mengelola skor indikator (skala 1–5) pilihan pelamar  
**Format** : _SQL_

**TABEL: 4.5. Candidate_scores**

| No  | Field Name   | Data Type | Width | Keterangan                      |
| --- | ------------ | --------- | ----- | ------------------------------- |
| 1   | Id           | Bigint    | 20    | Primary Key                     |
| 2   | Candidate_id | Bigint    | 20    | Foreign Key (`candidates.id`)   |
| 3   | Criteria_id  | Bigint    | 20    | Foreign Key (`criterias.id`)    |
| 4   | Score_val    | Int       | 11    | Nilai indikator (Skala 1 s/d 5) |
| 5   | Created_at   | Timestamp | -     | Waktu data dibuat               |
| 6   | Updated_at   | Timestamp | -     | Waktu data diperbarui           |

---

f. Tabel `swot_evaluations`

**Nama Tabel** : _swot_evaluations_  
**Nama Database** : _penerimaan_security_  
**Jumlah Field** : _13 field_  
**Primary Key** : _id_  
**Fungsi** : mengelola skor evaluasi faktor internal/eksternal SWOT  
**Format** : _SQL_

**TABEL: 4.6. Swot_evaluations**

| No  | Field Name              | Data Type | Width | Keterangan                                        |
| --- | ----------------------- | --------- | ----- | ------------------------------------------------- |
| 1   | Id                      | Bigint    | 20    | Primary Key                                       |
| 2   | Candidate_id            | Bigint    | 20    | Foreign Key (`candidates.id`)                     |
| 3   | Strengths_score         | Float     | -     | Skor Kekuatan ($S$)                               |
| 4   | Weaknesses_score        | Float     | -     | Skor Kelemahan ($W$)                              |
| 5   | Opportunities_score     | Float     | -     | Skor Peluang ($O$)                                |
| 6   | Threats_score           | Float     | -     | Skor Ancaman ($T$)                                |
| 7   | Ifas_score              | Float     | -     | Nilai Faktor Internal ($S - W$)                   |
| 8   | Efas_score              | Float     | -     | Nilai Faktor Eksternal ($O - T$)                  |
| 9   | Quadrant                | Enum      | -     | Kategori Kualifikasi Profil (`SO`/`ST`/`WO`/`WT`) |
| 10  | Strategy_recommendation | Varchar   | 255   | Rekomendasi kualifikasi                           |
| 11  | Notes                   | Text      | -     | Catatan penilai / HRD                             |
| 12  | Created_at              | Timestamp | -     | Waktu data dibuat                                 |
| 13  | Updated_at              | Timestamp | -     | Waktu data diperbarui                             |

---

g. Tabel `calculation_results`

**Nama Tabel** : _calculation_results_  
**Nama Database** : _penerimaan_security_  
**Jumlah Field** : _9 field_  
**Primary Key** : _id_  
**Fungsi** : mengelola rekapitulasi hasil perangkingan & rekomendasi  
**Format** : _SQL_

**TABEL: 4.7. Calculation_results**

| No  | Field Name            | Data Type | Width | Keterangan                                                           |
| --- | --------------------- | --------- | ----- | -------------------------------------------------------------------- |
| 1   | Id                    | Bigint    | 20    | Primary Key                                                          |
| 2   | Candidate_id          | Bigint    | 20    | Foreign Key (`candidates.id`)                                        |
| 3   | Smart_score           | Float     | -     | Skor Indikator Kualifikasi ($0.0 - 1.0$)                             |
| 4   | Swot_score            | Float     | -     | Skor Potensi Profil ($0.0 - 1.0$)                                    |
| 5   | Final_score           | Float     | -     | Skor Kelayakan Akhir ($0.70 \times Indikator + 0.30 \times Potensi$) |
| 6   | Rank                  | Int       | 11    | Peringkat pelamar                                                    |
| 7   | Recommendation_status | Enum      | -     | Status rekomendasi keputusan (`Diterima`/`Pertimbangan`/`Ditolak`)   |
| 8   | Created_at            | Timestamp | -     | Waktu data dibuat                                                    |
| 9   | Updated_at            | Timestamp | -     | Waktu data diperbarui                                                |

---

## 📋 Master Data Kriteria & Indikator Penilaian Default

| Kriteria Penilaian                   | Tipe    | Bobot | Skala Nilai (1–5) & Indikator Kualifikasi                                                                                                                                     |
| ------------------------------------ | ------- | ----- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Integritas (Catatan Kriminal / SKCK) | Benefit | 30%   | 1: Kasus Berat<br>2: Kasus Ringan<br>3: Tanpa Catatan (Belum SKCK)<br>4: SKCK Bersih<br>5: SKCK Bersih + Referensi Institusi                                                  |
| Kesehatan Fisik & Tes Fisik          | Benefit | 25%   | 1: Ada Penyakit Berat / Tidak Layak<br>2: Kurang Prima<br>3: Sehat (Belum MCU)<br>4: Sehat MCU<br>5: Sehat Prima + Lulus Tes Fisik                                            |
| Pengalaman Kerja Security            | Benefit | 25%   | 1: Tanpa Pengalaman<br>2: < 1 Tahun<br>3: 1–2 Tahun<br>4: 3–5 Tahun<br>5: > 5 Tahun / Perkantoran & Mall                                                                      |
| Kesiapan Shift & Fleksibilitas       | Benefit | 20%   | 1: Tidak Fleksibel<br>2: 2 Shift (Kendala Transpor)<br>3: Bisa Semua Shift (Belum Terbukti)<br>4: Bisa Semua Shift (Domisili Dekat)<br>5: Siap Shift Malam & Pengalaman Shift |

---

## ⚙️ Panduan Instalasi & Memulai

### Prasyarat Sistem

- **PHP** >= 8.2 (ekstensi `pdo_mysql`, `mbstring`, `openssl`, `bcmath`, `gd` aktif)
- **Composer** (v2.x)
- **Node.js** (v18.x / v20.x) & **NPM**
- **Database Server**: MySQL 8.0+ / MariaDB 10.4+ / SQLite

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

| Email                   | Password   | Peran (Role)  | Hak Akses                                                        |
| ----------------------- | ---------- | ------------- | ---------------------------------------------------------------- |
| `admin@sentraniaga.com` | `password` | Administrator | Full Access (Kelola User, Data Pelamar, Evaluasi, Cetak Laporan) |
| `hrd@sentraniaga.com`   | `password` | Tim HRD       | HR Access (Kelola Data Pelamar, Input Evaluasi, Cetak Laporan)   |

## 🧪 Hasil Pengujian Sistem (Black Box Testing)

a. Pengujian Login

**TABEL: 4.8. Pengujian Login**

| No  | Skenario Pengujian                                   | Hasil Pengujian                                                                          | Keterangan |
| --- | ---------------------------------------------------- | ---------------------------------------------------------------------------------------- | ---------- |
| 1   | Melakukan login dengan email dan password yang benar | Sistem menampilkan pesan "Login Berhasil" dan mengarahkan ke halaman Dashboard           | Valid      |
| 2   | Melakukan login dengan email dan password yang salah | Sistem menampilkan pesan "Email atau Password Salah" dan pengguna tetap di halaman Login | Valid      |
| 3   | Melakukan logout dari sistem                         | Sistem mengakhiri sesi pengguna dan mengarahkan kembali ke halaman Login                 | Valid      |

---

b. Pengujian Data Pelamar & Evaluasi (Candidates)

**TABEL: 4.9. Pengujian Data Pelamar & Evaluasi**

| No  | Skenario Pengujian                                                                       | Hasil Pengujian                                                                             | Keterangan |
| --- | ---------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------- | ---------- |
| 1   | Melakukan input data pelamar baru dengan mengisi semua field wajib & indikator penilaian | Sistem menampilkan notifikasi "Data Pelamar Berhasil Ditambahkan" dan tersimpan di database | Valid      |
| 2   | Melakukan input data pelamar dengan mengosongkan field wajib (seperti Nama / NIK)        | Sistem menampilkan notifikasi validasi error "Field wajib diisi" dan data gagal disimpan    | Valid      |
| 3   | Melakukan update data pelamar dan nilai indikator penilaian                              | Sistem menampilkan pesan "Data Pelamar Berhasil Diperbarui" dan data ter-update             | Valid      |
| 4   | Melakukan hapus data pelamar                                                             | Sistem menampilkan konfirmasi dialog hapus dan menghapus data dari database                 | Valid      |

---

c. Pengujian Evaluasi & Perangkingan Otomatis

**TABEL: 4.10. Pengujian Evaluasi & Perangkingan**

| No  | Skenario Pengujian                                                                  | Hasil Pengujian                                                                         | Keterangan |
| --- | ----------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------- | ---------- |
| 1   | Melakukan kalkulasi otomatis skor indikator kualifikasi dan potensi profil kandidat | Sistem secara otomatis menghitung skor akhir dan menentukan status kelayakan pelamar    | Valid      |
| 2   | Menampilkan pemeringkatan (ranking) pelamar di Dashboard secara real-time           | Sistem menampilkan grafik urutan peringkat kandidat dari skor tertinggi hingga terendah | Valid      |

---

d. Pengujian Laporan Hasil Seleksi (HRD View)

**TABEL: 4.11. Pengujian Data Laporan Hasil Seleksi**

| No  | Skenario Pengujian                                                           | Hasil Pengujian                                                                               | Keterangan |
| --- | ---------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------- | ---------- |
| 1   | Membuka halaman Laporan Hasil Seleksi sebagai HRD                            | Sistem menampilkan tabel rekapitulasi lengkap hasil evaluasi seluruh pelamar                  | Valid      |
| 2   | Melakukan penyaringan (filter) laporan berdasarkan status kelayakan kandidat | Tabel laporan hanya menampilkan data kandidat sesuai dengan filter status yang dipilih        | Valid      |
| 3   | Melakukan cetak laporan hasil seleksi (_Print View_)                         | Sistem menampilkan format halaman laporan cetak resmi yang siap di-print atau disimpan ke PDF | Valid      |

---

e. Pengujian Hak Akses Pengguna (Role-Based Access Control)

**TABEL: 4.12. Pengujian Hak Akses Pengguna**

| No  | Skenario Pengujian                       | Hasil Pengujian                                                                   | Keterangan |
| --- | ---------------------------------------- | --------------------------------------------------------------------------------- | ---------- |
| 1   | Login menggunakan akun Admin (POV Admin) | Sidebar menampilkan seluruh menu termasuk Laporan Hasil Seleksi dan Cetak Laporan | Valid      |
| 2   | Login menggunakan akun Tim HRD (POV HRD) | Sidebar menampilkan seluruh menu termasuk Laporan Hasil Seleksi dan Cetak Laporan | Valid      |

---

## 💻 Lampiran Listing Code Utama (Untuk Keperluan Skripsi)

Berikut adalah potongan *source code* utama yang mengimplementasikan inti sistem, yaitu algoritma perhitungan SPK dan integrasi metode SMART & Analisis SWOT. Kode ini merupakan "otak" dari sistem seleksi dan cocok dilampirkan pada bab implementasi atau lampiran skripsi.

### 1. Implementasi Algoritma SMART & SWOT (`SmartSwotService.php`)

Kode ini terletak pada layer *Service* (`app/Services/SmartSwotService.php`) yang diakses oleh controller. Service ini melakukan normalisasi bobot, menghitung nilai utilitas (SMART), menurunkan faktor SWOT dari kriteria yang dipilih, mengklasifikasikan ke dalam kuadran, dan mengakumulasi skor akhir secara otomatis.

```php
// File: app/Services/SmartSwotService.php (Potongan Inti)

public function calculateAll()
{
    $criterias = Criteria::all();
    
    // 1. Hitung Normalisasi Bobot Kriteria (w_j)
    $totalWeight = $criterias->sum('weight');
    $normalizedWeights = [];
    foreach ($criterias as $crit) {
        $normalizedWeights[$crit->id] = $totalWeight > 0 ? ($crit->weight / $totalWeight) : 0;
    }

    $candidates = Candidate::with(['scores.criteria', 'swotEvaluation'])->get();

    foreach ($candidates as $candidate) {
        $smartTotal = 0;

        // 2. Perhitungan SMART (Nilai Utilitas & Terbobot)
        foreach ($criterias as $crit) {
            $scoreModel = $candidate->scores->firstWhere('criteria_id', $crit->id);
            $rawScore = $scoreModel ? $scoreModel->score_val : 1;
            
            $min = $crit->min_val > 0 ? $crit->min_val : 1;
            $max = $crit->max_val > 0 ? $crit->max_val : 5;

            // Rumus Normalisasi SMART (Benefit/Cost)
            if ($crit->type === 'benefit') {
                $utility = ($max - $min) > 0 ? ($rawScore - $min) / ($max - $min) : 0;
            } else {
                $utility = ($max - $min) > 0 ? ($max - $rawScore) / ($max - $min) : 0;
            }

            $smartTotal += ($utility * $normalizedWeights[$crit->id]);
        }

        // 3. Ekstraksi Otomatis Nilai SWOT (S, W, O, T) dari Indikator C1-C4
        // S: Rata-rata C1-C3 | W: Inverse S | O: C4 | T: Inverse O
        // ... (Logika ekstraksi variabel $S, $W, $O, $T dari skor)
        
        $ifas = $S - $W; // Faktor Internal
        $efas = $O - $T; // Faktor Eksternal

        // Klasifikasi Kuadran SWOT & Rekomendasi Strategi
        if ($ifas >= 0 && $efas >= 0) {
            $quadrant = 'SO'; $strategy = 'Kualifikasi Sangat Layak...';
        } elseif ($ifas >= 0 && $efas < 0) {
            $quadrant = 'ST'; $strategy = 'Kualifikasi Layak...';
        } elseif ($ifas < 0 && $efas >= 0) {
            $quadrant = 'WO'; $strategy = 'Kualifikasi Pertimbangan...';
        } else {
            $quadrant = 'WT'; $strategy = 'Kualifikasi Tidak Layak...';
        }

        // Normalisasi Skor SWOT (Konversi ke skala 0.0 - 1.0)
        $swotNormalized = (($S + $O) + (5 - $W) + (5 - $T)) / 20;

        // 4. Kalkulasi Skor Akhir Kelayakan (70% SMART + 30% SWOT)
        $finalScore = (0.70 * $smartTotal) + (0.30 * $swotNormalized);

        // ... (Simpan status 'Diterima'/'Pertimbangan'/'Ditolak' ke DB)
    }
}
```

### 2. Implementasi Controller Input Data (`CandidateController.php`)

Kode ini mengatur transaksi input data pelamar dari formulir, menyimpan ke database menggunakan `DB::transaction`, dan langsung memicu sistem perhitungan secara *real-time*.

```php
// File: app/Http/Controllers/CandidateController.php (Potongan Inti)

public function store(Request $request)
{
    // 1. Validasi Input Data
    $request->validate([
        'nik' => ['required', 'digits:16'],
        'name' => ['required', 'string'],
        // ...
        'scores' => ['required', 'array', 'size:' . Criteria::count()],
    ]);

    // 2. Transaksi Database (Atomic Save)
    DB::transaction(function () use ($request) {
        $candidate = Candidate::create([ /* ... Biodata ... */ ]);

        // Simpan nilai indikator kualifikasi (1-5)
        foreach ($request->scores as $critId => $val) {
            CandidateScore::create([
                'candidate_id' => $candidate->id,
                'criteria_id' => $critId,
                'score_val' => $val,
            ]);
        }
    });

    // 3. Pemicu Otomatis (Trigger) Evaluasi Kelayakan & Perangkingan
    $this->smartSwotService->calculateAll();

    return redirect()->route('candidates.index')
        ->with('success', 'Data pelamar berhasil ditambahkan dan dievaluasi.');
}
```

## 📄 Lisensi

Sistem Penilaian & Seleksi Penerimaan Security ini dikembangkan untuk PT Sentra Niaga Bekasi guna mengoptimalkan proses seleksi anggota keamanan yang obyektif, terstandar, dan profesional.
