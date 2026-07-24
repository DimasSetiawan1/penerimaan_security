@extends('layouts.app')

@section('title', 'Tambah Pelamar Security - Sentra Niaga Bekasi')
@section('header_title', 'Form Input Data Kandidat & Penilaian Kriteria/SWOT')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- Header Back Navigation -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-extrabold text-slate-800">Input Data Pelamar Security Baru</h1>
            <p class="text-xs text-slate-500 mt-0.5">Isi biodata, kriteria C1–C4, dan analisis SWOT kandidat</p>
        </div>
        <a href="{{ route('candidates.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors">
            <i class="fa-solid fa-arrow-left mr-1.5"></i> Kembali ke Daftar
        </a>
    </div>

    <form action="{{ route('candidates.store') }}" method="POST" class="space-y-8">
        @csrf

        <!-- Section 1: Biodata Kandidat -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-3 flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-sm">1</div>
                <h2 class="text-base font-extrabold text-slate-800">Biodata Pelamar Security</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kode Kandidat</label>
                    <input type="text" name="code" value="{{ old('code', $nextCode) }}" required
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 font-extrabold text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                    @error('code')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" name="nik" value="{{ old('nik') }}" placeholder="e.g. 327501..."
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                    @error('nik')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama pelamar security"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-sky-500">
                    @error('name')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jenis Kelamin</label>
                    <select name="gender" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor HP / WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="0812..."
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Domisili</label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Alamat tinggal di Bekasi"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
            </div>
        </div>

        <!-- Section 2: Penilaian Kriteria SMART (C1 - C4) -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-3 flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-sm">2</div>
                <div>
                    <h2 class="text-base font-extrabold text-slate-800">Penilaian Kriteria SMART (C1 — C4)</h2>
                    <p class="text-xs text-slate-500">Pilih opsi sub-kriteria yang paling sesuai dengan kondisi fisik & kualifikasi kandidat</p>
                </div>
            </div>

            <div class="space-y-6">
                @foreach($criterias as $crit)
                <div class="p-5 bg-slate-50/70 rounded-2xl border border-slate-200/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-extrabold text-slate-800">
                            <span class="px-2 py-0.5 bg-sky-600 text-white rounded text-xs mr-2">{{ $crit->code }}</span>
                            {{ $crit->name }}
                        </label>
                        <span class="text-xs font-bold text-slate-400">Bobot: {{ $crit->weight }}</span>
                    </div>

                    <select name="scores[{{ $crit->id }}]" required
                            class="w-full px-4 py-3 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-sm">
                        <option value="" disabled selected>-- Pilih Sub-Kriteria Nilai 1 - 5 --</option>
                        @foreach($crit->subCriterias as $sub)
                        <option value="{{ $sub->value }}" {{ old("scores.{$crit->id}") == $sub->value ? 'selected' : '' }}>
                            Nilai {{ $sub->value }} — {{ $sub->description }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Section 3: Analisis Faktor SWOT (Internal & Eksternal) -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-3 flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm">3</div>
                <div>
                    <h2 class="text-base font-extrabold text-slate-800">Analisis Faktor SWOT (Skorsing 1.0 — 5.0)</h2>
                    <p class="text-xs text-slate-500">Nilai indikator kekuatan, kelemahan, peluang, dan ancaman pelamar</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Strengths -->
                <div class="p-4 bg-emerald-50/50 rounded-2xl border border-emerald-200/80 space-y-2">
                    <label class="block text-xs font-extrabold text-emerald-800 uppercase tracking-wider">
                        <i class="fa-solid fa-dumbbell text-emerald-600 mr-1.5"></i> Strengths (Kekuatan)
                    </label>
                    <p class="text-[11px] text-slate-500">Disiplin, postur tubuh ideal, ketegasan, komunikasi.</p>
                    <input type="number" step="0.1" name="strengths_score" min="1" max="5" value="{{ old('strengths_score', 4.0) }}" required
                           class="w-full px-4 py-2.5 bg-white border border-emerald-300 rounded-xl text-slate-800 font-bold text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Weaknesses -->
                <div class="p-4 bg-rose-50/50 rounded-2xl border border-rose-200/80 space-y-2">
                    <label class="block text-xs font-extrabold text-rose-800 uppercase tracking-wider">
                        <i class="fa-solid fa-triangle-exclamation text-rose-600 mr-1.5"></i> Weaknesses (Kelemahan)
                    </label>
                    <p class="text-[11px] text-slate-500">Kurang penguasaan K3/Bahasa Inggris/Komputer.</p>
                    <input type="number" step="0.1" name="weaknesses_score" min="1" max="5" value="{{ old('weaknesses_score', 2.0) }}" required
                           class="w-full px-4 py-2.5 bg-white border border-rose-300 rounded-xl text-slate-800 font-bold text-sm focus:outline-none focus:ring-2 focus:ring-rose-500">
                </div>

                <!-- Opportunities -->
                <div class="p-4 bg-sky-50/50 rounded-2xl border border-sky-200/80 space-y-2">
                    <label class="block text-xs font-extrabold text-sky-800 uppercase tracking-wider">
                        <i class="fa-solid fa-chart-line text-sky-600 mr-1.5"></i> Opportunities (Peluang)
                    </label>
                    <p class="text-[11px] text-slate-500">Peluang pelatihan sertifikasi Gada Pratama/pengembangan.</p>
                    <input type="number" step="0.1" name="opportunities_score" min="1" max="5" value="{{ old('opportunities_score', 4.0) }}" required
                           class="w-full px-4 py-2.5 bg-white border border-sky-300 rounded-xl text-slate-800 font-bold text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>

                <!-- Threats -->
                <div class="p-4 bg-amber-50/50 rounded-2xl border border-amber-200/80 space-y-2">
                    <label class="block text-xs font-extrabold text-amber-800 uppercase tracking-wider">
                        <i class="fa-solid fa-shield-cat text-amber-600 mr-1.5"></i> Threats (Ancaman)
                    </label>
                    <p class="text-[11px] text-slate-500">Tingkat persaingan tinggi / risiko shift malam berlebihan.</p>
                    <input type="number" step="0.1" name="threats_score" min="1" max="5" value="{{ old('threats_score', 2.0) }}" required
                           class="w-full px-4 py-2.5 bg-white border border-amber-300 rounded-xl text-slate-800 font-bold text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('candidates.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-sky-600/30 transition-all flex items-center">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan & Hitung Keputusan
            </button>
        </div>
    </form>

</div>
@endsection
