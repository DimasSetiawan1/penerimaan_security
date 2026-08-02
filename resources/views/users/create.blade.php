@extends('layouts.app')

@section('title', 'Tambah Pengguna - Sentra Niaga Bekasi')
@section('header_title', 'Tambah Pengguna Sistem')

@section('content')
<div class="max-w-2xl mx-auto space-y-8">
    
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <h1 class="text-xl font-extrabold text-slate-800">Tambah Akun Baru</h1>
            <p class="text-xs text-slate-500 mt-1">Daftarkan akun Admin atau HRD baru ke dalam sistem</p>
        </div>
        <a href="{{ route('users.index') }}" class="p-2.5 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-xl transition-colors border border-slate-200" title="Kembali">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-6 lg:p-8">
        <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Input Nama -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full pl-10 pr-4 py-3 bg-slate-50 border @error('name') border-rose-300 focus:ring-rose-500 @else border-slate-300 focus:ring-sky-500 @enderror rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 transition-shadow"
                           placeholder="Masukkan nama lengkap pengguna">
                    <i class="fa-solid fa-user absolute left-4 top-3.5 text-slate-400"></i>
                </div>
                @error('name')
                <p class="mt-1.5 text-xs text-rose-500 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Email -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 mb-2">Alamat Email <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full pl-10 pr-4 py-3 bg-slate-50 border @error('email') border-rose-300 focus:ring-rose-500 @else border-slate-300 focus:ring-sky-500 @enderror rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 transition-shadow"
                           placeholder="admin@sentraniaga.com">
                    <i class="fa-solid fa-envelope absolute left-4 top-3.5 text-slate-400"></i>
                </div>
                @error('email')
                <p class="mt-1.5 text-xs text-rose-500 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Role -->
            <div>
                <label for="role" class="block text-xs font-bold text-slate-700 mb-2">Hak Akses (Role) <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <select name="role" id="role" required
                            class="w-full pl-10 pr-10 py-3 bg-slate-50 border @error('role') border-rose-300 focus:ring-rose-500 @else border-slate-300 focus:ring-sky-500 @enderror rounded-xl text-sm font-semibold text-slate-800 focus:outline-none focus:ring-2 transition-shadow appearance-none cursor-pointer">
                        <option value="" disabled selected>Pilih hak akses...</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator (Akses Penuh)</option>
                        <option value="hrd" {{ old('role') == 'hrd' ? 'selected' : '' }}>Tim HRD (Kelola Pelamar & Evaluasi)</option>
                    </select>
                    <i class="fa-solid fa-id-badge absolute left-4 top-3.5 text-slate-400"></i>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-3.5 text-slate-400 text-xs pointer-events-none"></i>
                </div>
                @error('role')
                <p class="mt-1.5 text-xs text-rose-500 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Input Password -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 mb-2">Kata Sandi (Password) <span class="text-rose-500">*</span></label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" name="password" id="password" required
                               class="w-full pl-10 pr-10 py-3 bg-slate-50 border @error('password') border-rose-300 focus:ring-rose-500 @else border-slate-300 focus:ring-sky-500 @enderror rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 transition-shadow"
                               placeholder="Minimal 6 karakter">
                        <i class="fa-solid fa-lock absolute left-4 top-3.5 text-slate-400"></i>
                        <button type="button" @click="show = !show" class="absolute right-4 top-3.5 text-slate-400 hover:text-slate-600 focus:outline-none">
                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                    <p class="mt-1.5 text-xs text-rose-500 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-2">Konfirmasi Sandi <span class="text-rose-500">*</span></label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" required
                               class="w-full pl-10 pr-10 py-3 bg-slate-50 border border-slate-300 focus:ring-sky-500 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 transition-shadow"
                               placeholder="Ulangi sandi baru">
                        <i class="fa-solid fa-lock absolute left-4 top-3.5 text-slate-400"></i>
                        <button type="button" @click="show = !show" class="absolute right-4 top-3.5 text-slate-400 hover:text-slate-600 focus:outline-none">
                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 flex items-center justify-end space-x-3 border-t border-slate-100">
                <a href="{{ route('users.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-sky-600/30 transition-all flex items-center justify-center">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
