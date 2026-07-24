@extends('layouts.app')

@section('title', 'Laporan Hasil Keputusan - Sentra Niaga Bekasi')
@section('header_title', 'Laporan Rekapitulasi Penerimaan Security')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action Card & Status Filter -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-800">Laporan Rekapitulasi Keputusan Penilaian</h1>
            <p class="text-xs text-slate-500 mt-1">Hasil rekomendasi penerimaan security Perkantoran Sentra Niaga Bekasi</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-3 w-full md:w-auto">
            <!-- Status Filter -->
            <form action="{{ route('reports.index') }}" method="GET" class="w-full sm:w-auto">
                <select name="status" onchange="this.form.submit()"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option value="">Semua Status Keputusan</option>
                    <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Hanya Diterima</option>
                    <option value="Pertimbangan" {{ request('status') == 'Pertimbangan' ? 'selected' : '' }}>Hanya Pertimbangan</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Hanya Ditolak</option>
                </select>
            </form>

            <a href="{{ route('reports.print', ['status' => request('status')]) }}" target="_blank"
               class="w-full sm:w-auto px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-sky-600/30 transition-all flex items-center justify-center">
                <i class="fa-solid fa-print mr-2"></i> Cetak Dokumen Laporan
            </a>
        </div>
    </div>

    <!-- Official Report Preview Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        
        <!-- Document Header / Kop Surat Preview -->
        <div class="p-8 border-b border-slate-200 bg-slate-50 text-center relative">
            <div class="max-w-2xl mx-auto space-y-1">
                <h2 class="text-lg font-black tracking-wider text-slate-900 uppercase">PERKANTORAN SENTRA NIAGA BEKASI</h2>
                <p class="text-xs text-slate-600 font-semibold">Jl. Ahmad Yani No. 1, Bekasi Selatan, Kota Bekasi, Jawa Barat 17148</p>
                <p class="text-[11px] text-slate-400">Telepon: (021) 8899-7700 • Email: info@sentraniaga-bekasi.co.id</p>
                <div class="pt-3">
                    <div class="h-1 bg-slate-900 w-full mb-0.5"></div>
                    <div class="h-0.5 bg-slate-400 w-full"></div>
                </div>
            </div>
            <h3 class="text-base font-extrabold text-slate-800 uppercase tracking-wide mt-4">LEMBAR REKAPITULASI SELEKSI PENERIMAAN ANGGOTA SECURITY</h3>
            <p class="text-xs text-slate-500 font-semibold">Metode Simple Multi Attribute Rating Technique (SMART) & Analisis SWOT</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[11px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-center">Rank</th>
                        <th class="px-6 py-4">Nama & NIK Pelamar</th>
                        <th class="px-6 py-4 text-center">Integritas (C1)</th>
                        <th class="px-6 py-4 text-center">Kesehatan (C2)</th>
                        <th class="px-6 py-4 text-center">Pengalaman (C3)</th>
                        <th class="px-6 py-4 text-center">Shift (C4)</th>
                        <th class="px-6 py-4 text-center">Skor SMART</th>
                        <th class="px-6 py-4 text-center">Skor SWOT</th>
                        <th class="px-6 py-4 text-center">Skor Akhir</th>
                        <th class="px-6 py-4 text-center">Hasil Keputusan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($results as $res)
                    @php
                        $scores = $res->candidate->scores->keyBy('criteria_id');
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-center font-black text-slate-900 text-base">
                            #{{ $res->rank }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-extrabold text-slate-900">{{ $res->candidate->name }}</div>
                            <div class="text-xs text-slate-500 font-mono">{{ $res->candidate->code }} • NIK: {{ $res->candidate->nik ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center font-bold">{{ $scores->get(1)->score_val ?? '-' }}</td>
                        <td class="px-6 py-4 text-center font-bold">{{ $scores->get(2)->score_val ?? '-' }}</td>
                        <td class="px-6 py-4 text-center font-bold">{{ $scores->get(3)->score_val ?? '-' }}</td>
                        <td class="px-6 py-4 text-center font-bold">{{ $scores->get(4)->score_val ?? '-' }}</td>
                        <td class="px-6 py-4 text-center font-mono font-bold">{{ round($res->smart_score * 100, 1) }}%</td>
                        <td class="px-6 py-4 text-center font-mono font-bold">{{ round($res->swot_score * 100, 1) }}%</td>
                        <td class="px-6 py-4 text-center font-mono font-black text-sky-700 text-base">
                            {{ round($res->final_score * 100, 2) }}%
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($res->recommendation_status == 'Diterima')
                                <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-900 border border-emerald-300">
                                    DITERIMA
                                </span>
                            @elseif($res->recommendation_status == 'Pertimbangan')
                                <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-900 border border-amber-300">
                                    PERTIMBANGAN
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-rose-100 text-rose-900 border border-rose-300">
                                    DITOLAK
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-10 text-slate-400 font-semibold">Tidak ada data hasil keputusan sesuai filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Signature Box Preview -->
        <div class="p-8 border-t border-slate-200 bg-slate-50 flex justify-between items-end text-xs text-slate-700">
            <div>
                <p class="font-bold">Mengetahui,</p>
                <p class="font-extrabold text-slate-900 mt-1">Kepala HRD & Operational Sentra Niaga</p>
                <div class="h-16"></div>
                <p class="font-bold text-slate-900 underline underline-offset-4">( .................................................... )</p>
            </div>
            <div class="text-right">
                <p class="font-bold">Bekasi, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="font-extrabold text-slate-900 mt-1">Ketua Tim Evaluator Security</p>
                <div class="h-16"></div>
                <p class="font-bold text-slate-900 underline underline-offset-4">( {{ Auth::user()->name }} )</p>
            </div>
        </div>

    </div>

</div>
@endsection
