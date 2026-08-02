@extends('layouts.app')

@section('title', 'Kelola Pengguna - Sentra Niaga Bekasi')
@section('header_title', 'Kelola Data Pengguna Sistem')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action Bar -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-800">Daftar Pengguna Sistem</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola akses akun admin dan HRD yang menggunakan sistem</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-3 w-full md:w-auto">
            <a href="{{ route('users.create') }}" 
               class="w-full sm:w-auto px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-sky-600/30 transition-all flex items-center justify-center">
                <i class="fa-solid fa-user-plus mr-2"></i> Tambah Pengguna
            </a>
        </div>
    </div>

    <!-- Users List Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-sm text-slate-600 min-w-max border-collapse">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[11px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-4 whitespace-nowrap">Nama & Email</th>
                        <th class="px-5 py-4 whitespace-nowrap text-center">Hak Akses (Role)</th>
                        <th class="px-5 py-4 whitespace-nowrap text-center">Tgl Terdaftar</th>
                        <th class="px-5 py-4 whitespace-nowrap text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 font-black flex items-center justify-center text-sm flex-shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-extrabold text-slate-800 text-sm whitespace-nowrap">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-400 whitespace-nowrap">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-center">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1 text-xs font-extrabold rounded-full border bg-indigo-100 text-indigo-800 border-indigo-300 uppercase">
                                    Admin
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1 text-xs font-extrabold rounded-full border bg-emerald-100 text-emerald-800 border-emerald-300 uppercase">
                                    HRD
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-center text-xs text-slate-500 font-semibold">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center space-x-2" x-data="{ openDelete: false }">
                                <a href="{{ route('users.edit', $user->id) }}" 
                                   class="p-2 text-slate-600 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors" title="Edit Pengguna">
                                    <i class="fa-solid fa-pen-to-square text-base"></i>
                                </a>

                                <button @click="openDelete = true" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Pengguna">
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
                                        <h3 class="text-base font-extrabold text-slate-800 mb-1">Konfirmasi Hapus Akun</h3>
                                        <p class="text-xs text-slate-500 mb-4">Apakah Anda yakin ingin menghapus pengguna <strong>{{ $user->name }}</strong>? Aksi ini tidak dapat dibatalkan.</p>

                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="flex justify-end space-x-2">
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
                        <td colspan="4" class="text-center py-12 text-slate-400 font-semibold">
                            Belum ada data pengguna selain Anda.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
