@extends('layouts.admin')

@section('title', 'Kelola User')

@section('content')
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profil Pengguna') }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm font-bold text-orange-600 hover:text-orange-800">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#f8f9fa]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-8 shadow sm:rounded-lg border-l-4 border-orange-500">
                <div class="flex flex-col md:flex-row justify-between gap-6">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 underline decoration-orange-200 underline-offset-8">Informasi Personal</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase">Nama Lengkap</label>
                                <p class="text-lg font-semibold text-gray-800">{{ $user->nama_lengkap }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase">Status Akun</label>
                                <p class="mt-1"><span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase">Aktif</span></p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase">Email</label>
                                <p class="text-gray-700 font-medium">{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase">No. Telepon</label>
                                <p class="text-gray-700 font-medium">{{ $user->no_telepon ?? 'Tidak ada data' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-end gap-3">
                        <div class="bg-red-50 p-4 rounded-lg border border-red-100 text-right">
                            <p class="text-xs text-red-600 font-bold mb-2 uppercase tracking-tighter">Deteksi Spammer?</p>
                            <form action="#" method="POST">
                                @csrf
                                <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow-md transition transform hover:scale-105">
                                    Blokir / Batasi Akun
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 shadow sm:rounded-lg border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Riwayat Laporan Banjir</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-50">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Lokasi Kejadian</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="text-sm">
                                <td class="px-6 py-4 font-mono text-gray-500">#FL-2026-001</td>
                                <td class="px-6 py-4 font-medium text-gray-800">Jl. Embong Malang, Surabaya</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-bold uppercase tracking-widest">Diproses</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
