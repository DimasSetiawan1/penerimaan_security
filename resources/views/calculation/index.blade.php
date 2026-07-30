@extends('layouts.app')

@section('title', 'Detail & Matriks Evaluasi - Sentra Niaga Bekasi')
@section('header_title', 'Detail Matriks Penilaian & Evaluasi Kualifikasi Pelamar')

@section('content')
<div class="space-y-10">
    
    <!-- Title Info Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-sky-950 to-slate-900 p-8 rounded-3xl text-white border border-slate-800 shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div>
            <span class="px-3 py-1 bg-sky-500/20 text-sky-300 border border-sky-500/30 rounded-full text-xs font-bold uppercase tracking-wider">
                <i class="fa-solid fa-list-check mr-1.5"></i> Evaluasi Terstandar
            </span>
            <h1 class="text-2xl font-black mt-2">Detail Matriks Evaluasi Penilaian Pelamar</h1>
            <p class="text-xs text-slate-300 mt-1 max-w-2xl">
                Rincian kalkulasi komprehensif penerimaan petugas security berdasarkan penilaian indikator kualifikasi dan analisis profil kandidat.
            </p>
        </div>
        <a href="{{ route('reports.print') }}" target="_blank" class="px-5 py-3 bg-sky-500 hover:bg-sky-400 text-white text-xs font-bold rounded-xl shadow-lg shadow-sky-500/30 transition-all flex items-center">
            <i class="fa-solid fa-print mr-2"></i> Cetak Dokumen Hasil
        </a>
    </div>

    <!-- Step 1: Pembobotan Kriteria Penilaian -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="flex items-center space-x-3 border-b border-slate-100 pb-4">
            <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center font-black text-sm">1</div>
            <div>
                <h2 class="text-base font-extrabold text-slate-800">Pembobotan Kriteria Penilaian</h2>
                <p class="text-xs text-slate-500">Normalisasi persentase bobot tiap kriteria terhadap total bobot keseluruhan</p>
            </div>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-400 font-bold uppercase border-b border-slate-100">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap">Nama Kriteria Penilaian</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Sifat Penilaian</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Bobot Persentase</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Nilai Bobot Ter-normalisasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($calculationData['criterias'] as $crit)
                    @php
                        $w_j = $calculationData['normalized_weights'][$crit->id] ?? 0;
                    @endphp
                    <tr>
                        <td class="px-4 py-3 font-bold text-slate-800 whitespace-nowrap">{{ $crit->name }}</td>
                        <td class="px-4 py-3 text-center uppercase font-bold text-emerald-600 whitespace-nowrap">{{ $crit->type }}</td>
                        <td class="px-4 py-3 text-center font-bold whitespace-nowrap">{{ $crit->weight }}%</td>
                        <td class="px-4 py-3 text-center font-mono font-extrabold text-sky-700 text-sm whitespace-nowrap">{{ round($w_j, 4) }} ({{ round($w_j * 100, 1) }}%)</td>
                    </tr>
                    @endforeach
                    <tr class="bg-sky-50/50 font-black">
                        <td colspan="2" class="px-4 py-3 text-right text-slate-800 whitespace-nowrap">TOTAL BOBOT:</td>
                        <td class="px-4 py-3 text-center text-slate-800 whitespace-nowrap">{{ $calculationData['total_weight'] }}%</td>
                        <td class="px-4 py-3 text-center text-sky-700 whitespace-nowrap">1.0000 (100%)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Step 2: Transformasi Skala Penilaian -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="flex items-center space-x-3 border-b border-slate-100 pb-4">
            <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center font-black text-sm">2</div>
            <div>
                <h2 class="text-base font-extrabold text-slate-800">Transformasi Skala Penilaian Indikator</h2>
                <p class="text-xs text-slate-500">Konversi nilai indikator kualifikasi (1–5) ke dalam skala ter-normalisasi (0.00 – 1.00)</p>
            </div>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-xs text-slate-700 border-collapse">
                <thead class="bg-slate-50 text-slate-400 font-bold uppercase border-b border-slate-100">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap">Pelamar</th>
                        @foreach($calculationData['criterias'] as $crit)
                        <th class="px-4 py-3 text-center border-l border-slate-100 whitespace-nowrap">
                            {{ $crit->name }} <span class="block text-[10px] text-slate-400 font-normal">Mentah &rarr; Skala</span>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($calculationData['results'] as $res)
                    <tr class="hover:bg-slate-50/80">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="font-extrabold text-slate-800 whitespace-nowrap">{{ $res['candidate']->name }}</span>
                            <span class="block text-[10px] text-slate-400 font-mono whitespace-nowrap">{{ $res['candidate']->code }}</span>
                        </td>
                        @foreach($calculationData['criterias'] as $crit)
                        @php
                            $uDet = $res['utility_details'][$crit->id] ?? ['raw' => 0, 'utility' => 0];
                        @endphp
                        <td class="px-4 py-3 text-center border-l border-slate-100 font-mono whitespace-nowrap">
                            <span class="font-bold text-slate-800">{{ $uDet['raw'] }}</span>
                            <span class="text-slate-400"> &rarr; </span>
                            <span class="font-extrabold text-sky-600">{{ sprintf('%.2f', $uDet['utility']) }}</span>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Step 3: Hasil Kalkulasi Skor Indikator Kualifikasi -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="flex items-center space-x-3 border-b border-slate-100 pb-4">
            <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center font-black text-sm">3</div>
            <div>
                <h2 class="text-base font-extrabold text-slate-800">Skor Indikator Kualifikasi</h2>
                <p class="text-xs text-slate-500">Perkalian nilai skala indikator dengan bobot masing-masing kriteria</p>
            </div>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-xs text-slate-700 border-collapse">
                <thead class="bg-slate-50 text-slate-400 font-bold uppercase border-b border-slate-100">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap">Pelamar</th>
                        @foreach($calculationData['criterias'] as $crit)
                        <th class="px-4 py-3 text-center border-l border-slate-100 whitespace-nowrap">
                            {{ $crit->name }}
                        </th>
                        @endforeach
                        <th class="px-4 py-3 text-center border-l border-slate-100 bg-sky-50 text-sky-900 whitespace-nowrap">Total Skor Indikator</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($calculationData['results'] as $res)
                    <tr class="hover:bg-slate-50/80">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="font-extrabold text-slate-800 whitespace-nowrap">{{ $res['candidate']->name }}</span>
                        </td>
                        @foreach($calculationData['criterias'] as $crit)
                        @php
                            $uDet = $res['utility_details'][$crit->id] ?? ['weighted_utility' => 0];
                        @endphp
                        <td class="px-4 py-3 text-center border-l border-slate-100 font-mono font-semibold whitespace-nowrap">
                            {{ sprintf('%.4f', $uDet['weighted_utility']) }}
                        </td>
                        @endforeach
                        <td class="px-4 py-3 text-center border-l border-slate-100 bg-sky-50/80 font-mono font-black text-sky-700 text-sm whitespace-nowrap">
                            {{ sprintf('%.4f', $res['smart_score']) }} ({{ $res['smart_score_pct'] }}%)
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Step 4: Analisis Profil & Matriks Kartesius -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Table SWOT Factors -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
            <div class="flex items-center space-x-3 border-b border-slate-100 pb-4">
                <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-black text-sm">4</div>
                <div>
                    <h2 class="text-base font-extrabold text-slate-800">Analisis Profil & Adaptabilitas</h2>
                    <p class="text-xs text-slate-500">Perhitungan Skor Faktor Internal & Faktor Eksternal Pelamar</p>
                </div>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-400 font-bold uppercase border-b border-slate-100">
                        <tr>
                            <th class="px-3 py-2.5 whitespace-nowrap">Pelamar</th>
                            <th class="px-2 py-2.5 text-center whitespace-nowrap">Kekuatan</th>
                            <th class="px-2 py-2.5 text-center whitespace-nowrap">Kelemahan</th>
                            <th class="px-2 py-2.5 text-center whitespace-nowrap">Peluang</th>
                            <th class="px-2 py-2.5 text-center whitespace-nowrap">Ancaman</th>
                            <th class="px-3 py-2.5 text-center whitespace-nowrap">Faktor Internal</th>
                            <th class="px-3 py-2.5 text-center whitespace-nowrap">Faktor Eksternal</th>
                            <th class="px-3 py-2.5 text-center whitespace-nowrap">Kualifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($calculationData['results'] as $res)
                        @php
                            $swot = $res['swot'];
                            $quad = $swot->quadrant;
                            $quadLabel = match($quad) {
                                'SO' => 'Sangat Layak',
                                'ST' => 'Layak',
                                'WO' => 'Pertimbangan',
                                'WT' => 'Tidak Layak',
                                default => '-'
                            };
                            $badgeClass = match($quad) {
                                'SO' => 'bg-emerald-100 text-emerald-800',
                                'ST' => 'bg-emerald-50 text-emerald-700',
                                'WO' => 'bg-amber-100 text-amber-800',
                                'WT' => 'bg-rose-100 text-rose-800',
                                default => 'bg-slate-100 text-slate-800'
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-3 py-2.5 font-bold text-slate-800 whitespace-nowrap">{{ $res['candidate']->name }}</td>
                            <td class="px-2 py-2.5 text-center font-mono font-semibold text-emerald-700 whitespace-nowrap">{{ $swot->strengths_score }}</td>
                            <td class="px-2 py-2.5 text-center font-mono font-semibold text-rose-700 whitespace-nowrap">{{ $swot->weaknesses_score }}</td>
                            <td class="px-2 py-2.5 text-center font-mono font-semibold text-sky-700 whitespace-nowrap">{{ $swot->opportunities_score }}</td>
                            <td class="px-2 py-2.5 text-center font-mono font-semibold text-amber-700 whitespace-nowrap">{{ $swot->threats_score }}</td>
                            <td class="px-3 py-2.5 text-center font-mono font-black text-slate-800 whitespace-nowrap">{{ $swot->ifas_score }}</td>
                            <td class="px-3 py-2.5 text-center font-mono font-black text-slate-800 whitespace-nowrap">{{ $swot->efas_score }}</td>
                            <td class="px-3 py-2.5 text-center whitespace-nowrap">
                                <span class="inline-flex items-center justify-center whitespace-nowrap px-2.5 py-0.5 rounded text-[11px] font-black {{ $badgeClass }}">
                                    {{ $quadLabel }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Scatter Plot Cartesian Diagram Chart.js -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h2 class="text-base font-extrabold text-slate-800">Peta Matriks Kualifikasi Pelamar</h2>
                    <p class="text-xs text-slate-500">Posisi koordinat pelamar pada Faktor Internal & Eksternal</p>
                </div>
                <span class="text-xs font-bold text-sky-600 bg-sky-50 px-3 py-1 rounded-lg">Peta Evaluasi Interaktif</span>
            </div>

            <div class="h-64 relative">
                <canvas id="cartesianChart"></canvas>
            </div>
        </div>

    </div>

    <!-- Step 5: Final Combined Score & Perankingan Keputusan -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-900 text-white flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-black tracking-wide">Tabel Perangkingan & Evaluasi Akhir</h2>
                <p class="text-xs text-slate-300 mt-0.5">Skor Kelayakan Akhir = (70% × Bobot Kriteria) + (30% × Analisis Potensi)</p>
            </div>
            <a href="{{ route('reports.index') }}" class="px-4 py-2 bg-sky-600 hover:bg-sky-500 text-white text-xs font-bold rounded-xl transition-all shadow-md">
                <i class="fa-solid fa-file-contract mr-1.5"></i> Lihat Rekap Laporan
            </a>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-sm text-slate-600 border-collapse">
                <thead class="bg-slate-50 text-slate-400 font-bold uppercase text-[11px] tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 whitespace-nowrap">Peringkat</th>
                        <th class="px-6 py-4 whitespace-nowrap">Kode & Nama Pelamar</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Skor Indikator (70%)</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Skor Potensi (30%)</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Skor Kelayakan (%)</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Kualifikasi Profil</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Status Keputusan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($calculationData['results'] as $res)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4 font-black text-slate-800 text-base whitespace-nowrap">
                            #{{ $res['rank'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-extrabold text-slate-800 whitespace-nowrap">{{ $res['candidate']->name }}</div>
                            <div class="text-xs text-slate-400 font-mono whitespace-nowrap">{{ $res['candidate']->code }}</div>
                        </td>
                        <td class="px-6 py-4 text-center font-mono font-bold text-slate-700 whitespace-nowrap">
                            {{ sprintf('%.4f', $res['smart_score']) }} ({{ $res['smart_score_pct'] }}%)
                        </td>
                        <td class="px-6 py-4 text-center font-mono font-bold text-slate-700 whitespace-nowrap">
                            {{ sprintf('%.4f', $res['swot_score']) }} ({{ $res['swot_score_pct'] }}%)
                        </td>
                        <td class="px-6 py-4 text-center font-mono font-black text-sky-600 text-lg whitespace-nowrap">
                            {{ $res['final_score_pct'] }}%
                        </td>
                        <td class="px-6 py-4 text-center font-extrabold text-xs text-slate-700 whitespace-nowrap">
                            @php
                                $quad = $res['swot']->quadrant;
                                $quadLabel = match($quad) {
                                    'SO' => 'Sangat Layak',
                                    'ST' => 'Layak',
                                    'WO' => 'Pertimbangan',
                                    'WT' => 'Tidak Layak',
                                    default => '-'
                                };
                            @endphp
                            {{ $quadLabel }}
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            @if($res['recommendation_status'] == 'Diterima')
                                <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    DITERIMA
                                </span>
                            @elseif($res['recommendation_status'] == 'Pertimbangan')
                                <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-200">
                                    PERTIMBANGAN
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1 rounded-full text-xs font-extrabold bg-rose-100 text-rose-800 border border-rose-200">
                                    DITOLAK
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctxCartesian = document.getElementById('cartesianChart').getContext('2d');
        
        const candidatePoints = [
            @foreach($calculationData['results'] as $res)
            {
                x: {{ $res['swot']->ifas_score }},
                y: {{ $res['swot']->efas_score }},
                label: '{{ $res['candidate']->name }} ({{ $res['candidate']->code }})'
            },
            @endforeach
        ];

        new Chart(ctxCartesian, {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Koordinat Pelamar (Faktor Internal, Eksternal)',
                    data: candidatePoints,
                    backgroundColor: '#0284c7',
                    pointRadius: 7,
                    pointHoverRadius: 9
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                const point = ctx.raw;
                                return point.label + ' -> Internal: ' + point.x + ', Eksternal: ' + point.y;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        min: -4,
                        max: 4,
                        title: { display: true, text: 'Skor Faktor Internal (Kekuatan vs Kelemahan)', font: { weight: 'bold', size: 11 } },
                        grid: { color: (ctx) => ctx.tick.value === 0 ? '#0f172a' : '#e2e8f0', lineWidth: (ctx) => ctx.tick.value === 0 ? 2 : 1 }
                    },
                    y: {
                        min: -4,
                        max: 4,
                        title: { display: true, text: 'Skor Faktor Eksternal (Peluang vs Ancaman)', font: { weight: 'bold', size: 11 } },
                        grid: { color: (ctx) => ctx.tick.value === 0 ? '#0f172a' : '#e2e8f0', lineWidth: (ctx) => ctx.tick.value === 0 ? 2 : 1 }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
