@php
    use App\Models\Karyawan;
@endphp

@extends('layout.app')

@section('title', 'Admin Dashboard')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin.Dashboard') ?? 'Admin Dashboard' }}
    </h2>
@endsection

@section('slot')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Selamat datang, {{ Auth::user()->name }}! (Admin)
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                    Anda memiliki akses penuh ke sistem pengelolaan karyawan dan penggajian.
                </p>

                @if(session('success'))
                    <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Kelola Karyawan Card -->
                    <a href="{{ route('admin.karyawan.index') }}" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow duration-200">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <!-- Heroicon name: outline/users -->
                                    <svg class="h-8 w-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Kelola Karyawan
                                        </dt>
                                        <dd class="text-xs text-gray-500">
                                            Tambah, lihat, edit, dan hapus data karyawan.
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-5 py-3">
                            <div class="text-sm">
                                <span class="font-medium text-indigo-700 hover:text-indigo-900">
                                    Lihat Selengkapnya →
                                </span>
                            </div>
                        </div>
                    </a>

                    <!-- Rekap Absensi Card -->
                    <a href="{{ route('admin.absensi.rekap') }}" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow duration-200">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <!-- Heroicon name: outline/calendar -->
                                    <svg class="h-8 w-8 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Rekap Absensi
                                        </dt>
                                        <dd class="text-xs text-gray-500">
                                            Lihat rekapitulasi absensi semua karyawan.
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-5 py-3">
                            <div class="text-sm">
                                <span class="font-medium text-green-700 hover:text-green-900">
                                    Lihat Selengkapnya →
                                </span>
                            </div>
                        </div>
                    </a>

                    <!-- Kelola Gaji Card -->
                    <a href="{{ route('admin.gaji.index') }}" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow duration-200">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <!-- Heroicon name: outline/currency-dollar -->
                                    <svg class="h-8 w-8 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Kelola Gaji
                                        </dt>
                                        <dd class="text-xs text-gray-500">
                                            Hitung dan lihat data penggajian karyawan.
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-5 py-3">
                            <div class="text-sm">
                                <span class="font-medium text-purple-700 hover:text-purple-900">
                                    Lihat Selengkapnya →
                                </span>
                            </div>
                        </div>
                    </a>
                </div>

                Anda bisa menambahkan statistik atau informasi lain di sini jika diperlukan 
                
                <div class="mt-10">
                    <h4 class="text-md font-medium text-gray-700">Statistik Cepat (Contoh)</h4>
                    <ul class="mt-3 grid grid-cols-1 gap-5 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        <li class="col-span-1 flex shadow-sm rounded-md">
                            <div class="flex-shrink-0 flex items-center justify-center w-16 bg-pink-600 text-white text-sm font-medium rounded-l-md">
                                {{ \App\Models\Karyawan::count() }}
                            </div>
                            <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                                <div class="flex-1 px-4 py-2 text-sm truncate">
                                    <a href="#" class="text-gray-900 font-medium hover:text-gray-600">Total Karyawan</a>
                                </div>
                            </div>
                        </li>
                        <li class="col-span-1 flex shadow-sm rounded-md">
                            <div class="flex-shrink-0 flex items-center justify-center w-16 bg-purple-600 text-white text-sm font-medium rounded-l-md">
                                {{ \App\Models\Absensi::whereDate('tanggal', today())->whereNotNull('jam_masuk')->count() }}
                            </div>
                            <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-white rounded-r-md truncate">
                                <div class="flex-1 px-4 py-2 text-sm truncate">
                                    <a href="#" class="text-gray-900 font-medium hover:text-gray-600">Hadir Hari Ini</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
               
            </div>
        </div>
    </div>
</div>
@endsection