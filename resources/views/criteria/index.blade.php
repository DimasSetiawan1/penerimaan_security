@extends('layouts.app')

@section('title', 'Data Kriteria (SMART) - Sentra Niaga Bekasi')
@section('header_title', 'Manajemen Kriteria & Sub-Kriteria (Metode SMART)')

@section('content')
<div class="space-y-8">
    
    <!-- Title Info Card -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-800">Daftar Kriteria & Bobot SMART</h1>
            <p class="text-xs text-slate-500 mt-1">
                Kriteria penilaian penerimaan security pada Perkantoran Sentra Niaga Bekasi beserta skala utilitas 1–5.
            </p>
        </div>
        <div class="flex items-center space-x-2 bg-sky-50 text-sky-800 px-4 py-2 rounded-xl text-xs font-bold border border-sky-200">
            <i class="fa-solid fa-scale-balanced text-sm text-sky-600"></i>
            <span>Total Bobot Asli: <strong>{{ $totalWeight }}</strong> | Normalisasi $\sum w_j = 1.0$</span>
        </div>
    </div>

    <!-- Criteria Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h2 class="text-base font-extrabold text-slate-800">Matriks Kriteria Utama</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-400 font-bold uppercase text-[11px] tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Kode</th>
                        <th class="px-6 py-4">Nama Kriteria</th>
                        <th class="px-6 py-4 text-center">Sifat (Type)</th>
                        <th class="px-6 py-4 text-center">Bobot Asli ($W_j$)</th>
                        <th class="px-6 py-4 text-center">Normalisasi ($w_j$)</th>
                        <th class="px-6 py-4 text-center">Skala Min-Max</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($criterias as $crit)
                    @php
                        $normWeight = $totalWeight > 0 ? round($crit->weight / $totalWeight, 4) : 0;
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors" x-data="{ openEdit: false }">
                        <td class="px-6 py-4 font-black text-sky-600 text-base">
                            {{ $crit->code }}
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-800">
                            {{ $crit->name }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-full text-xs font-extrabold">
                                {{ strtoupper($crit->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center font-extrabold text-slate-800 text-base">
                            {{ $crit->weight }}
                        </td>
                        <td class="px-6 py-4 text-center font-mono font-bold text-sky-700">
                            {{ $normWeight }} ({{ round($normWeight * 100, 1) }}%)
                        </td>
                        <td class="px-6 py-4 text-center text-xs font-semibold text-slate-500">
                            {{ $crit->min_val }} s/d {{ $crit->max_val }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button @click="openEdit = true" class="px-3 py-1.5 bg-sky-50 hover:bg-sky-100 text-sky-700 rounded-lg text-xs font-bold border border-sky-200 transition-colors">
                                <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Bobot
                            </button>

                            <!-- Modal Edit Bobot -->
                            <div x-show="openEdit" 
                                 class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-sm"
                                 x-cloak style="display: none;">
                                <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl text-left border border-slate-200" @click.away="openEdit = false">
                                    <h3 class="text-base font-extrabold text-slate-800 mb-2">Edit Bobot Kriteria {{ $crit->code }}</h3>
                                    <p class="text-xs text-slate-500 mb-4">{{ $crit->name }}</p>

                                    <form action="{{ route('criteria.updateWeight', $crit->id) }}" method="POST" class="space-y-4">
                                        @csrf
                                        @method('PUT')

                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nilai Bobot Asli ($W_j$)</label>
                                            <input type="number" step="1" name="weight" min="1" max="100" value="{{ $crit->weight }}" required
                                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-sky-500">
                                        </div>

                                        <div class="flex justify-end space-x-2 pt-2">
                                            <button type="button" @click="openEdit = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold">
                                                Batal
                                            </button>
                                            <button type="submit" class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-xs font-bold shadow-md shadow-sky-600/30">
                                                Simpan Bobot
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sub-Criteria Details Section -->
    <div class="space-y-6">
        <h2 class="text-lg font-extrabold text-slate-800">Detail Sub-Kriteria & Skala Utilitas (1 - 5)</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($criterias as $crit)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <span class="inline-block px-2.5 py-1 bg-sky-100 text-sky-800 rounded-lg text-xs font-black mr-2">
                            {{ $crit->code }}
                        </span>
                        <span class="font-extrabold text-slate-800 text-base">{{ $crit->name }}</span>
                    </div>
                    <span class="text-xs font-bold text-slate-400">Bobot: {{ $crit->weight }}</span>
                </div>

                <div class="space-y-2">
                    @foreach($crit->subCriterias as $sub)
                    @php
                        // Utility calculation: u_i = (val - 1) / (5 - 1)
                        $utilityVal = round(($sub->value - 1) / 4, 2);
                    @endphp
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80 flex items-start justify-between gap-3 hover:bg-slate-100/80 transition-colors">
                        <div class="flex items-start space-x-3">
                            <span class="flex-shrink-0 w-7 h-7 rounded-lg bg-slate-800 text-white font-black text-xs flex items-center justify-center">
                                {{ $sub->value }}
                            </span>
                            <div>
                                <p class="text-xs font-bold text-slate-800">{{ $sub->description }}</p>
                                <p class="text-[10px] text-slate-400 font-semibold mt-0.5">Nilai Utilitas SMART: <span class="text-sky-600 font-bold">$u_i = {{ $utilityVal }}</span></p>
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
