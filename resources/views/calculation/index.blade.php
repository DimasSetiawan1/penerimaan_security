@extends('layouts.app')

@section('title', 'Langkah Perhitungan SMART & SWOT - Sentra Niaga Bekasi')
@section('header_title', 'Rincian Perhitungan Matematika Metode SMART & Analisis SWOT')

@section('content')
<div class="space-y-10">
    
    <!-- Title Info Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-sky-950 to-slate-900 p-8 rounded-3xl text-white border border-slate-800 shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div>
            <span class="px-3 py-1 bg-sky-500/20 text-sky-300 border border-sky-500/30 rounded-full text-xs font-bold uppercase tracking-wider">
                <i class="fa-solid fa-square-root-variable mr-1.5"></i> Transparansi Metode Skripsi
            </span>
            <h1 class="text-2xl font-black mt-2">Langkah Demi Langkah Perhitungan Keputusan</h1>
            <p class="text-xs text-slate-300 mt-1 max-w-2xl">
                Pembuktian matematis kalkulasi penerimaan security menggunakan penggabungan Metode **SMART** ($V(a) = \sum w_j \cdot u_j(a)$) dan **Analisis SWOT** ($X=S-W, Y=O-T$).
            </p>
        </div>
        <a href="{{ route('reports.print') }}" target="_blank" class="px-5 py-3 bg-sky-500 hover:bg-sky-400 text-white text-xs font-bold rounded-xl shadow-lg shadow-sky-500/30 transition-all flex items-center">
            <i class="fa-solid fa-print mr-2"></i> Cetak Dokumen Hasil
        </a>
    </div>

    <!-- Step 1: Normalisasi Bobot Kriteria SMART -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="flex items-center space-x-3 border-b border-slate-100 pb-4">
            <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center font-black text-sm">1</div>
            <div>
                <h2 class="text-base font-extrabold text-slate-800">Normalisasi Bobot Kriteria ($w_j = \frac{W_j}{\sum W}$)</h2>
                <p class="text-xs text-slate-500">Membagi nilai bobot asli kriteria $W_j$ dengan total seluruh bobot kriteria</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-400 font-bold uppercase border-b border-slate-100">
                    <tr>
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">Nama Kriteria</th>
                        <th class="px-4 py-3 text-center">Type</th>
                        <th class="px-4 py-3 text-center">Bobot Asli ($W_j$)</th>
                        <th class="px-4 py-3 text-center">Rumus Normalisasi</th>
                        <th class="px-4 py-3 text-center">Bobot Ternormalisasi ($w_j$)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($calculationData['criterias'] as $crit)
                    @php
                        $w_j = $calculationData['normalized_weights'][$crit->id] ?? 0;
                    @endphp
                    <tr>
                        <td class="px-4 py-3 font-bold text-sky-600">{{ $crit->code }}</td>
                        <td class="px-4 py-3 font-bold text-slate-800">{{ $crit->name }}</td>
                        <td class="px-4 py-3 text-center uppercase font-bold text-emerald-600">{{ $crit->type }}</td>
                        <td class="px-4 py-3 text-center font-bold">{{ $crit->weight }}</td>
                        <td class="px-4 py-3 text-center font-mono text-slate-500">{{ $crit->weight }} / {{ $calculationData['total_weight'] }}</td>
                        <td class="px-4 py-3 text-center font-mono font-extrabold text-sky-700 text-sm">{{ round($w_j, 4) }} ({{ round($w_j * 100, 1) }}%)</td>
                    </tr>
                    @endforeach
                    <tr class="bg-sky-50/50 font-black">
                        <td colspan="3" class="px-4 py-3 text-right text-slate-800">TOTAL BOBOT ($\sum W$):</td>
                        <td class="px-4 py-3 text-center text-slate-800">{{ $calculationData['total_weight'] }}</td>
                        <td class="px-4 py-3 text-center text-slate-800">-</td>
                        <td class="px-4 py-3 text-center text-sky-700">1.0000 (100%)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Step 2: Matriks Nilai Mentah & Nilai Utilitas Sub-Kriteria -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="flex items-center space-x-3 border-b border-slate-100 pb-4">
            <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center font-black text-sm">2</div>
            <div>
                <h2 class="text-base font-extrabold text-slate-800">Nilai Utilitas SMART ($u_i = \frac{C_i - C_{\min}}{C_{\max} - C_{\min}}$)</h2>
                <p class="text-xs text-slate-500">Pengubahan skor kriteria (1–5) ke skala utilitas $0.00 \dots 1.00$</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 border-collapse">
                <thead class="bg-slate-50 text-slate-400 font-bold uppercase border-b border-slate-100">
                    <tr>
                        <th class="px-4 py-3">Pelamar</th>
                        @foreach($calculationData['criterias'] as $crit)
                        <th class="px-4 py-3 text-center border-l border-slate-100">
                            {{ $crit->code }} <span class="block text-[10px] text-slate-400 font-normal">Mentah | Utilitas</span>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($calculationData['results'] as $res)
                    <tr class="hover:bg-slate-50/80">
                        <td class="px-4 py-3">
                            <span class="font-extrabold text-slate-800">{{ $res['candidate']->name }}</span>
                            <span class="block text-[10px] text-slate-400 font-mono">{{ $res['candidate']->code }}</span>
                        </td>
                        @foreach($calculationData['criterias'] as $crit)
                        @php
                            $uDet = $res['utility_details'][$crit->id] ?? ['raw' => 0, 'utility' => 0];
                        @endphp
                        <td class="px-4 py-3 text-center border-l border-slate-100 font-mono">
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

    <!-- Step 3: Hasil Kalkulasi Skor SMART ($V(a_i)$) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="flex items-center space-x-3 border-b border-slate-100 pb-4">
            <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center font-black text-sm">3</div>
            <div>
                <h2 class="text-base font-extrabold text-slate-800">Total Skor SMART ($V(a_i) = \sum w_j \cdot u_j(a_i)$)</h2>
                <p class="text-xs text-slate-500">Perkalian nilai utilitas dengan bobot ternormalisasi kriteria</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 border-collapse">
                <thead class="bg-slate-50 text-slate-400 font-bold uppercase border-b border-slate-100">
                    <tr>
                        <th class="px-4 py-3">Pelamar</th>
                        @foreach($calculationData['criterias'] as $crit)
                        <th class="px-4 py-3 text-center border-l border-slate-100">
                            {{ $crit->code }} ($w_j \cdot u_j$)
                        </th>
                        @endforeach
                        <th class="px-4 py-3 text-center border-l border-slate-100 bg-sky-50 text-sky-900">Total SMART</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($calculationData['results'] as $res)
                    <tr class="hover:bg-slate-50/80">
                        <td class="px-4 py-3">
                            <span class="font-extrabold text-slate-800">{{ $res['candidate']->name }}</span>
                        </td>
                        @foreach($calculationData['criterias'] as $crit)
                        @php
                            $uDet = $res['utility_details'][$crit->id] ?? ['weighted_utility' => 0];
                        @endphp
                        <td class="px-4 py-3 text-center border-l border-slate-100 font-mono font-semibold">
                            {{ sprintf('%.4f', $uDet['weighted_utility']) }}
                        </td>
                        @endforeach
                        <td class="px-4 py-3 text-center border-l border-slate-100 bg-sky-50/80 font-mono font-black text-sky-700 text-sm">
                            {{ sprintf('%.4f', $res['smart_score']) }} ({{ $res['smart_score_pct'] }}%)
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Step 4: Analisis SWOT & Matriks Kartesius -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Table SWOT Factors -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
            <div class="flex items-center space-x-3 border-b border-slate-100 pb-4">
                <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-black text-sm">4</div>
                <div>
                    <h2 class="text-base font-extrabold text-slate-800">Evaluasi SWOT (IFAS & EFAS)</h2>
                    <p class="text-xs text-slate-500">Hitung $X = S - W$ dan $Y = O - T$</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-400 font-bold uppercase border-b border-slate-100">
                        <tr>
                            <th class="px-3 py-2.5">Pelamar</th>
                            <th class="px-2 py-2.5 text-center">S</th>
                            <th class="px-2 py-2.5 text-center">W</th>
                            <th class="px-2 py-2.5 text-center">O</th>
                            <th class="px-2 py-2.5 text-center">T</th>
                            <th class="px-3 py-2.5 text-center">IFAS ($X$)</th>
                            <th class="px-3 py-2.5 text-center">EFAS ($Y$)</th>
                            <th class="px-3 py-2.5 text-center">Kuadran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($calculationData['results'] as $res)
                        @php
                            $swot = $res['swot'];
                        @endphp
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-3 py-2.5 font-bold text-slate-800">{{ $res['candidate']->name }}</td>
                            <td class="px-2 py-2.5 text-center font-mono font-semibold text-emerald-700">{{ $swot->strengths_score }}</td>
                            <td class="px-2 py-2.5 text-center font-mono font-semibold text-rose-700">{{ $swot->weaknesses_score }}</td>
                            <td class="px-2 py-2.5 text-center font-mono font-semibold text-sky-700">{{ $swot->opportunities_score }}</td>
                            <td class="px-2 py-2.5 text-center font-mono font-semibold text-amber-700">{{ $swot->threats_score }}</td>
                            <td class="px-3 py-2.5 text-center font-mono font-black text-slate-800">{{ $swot->ifas_score }}</td>
                            <td class="px-3 py-2.5 text-center font-mono font-black text-slate-800">{{ $swot->efas_score }}</td>
                            <td class="px-3 py-2.5 text-center">
                                <span class="px-2 py-0.5 rounded text-[11px] font-black bg-indigo-100 text-indigo-800">
                                    {{ $swot->quadrant }}
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
                    <h2 class="text-base font-extrabold text-slate-800">Diagram Kartesius SWOT</h2>
                    <p class="text-xs text-slate-500">Posisi koordinat kandidat pada sumbu $X$ (IFAS) & $Y$ (EFAS)</p>
                </div>
                <span class="text-xs font-bold text-sky-600 bg-sky-50 px-3 py-1 rounded-lg">Grafik Interaktif</span>
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
                <h2 class="text-lg font-black tracking-wide">Tabel Perankingan & Rekomendasi Keputusan Akhir</h2>
                <p class="text-xs text-slate-300 mt-0.5">Skor Akhir = (70% × SMART) + (30% × SWOT)</p>
            </div>
            <a href="{{ route('reports.index') }}" class="px-4 py-2 bg-sky-600 hover:bg-sky-500 text-white text-xs font-bold rounded-xl transition-all shadow-md">
                <i class="fa-solid fa-file-contract mr-1.5"></i> Lihat Rekap Laporan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-400 font-bold uppercase text-[11px] tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Peringkat</th>
                        <th class="px-6 py-4">Kode & Nama Pelamar</th>
                        <th class="px-6 py-4 text-center">Skor SMART (70%)</th>
                        <th class="px-6 py-4 text-center">Skor SWOT (30%)</th>
                        <th class="px-6 py-4 text-center">Skor Akhir (%)</th>
                        <th class="px-6 py-4 text-center">Kuadran Strategi</th>
                        <th class="px-6 py-4 text-center">Status Keputusan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($calculationData['results'] as $res)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4 font-black text-slate-800 text-base">
                            #{{ $res['rank'] }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-extrabold text-slate-800">{{ $res['candidate']->name }}</div>
                            <div class="text-xs text-slate-400 font-mono">{{ $res['candidate']->code }}</div>
                        </td>
                        <td class="px-6 py-4 text-center font-mono font-bold text-slate-700">
                            {{ sprintf('%.4f', $res['smart_score']) }} ({{ $res['smart_score_pct'] }}%)
                        </td>
                        <td class="px-6 py-4 text-center font-mono font-bold text-slate-700">
                            {{ sprintf('%.4f', $res['swot_score']) }} ({{ $res['swot_score_pct'] }}%)
                        </td>
                        <td class="px-6 py-4 text-center font-mono font-black text-sky-600 text-lg">
                            {{ $res['final_score_pct'] }}%
                        </td>
                        <td class="px-6 py-4 text-center font-extrabold text-xs text-slate-700">
                            Kuadran {{ $res['swot']->quadrant }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($res['recommendation_status'] == 'Diterima')
                                <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    DITERIMA
                                </span>
                            @elseif($res['recommendation_status'] == 'Pertimbangan')
                                <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-200">
                                    PERTIMBANGAN
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-rose-100 text-rose-800 border border-rose-200">
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
                    label: 'Koordinat Candidate (IFAS, EFAS)',
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
                                return point.label + ' -> IFAS (X): ' + point.x + ', EFAS (Y): ' + point.y;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        min: -4,
                        max: 4,
                        title: { display: true, text: 'Sumbu X: IFAS (Strengths - Weaknesses)', font: { weight: 'bold', size: 11 } },
                        grid: { color: (ctx) => ctx.tick.value === 0 ? '#0f172a' : '#e2e8f0', lineWidth: (ctx) => ctx.tick.value === 0 ? 2 : 1 }
                    },
                    y: {
                        min: -4,
                        max: 4,
                        title: { display: true, text: 'Sumbu Y: EFAS (Opportunities - Threats)', font: { weight: 'bold', size: 11 } },
                        grid: { color: (ctx) => ctx.tick.value === 0 ? '#0f172a' : '#e2e8f0', lineWidth: (ctx) => ctx.tick.value === 0 ? 2 : 1 }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
