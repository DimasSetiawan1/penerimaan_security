@extends('layouts.app')

@section('title', 'Indikator Penilaian - Sentra Niaga Bekasi')
@section('header_title', 'Standar Indikator & Parameter Penilaian Pelamar Security')

@section('content')
<div class="space-y-8">
    
    <!-- Title Info Card -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-800">Standar Kriteria & Indikator Penilaian</h1>
            <p class="text-xs text-slate-500 mt-1">
                Kriteria penilaian seleksi penerimaan petugas security pada PT Sentra Niaga Bekasi (Data Terstandarisasi Sistem).
            </p>
        </div>
        <div class="flex items-center space-x-2 bg-sky-50 text-sky-800 px-4 py-2 rounded-xl text-xs font-bold border border-sky-200">
            <i class="fa-solid fa-lock text-sm text-sky-600"></i>
            <span>Status Data: <strong>Standar Tetap System</strong></span>
        </div>
    </div>

    <!-- Criteria Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-base font-extrabold text-slate-800">Matriks Kriteria Penilaian Utama</h2>
            <span class="text-xs text-slate-400 font-semibold">Total Bobot: 100%</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-400 font-bold uppercase text-[11px] tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Nama Kriteria Penilaian</th>
                        <th class="px-6 py-4 text-center">Sifat Penilaian</th>
                        <th class="px-6 py-4 text-center">Persentase Bobot</th>
                        <th class="px-6 py-4 text-center">Nilai Bobot Ter-normalisasi</th>
                        <th class="px-6 py-4 text-center">Skala Indikator</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($criterias as $crit)
                    @php
                        $normWeight = $totalWeight > 0 ? round($crit->weight / $totalWeight, 4) : 0;
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4 font-extrabold text-slate-800 text-base">
                            {{ $crit->name }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-full text-xs font-extrabold">
                                {{ strtoupper($crit->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center font-extrabold text-slate-800 text-base">
                            {{ $crit->weight }}%
                        </td>
                        <td class="px-6 py-4 text-center font-mono font-bold text-sky-700">
                            {{ $normWeight }} ({{ round($normWeight * 100, 1) }}%)
                        </td>
                        <td class="px-6 py-4 text-center text-xs font-semibold text-slate-500">
                            Skala {{ $crit->min_val }} s/d {{ $crit->max_val }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sub-Criteria Details Section -->
    <div class="space-y-6">
        <h2 class="text-lg font-extrabold text-slate-800">Detail Indikator Penilaian (Skala Likert 1 - 5)</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($criterias as $crit)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <span class="font-extrabold text-slate-800 text-base">{{ $crit->name }}</span>
                    <span class="text-xs font-bold text-slate-400">Bobot: {{ $crit->weight }}%</span>
                </div>

                <div class="space-y-2">
                    @foreach($crit->subCriterias as $sub)
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/80 flex items-center justify-between gap-3 hover:bg-slate-100/80 transition-colors">
                        <div class="flex items-center space-x-3">
                            <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-slate-800 text-white font-black text-xs flex items-center justify-center shadow-sm">
                                {{ $sub->value }}
                            </span>
                            <div>
                                <p class="text-xs font-bold text-slate-800">{{ $sub->description }}</p>
                                <p class="text-[10px] text-slate-400 font-semibold mt-0.5">Tingkat Kualifikasi: <span class="text-sky-600 font-bold">Skala {{ $sub->value }} dari 5</span></p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
