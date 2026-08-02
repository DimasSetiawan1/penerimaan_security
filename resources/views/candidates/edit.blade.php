@extends('layouts.app')

@section('title', 'Edit Pelamar Security - Sentra Niaga Bekasi')
@section('header_title', 'Form Edit Data Pelamar & Evaluasi Kualifikasi')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- Header Back Navigation -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-extrabold text-slate-800">Edit Data Pelamar: {{ $candidate->name }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">Perbarui biodata dan pilihan indikator kualifikasi pelamar</p>
        </div>
        <a href="{{ route('candidates.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors">
            <i class="fa-solid fa-arrow-left mr-1.5"></i> Kembali ke Daftar
        </a>
    </div>

    <form action="{{ route('candidates.update', $candidate->id) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        @php
            $currentScores = $candidate->scores->pluck('score_val', 'criteria_id')->toArray();
        @endphp

        <!-- Section 1: Biodata Pelamar -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-3 flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-sm">1</div>
                <h2 class="text-base font-extrabold text-slate-800">Biodata Pelamar Security</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">NIK <span class="text-rose-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik', $candidate->nik) }}" required minlength="16" maxlength="16" pattern="\d{16}" title="NIK harus tepat 16 digit angka"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                    @error('nik')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $candidate->name) }}" required pattern="[A-Za-z\s]+" title="Nama hanya boleh berisi huruf dan spasi"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-sky-500">
                    @error('name')<p class="text-xs text-rose-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jenis Kelamin</label>
                    <select name="gender" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <option value="L" {{ old('gender', $candidate->gender) == 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ old('gender', $candidate->gender) == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor HP / WhatsApp <span class="text-rose-500">*</span></label>
                    <input type="tel" name="phone" value="{{ old('phone', $candidate->phone) }}" required pattern="\d+" title="Nomor HP hanya boleh berisi angka"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Domisili</label>
                    <input type="text" name="address" value="{{ old('address', $candidate->address) }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
            </div>
        </div>

        <!-- Section 2: Penilaian Indikator Kualifikasi -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-3 flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-sm">2</div>
                <div>
                    <h2 class="text-base font-extrabold text-slate-800">Evaluasi Indikator Penilaian</h2>
                    <p class="text-xs text-slate-500">Pilih opsi indikator yang paling sesuai dengan kualifikasi & dokumen pelamar</p>
                </div>
            </div>

            <div class="space-y-6">
                @foreach($criterias as $crit)
                @php
                    $valNow = $currentScores[$crit->id] ?? 1;
                @endphp
                <div class="p-5 bg-slate-50/70 rounded-2xl border border-slate-200/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-extrabold text-slate-800">
                            {{ $crit->name }}
                        </label>
                        <span class="text-xs font-bold text-slate-400">Bobot Penilaian: {{ $crit->weight }}%</span>
                    </div>

                    <select name="scores[{{ $crit->id }}]" required
                            class="w-full px-4 py-3 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-sm">
                        @foreach($crit->subCriterias as $sub)
                        <option value="{{ $sub->value }}" {{ old("scores.{$crit->id}", $valNow) == $sub->value ? 'selected' : '' }}>
                            Skala {{ $sub->value }} — {{ $sub->description }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('candidates.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-sky-600/30 transition-all flex items-center">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Perbarui & Dievaluasi
            </button>
        </div>
    </form>

</div>
@endsection
