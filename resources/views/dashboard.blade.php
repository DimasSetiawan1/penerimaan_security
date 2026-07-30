@extends('layouts.app')

@section('title', 'Dashboard - Sentra Niaga Bekasi')
@section('header_title', 'Dashboard Overview & Statistik Seleksi Security')

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Header Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-sky-950 to-slate-900 p-8 text-white shadow-xl border border-slate-800">
        <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center space-x-2 px-3 py-1 bg-sky-500/20 text-sky-300 border border-sky-500/30 rounded-full text-xs font-semibold">
                    <i class="fa-solid fa-building-user text-xs"></i>
                    <span>Perkantoran Sentra Niaga Bekasi</span>
                </div>
                <h1 class="text-2xl lg:text-3xl font-black tracking-tight">Selamat Datang, {{ Auth::user()->name }} 👋</h1>
                <p class="text-slate-300 text-sm leading-relaxed">
                    Sistem Penilaian Kelayakan & Seleksi Penerimaan Anggota Security berbasis evaluasi terstruktur dan transparan.
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('candidates.create') }}" class="px-5 py-3 bg-sky-500 hover:bg-sky-400 text-white text-xs font-bold rounded-xl shadow-lg shadow-sky-500/30 transition-all flex items-center">
                    <i class="fa-solid fa-user-plus mr-2"></i> Tambah Pelamar Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Metric KPI Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Stat Card 1 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pelamar</p>
                    <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $totalCandidates }}</h3>
                    <p class="text-xs font-semibold text-slate-500 mt-1">Kandidat Terdaftar</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center border border-sky-100">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Evaluasi Selesai</p>
                    <h3 class="text-3xl font-black text-emerald-600 mt-1">{{ $evaluatedCount }}</h3>
                    <p class="text-xs font-semibold text-emerald-700 mt-1">Telah Dievaluasi</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                    <i class="fa-solid fa-user-check text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Diterima</p>
                    <h3 class="text-3xl font-black text-sky-600 mt-1">{{ $statusCount['Diterima'] ?? 0 }}</h3>
                    <p class="text-xs font-semibold text-sky-700 mt-1">Skor Kelayakan &ge; 75%</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center border border-sky-100">
                    <i class="fa-solid fa-award text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Indikator Penilaian</p>
                    <h3 class="text-3xl font-black text-indigo-600 mt-1">{{ $totalCriterias }}</h3>
                    <p class="text-xs font-semibold text-indigo-700 mt-1">4 Kriteria Utama (Benefit)</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100">
                    <i class="fa-solid fa-sliders text-xl"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Chart 1: Top Candidate Ranking Bar Chart -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-extrabold text-slate-800">Grafik Peringkat Kelayakan Pelamar</h3>
                    <p class="text-xs text-slate-500">Skor Akhir Evaluasi Kelayakan (%)</p>
                </div>
            </div>
            <div class="h-64">
                <canvas id="rankingChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: SWOT Quadrant Distribution Doughnut Chart -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-extrabold text-slate-800">Distribusi Kategori Kualifikasi</h3>
                    <span class="text-xs font-bold text-slate-400 uppercase">Kualifikasi</span>
                </div>
                <div class="h-56 relative flex items-center justify-center">
                    <canvas id="swotChart"></canvas>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 mt-4 text-xs font-semibold pt-4 border-t border-slate-100">
                <div class="flex items-center text-emerald-700">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 mr-2"></span> Sangat Layak: {{ $quadrantsCount['SO'] }}
                </div>
                <div class="flex items-center text-emerald-600">
                    <span class="w-3 h-3 rounded-full bg-emerald-400 mr-2"></span> Layak: {{ $quadrantsCount['ST'] }}
                </div>
                <div class="flex items-center text-amber-700">
                    <span class="w-3 h-3 rounded-full bg-amber-500 mr-2"></span> Pertimbangan: {{ $quadrantsCount['WO'] }}
                </div>
                <div class="flex items-center text-rose-700">
                    <span class="w-3 h-3 rounded-full bg-rose-500 mr-2"></span> Tidak Layak: {{ $quadrantsCount['WT'] }}
                </div>
            </div>
        </div>

    </div>

    <!-- Top Ranking Candidates Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-extrabold text-slate-800">5 Pelamar Teratas (Rekomendasi Terbaik)</h3>
                <p class="text-xs text-slate-500">Urutan peringkat berdasarkan hasil evaluasi kelayakan penerimaan security</p>
            </div>
            <a href="{{ route('reports.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors">
                <i class="fa-solid fa-file-export mr-1.5"></i> Lihat Semua & Cetak Laporan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-400 font-bold uppercase text-[11px] tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Peringkat</th>
                        <th class="px-6 py-4">Kode & Nama Pelamar</th>
                        <th class="px-6 py-4 text-center">Skor Indikator</th>
                        <th class="px-6 py-4 text-center">Skor Potensi</th>
                        <th class="px-6 py-4 text-center">Kualifikasi Profil</th>
                        <th class="px-6 py-4 text-center">Skor Kelayakan (%)</th>
                        <th class="px-6 py-4 text-center">Keputusan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($topResults as $res)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4 font-black text-slate-800">
                            @if($res->rank == 1)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 text-amber-600 font-black shadow-sm">
                                    <i class="fa-solid fa-trophy text-sm"></i>
                                </span>
                            @elseif($res->rank == 2)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-200 text-slate-700 font-black">
                                    2
                                </span>
                            @elseif($res->rank == 3)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-800/10 text-amber-800 font-black">
                                    3
                                </span>
                            @else
                                <span class="pl-3 font-bold text-slate-500">#{{ $res->rank }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $res->candidate->name }}</div>
                            <div class="text-xs text-slate-400 font-mono">{{ $res->candidate->code }} • {{ $res->candidate->phone ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-slate-700">
                            {{ round($res->smart_score * 100, 2) }}%
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-slate-700">
                            {{ round($res->swot_score * 100, 2) }}%
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $quad = $res->candidate->swotEvaluation->quadrant ?? 'SO';
                                $quadLabel = match($quad) {
                                    'SO' => 'Sangat Layak',
                                    'ST' => 'Layak',
                                    'WO' => 'Pertimbangan',
                                    'WT' => 'Tidak Layak',
                                    default => '-'
                                };
                                $badgeClass = match($quad) {
                                    'SO' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                    'ST' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'WO' => 'bg-amber-100 text-amber-800 border-amber-200',
                                    'WT' => 'bg-rose-100 text-rose-800 border-rose-200',
                                    default => 'bg-slate-100 text-slate-800'
                                };
                            @endphp
                            <span class="inline-block px-2.5 py-1 text-xs font-black rounded-lg border {{ $badgeClass }}">
                                {{ $quadLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center font-black text-sky-600 text-base">
                            {{ round($res->final_score * 100, 2) }}%
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($res->recommendation_status == 'Diterima')
                                <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    <i class="fa-solid fa-circle-check mr-1"></i> DITERIMA
                                </span>
                            @elseif($res->recommendation_status == 'Pertimbangan')
                                <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-200">
                                    <i class="fa-solid fa-clock mr-1"></i> PERTIMBANGAN
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-rose-100 text-rose-800 border border-rose-200">
                                    <i class="fa-solid fa-circle-xmark mr-1"></i> DITOLAK
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-slate-400 font-semibold">Belum ada data hasil evaluasi kandidat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Chart 1: Bar Chart Ranking
        const ctxRanking = document.getElementById('rankingChart').getContext('2d');
        const rankingLabels = {!! json_encode($topResults->pluck('candidate.name')) !!};
        const rankingScores = {!! json_encode($topResults->map(fn($r) => round($r->final_score * 100, 2))) !!};

        new Chart(ctxRanking, {
            type: 'bar',
            data: {
                labels: rankingLabels,
                datasets: [{
                    label: 'Skor Kelayakan (%)',
                    data: rankingScores,
                    backgroundColor: '#0284c7',
                    borderRadius: 8,
                    hoverBackgroundColor: '#0369a1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: { callback: value => value + '%' }
                    }
                }
            }
        });

        // Chart 2: Doughnut Chart SWOT Quadrant
        const ctxSwot = document.getElementById('swotChart').getContext('2d');
        new Chart(ctxSwot, {
            type: 'doughnut',
            data: {
                labels: ['Sangat Layak', 'Layak', 'Pertimbangan', 'Tidak Layak'],
                datasets: [{
                    data: [
                        {{ $quadrantsCount['SO'] }},
                        {{ $quadrantsCount['ST'] }},
                        {{ $quadrantsCount['WO'] }},
                        {{ $quadrantsCount['WT'] }}
                    ],
                    backgroundColor: ['#10b981', '#34d399', '#f59e0b', '#f43f5e'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endpush
@endsection
