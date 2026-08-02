<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Hasil Seleksi Security - Sentra Niaga Bekasi</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            body { bg-color: #ffffff !important; }
            .no-print { display: none !important; }
            @page { margin: 1cm; size: A4 portrait; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 font-sans p-6 sm:p-10" onload="window.print()">

    <!-- Floating Print Button -->
    <div class="no-print max-w-4xl mx-auto mb-6 flex justify-between items-center bg-slate-900 text-white p-4 rounded-2xl shadow-xl">
        <p class="text-xs font-bold">Dokumen Siap Dicetak / Disimpan sebagai PDF</p>
        <button onclick="window.print()" class="px-5 py-2 bg-sky-500 hover:bg-sky-400 text-white text-xs font-bold rounded-xl shadow-lg transition-all">
            <i class="fa-solid fa-print mr-2"></i> Cetak Sekarang
        </button>
    </div>

    <!-- Official Paper Layout -->
    <div class="max-w-4xl mx-auto bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200 space-y-5">
        
        <!-- Kop Surat Official -->
        <div class="border-b-2 border-slate-900 pb-4 text-center">
            <h1 class="text-xl font-black tracking-wider uppercase text-slate-900">PERKANTORAN SENTRA NIAGA BEKASI</h1>
            <p class="text-xs font-semibold text-slate-700 mt-1">Pengelola Perkantoran & Pusat Pertokoan Sentra Niaga</p>
            <p class="text-[11px] text-slate-500">Jl. Ahmad Yani No. 1, Bekasi Selatan, Kota Bekasi, Jawa Barat 17148 | Telp: (021) 8899-7700</p>
        </div>

        <!-- Document Title -->
        <div class="text-center space-y-1">
            <h2 class="text-base font-extrabold uppercase text-slate-900 tracking-wide underline underline-offset-4">LEMBAR REKAPITULASI KEPUTUSAN PENERIMAAN ANGGOTA SECURITY</h2>
            <p class="text-xs font-semibold text-slate-600">Sistem Evaluasi Terstruktur & Rekomendasi Kelayakan Security</p>
            <p class="text-[11px] text-slate-400 font-mono">Tanggal Cetak: {{ now()->translatedFormat('d F Y H:i') }} WIB</p>
        </div>

        <!-- Criteria Info Table -->
        <div class="space-y-2">
            <p class="text-xs font-bold text-slate-800 uppercase tracking-wider">Kriteria Penilaian yang Digunakan:</p>
            <div class="grid grid-cols-2 gap-2 text-xs text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-200">
                <div><strong>Integritas:</strong> SKCK & Catatan Kriminal (Bobot 30%)</div>
                <div><strong>Kesehatan Fisik:</strong> Kondisi Prima & MCU (Bobot 25%)</div>
                <div><strong>Pengalaman Kerja:</strong> Pengalaman Security (Bobot 25%)</div>
                <div><strong>Kesiapan Shift:</strong> Fleksibilitas Jam Kerja (Bobot 20%)</div>
            </div>
        </div>

        <!-- Ranking Results Table -->
        <div class="space-y-2">
            <p class="text-xs font-bold text-slate-800 uppercase tracking-wider">Daftar Peringkat Rekomendasi Pelamar:</p>
            <table class="w-full text-left text-[10px] border-collapse border border-slate-300">
                <thead>
                    <tr class="bg-slate-100 text-slate-800 font-bold uppercase border-b border-slate-300">
                        <th class="p-2 border border-slate-300">Nama Pelamar</th>
                        <th class="p-2 border border-slate-300 text-center">Integritas</th>
                        <th class="p-2 border border-slate-300 text-center">Kesehatan</th>
                        <th class="p-2 border border-slate-300 text-center">Pengalaman</th>
                        <th class="p-2 border border-slate-300 text-center">Kesiapan Shift</th>
                        <th class="p-2 border border-slate-300 text-center">Keputusan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $res)
                    @php
                        $scores = $res->candidate->scores->keyBy('criteria_id');
                        $c1_val = $scores->get(1)->score_val ?? null;
                        $c2_val = $scores->get(2)->score_val ?? null;
                        $c3_val = $scores->get(3)->score_val ?? null;
                        $c4_val = $scores->get(4)->score_val ?? null;
                        
                        $c1_desc = $c1_val ? $criterias->get(1)->subCriterias->firstWhere('value', $c1_val)->description ?? '-' : '-';
                        $c2_desc = $c2_val ? $criterias->get(2)->subCriterias->firstWhere('value', $c2_val)->description ?? '-' : '-';
                        $c3_desc = $c3_val ? $criterias->get(3)->subCriterias->firstWhere('value', $c3_val)->description ?? '-' : '-';
                        $c4_desc = $c4_val ? $criterias->get(4)->subCriterias->firstWhere('value', $c4_val)->description ?? '-' : '-';
                    @endphp
                    <tr>
                        <td class="p-2 border border-slate-300">
                            <span class="font-bold">{{ $res->candidate->name }}</span>
                        </td>
                        <td class="p-2 border border-slate-300 text-[9px] font-semibold max-w-[150px]">{{ $c1_desc }}</td>
                        <td class="p-2 border border-slate-300 text-[9px] font-semibold max-w-[150px]">{{ $c2_desc }}</td>
                        <td class="p-2 border border-slate-300 text-[9px] font-semibold max-w-[150px]">{{ $c3_desc }}</td>
                        <td class="p-2 border border-slate-300 text-[9px] font-semibold max-w-[150px]">{{ $c4_desc }}</td>
                        <td class="p-2 border border-slate-300 text-center font-extrabold">
                            {{ strtoupper($res->recommendation_status) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Note -->
        <p class="text-[11px] text-slate-500 italic">
            * Catatan: Keputusan akhir penerimaan didasarkan pada skor kombinasi evaluasi kualifikasi dan potensi serta pertimbangan manajemen Perkantoran Sentra Niaga Bekasi.
        </p>

        <!-- Signatures Area -->
        <div class="pt-4 grid grid-cols-2 gap-8 text-xs text-slate-800">
            <div>
                <p class="font-bold">Mengetahui,</p>
                <p class="font-extrabold mt-0.5">Kepala Manajemen Operasional</p>
                <div class="h-16"></div>
                <p class="font-extrabold text-slate-900 underline underline-offset-4">( .................................................... )</p>
            </div>
            <div class="text-right">
                <p class="font-bold">Bekasi, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="font-extrabold mt-0.5">Ketua Tim HRD & Penilai</p>
                <div class="h-16"></div>
                <p class="font-extrabold text-slate-900 underline underline-offset-4">( {{ Auth::user()->name ?? 'Administrator' }} )</p>
            </div>
        </div>

    </div>

</body>
</html>
