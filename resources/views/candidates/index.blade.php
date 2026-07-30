@extends('layouts.app')

@section('title', 'Data Pelamar & Evaluasi - Sentra Niaga Bekasi')
@section('header_title', 'Kelola Data Pelamar Security & Evaluasi Penilaian')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action Bar & Filter -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-800">Data Pelamar & Evaluasi Penilaian</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar pelamar security yang terdaftar dalam sistem seleksi</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-3 w-full md:w-auto">
            <!-- Search Form -->
            <form action="{{ route('candidates.index') }}" method="GET" class="relative w-full sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, kode..."
                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
            </form>

            <a href="{{ route('candidates.create') }}" 
               class="w-full sm:w-auto px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-sky-600/30 transition-all flex items-center justify-center">
                <i class="fa-solid fa-user-plus mr-2"></i> Tambah Pelamar Baru
            </a>
        </div>
    </div>

    <!-- Candidate List Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-sm text-slate-600 min-w-max border-collapse">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[11px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-4 whitespace-nowrap">Kode & Pelamar</th>
                        <th class="px-4 py-4 whitespace-nowrap text-center">Integritas</th>
                        <th class="px-4 py-4 whitespace-nowrap text-center">Kesehatan Fisik</th>
                        <th class="px-4 py-4 whitespace-nowrap text-center">Pengalaman Kerja</th>
                        <th class="px-4 py-4 whitespace-nowrap text-center">Kesiapan Shift</th>
                        <th class="px-5 py-4 whitespace-nowrap text-center">Kualifikasi Profil</th>
                        <th class="px-4 py-4 whitespace-nowrap text-center">Nilai Indikator</th>
                        <th class="px-4 py-4 whitespace-nowrap text-center">Skor Kelayakan</th>
                        <th class="px-5 py-4 whitespace-nowrap text-center">Status Rekomendasi</th>
                        <th class="px-4 py-4 whitespace-nowrap text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($candidates as $cand)
                    @php
                        $scores = $cand->scores->keyBy('criteria_id');
                        $c1 = $scores->get(1)->score_val ?? '-';
                        $c2 = $scores->get(2)->score_val ?? '-';
                        $c3 = $scores->get(3)->score_val ?? '-';
                        $c4 = $scores->get(4)->score_val ?? '-';
                        $res = $cand->calculationResult;
                        $swot = $cand->swotEvaluation;
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-700 font-black flex items-center justify-center text-xs flex-shrink-0">
                                    {{ $cand->code }}
                                </div>
                                <div>
                                    <div class="font-extrabold text-slate-800 text-sm whitespace-nowrap">{{ $cand->name }}</div>
                                    <div class="text-xs text-slate-400 whitespace-nowrap">NIK: {{ $cand->nik ?? '-' }} • {{ $cand->phone ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-center font-bold">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 text-slate-800 font-black text-xs">
                                {{ $c1 }}
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-center font-bold">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 text-slate-800 font-black text-xs">
                                {{ $c2 }}
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-center font-bold">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 text-slate-800 font-black text-xs">
                                {{ $c3 }}
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-center font-bold">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 text-slate-800 font-black text-xs">
                                {{ $c4 }}
                            </span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-center">
                            @if($swot)
                            @php
                                $quad = $swot->quadrant;
                                $quadLabel = match($quad) {
                                    'SO' => 'Sangat Layak',
                                    'ST' => 'Layak',
                                    'WO' => 'Pertimbangan',
                                    'WT' => 'Tidak Layak',
                                    default => '-'
                                };
                                $badgeClass = match($quad) {
                                    'SO' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                    'ST' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'WO' => 'bg-amber-100 text-amber-800 border-amber-300',
                                    'WT' => 'bg-rose-100 text-rose-800 border-rose-300',
                                    default => 'bg-slate-100 text-slate-800 border-slate-200'
                                };
                            @endphp
                            <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1 text-xs font-extrabold rounded-full border {{ $badgeClass }}">
                                {{ $quadLabel }}
                            </span>
                            @else
                            <span class="text-xs text-slate-400 whitespace-nowrap">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-center font-bold text-slate-700">
                            {{ $res ? round($res->smart_score * 100, 2) . '%' : '-' }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-center font-black text-sky-600 text-base">
                            {{ $res ? round($res->final_score * 100, 2) . '%' : '-' }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-center">
                            @if($res)
                                @if($res->recommendation_status == 'Diterima')
                                    <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1 rounded-full text-[11px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        DITERIMA
                                    </span>
                                @elseif($res->recommendation_status == 'Pertimbangan')
                                    <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1 rounded-full text-[11px] font-extrabold bg-amber-100 text-amber-800 border border-amber-300">
                                        PERTIMBANGAN
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1 rounded-full text-[11px] font-extrabold bg-rose-100 text-rose-800 border border-rose-300">
                                        DITOLAK
                                    </span>
                                @endif
                            @else
                                <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-xs font-semibold">Belum Evaluasi</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center space-x-2" x-data="{ openDelete: false }">
                                <a href="{{ route('candidates.edit', $cand->id) }}" 
                                   class="p-2 text-slate-600 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors" title="Edit & Evaluasi">
                                    <i class="fa-solid fa-pen-to-square text-base"></i>
                                </a>

                                <button @click="openDelete = true" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus">
                                    <i class="fa-solid fa-trash-can text-base"></i>
                                </button>

                                <!-- Modal Confirm Delete -->
                                <div x-show="openDelete" 
                                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-sm"
                                     x-cloak style="display: none;">
                                    <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl text-left border border-slate-200" @click.away="openDelete = false">
                                        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mb-4">
                                            <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                                        </div>
                                        <h3 class="text-base font-extrabold text-slate-800 mb-1">Konfirmasi Hapus Data</h3>
                                        <p class="text-xs text-slate-500 mb-4">Apakah Anda yakin ingin menghapus pelamar <strong>{{ $cand->name }}</strong> ({{ $cand->code }})?</p>

                                        <form action="{{ route('candidates.destroy', $cand->id) }}" method="POST" class="flex justify-end space-x-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" @click="openDelete = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold">
                                                Batal
                                            </button>
                                            <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-md shadow-rose-600/30">
                                                Hapus Data
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-12 text-slate-400 font-semibold">
                            Belum ada data pelamar security. Klik tombol "Tambah Pelamar Baru" di atas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($candidates->hasPages())
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $candidates->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
