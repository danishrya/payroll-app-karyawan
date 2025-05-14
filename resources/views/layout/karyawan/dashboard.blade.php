@extends('layouts.app') {{-- Menggunakan layout app yang baru --}}

@section('title', 'Dashboard Karyawan') {{-- Judul halaman spesifik --}}

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard Karyawan') }}
    </h2>
@endsection

@section('slot') {{-- Atau 'content' --}}
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-medium">Selamat Datang, {{ Auth::user()->name }}!</h3>
                @if(Auth::user()->karyawan)
                    <p class="mt-1 text-sm text-gray-600">Posisi: {{ Auth::user()->karyawan->posisi ?? 'Belum diatur' }}</p>
                @else
                     <p class="mt-1 text-sm text-yellow-600">Data karyawan Anda belum lengkap. Harap hubungi admin.</p>
                @endif


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
                @if(session('warning'))
                    <div class="mt-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('warning') }}</span>
                    </div>
                @endif

                {{-- Logika Cek Karyawan --}}
                @php
                    $karyawan = Auth::user()->karyawan;
                    $absensiHariIni = null;
                    if($karyawan){
                        $today = \Carbon\Carbon::today();
                        $absensiHariIni = \App\Models\Absensi::where('karyawan_id', $karyawan->id)
                                                    ->whereDate('tanggal', $today)
                                                    ->first();
                    }
                @endphp


                @if($karyawan)
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Presensi Masuk -->
                        <div class="bg-gray-50 p-4 rounded-lg shadow">
                            <h4 class="font-semibold">Presensi Masuk</h4>
                            @if($absensiHariIni && $absensiHariIni->jam_masuk)
                                <p class="text-green-600">Anda sudah presensi masuk hari ini pukul: {{ $absensiHariIni->jam_masuk }}</p>
                            @else
                                <form method="POST" action="{{ route('karyawan.presensi.masuk') }}">
                                    @csrf
                                    <button type="submit" class="mt-2 w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Presensi Masuk Sekarang
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- Presensi Pulang -->
                        <div class="bg-gray-50 p-4 rounded-lg shadow">
                            <h4 class="font-semibold">Presensi Pulang</h4>
                            @if($absensiHariIni && $absensiHariIni->jam_pulang)
                                <p class="text-green-600">Anda sudah presensi pulang hari ini pukul: {{ $absensiHariIni->jam_pulang }}</p>
                            @elseif($absensiHariIni && $absensiHariIni->jam_masuk)
                                <form method="POST" action="{{ route('karyawan.presensi.pulang') }}">
                                    @csrf
                                    <button type="submit" class="mt-2 w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Presensi Pulang Sekarang
                                    </button>
                                </form>
                            @else
                                <p class="text-gray-500">Silakan presensi masuk terlebih dahulu.</p>
                            @endif
                        </div>
                    </div>
                     <div class="mt-8">
                        <a href="{{ route('karyawan.riwayat.absensi') }}" class="text-blue-500 hover:underline">Lihat Riwayat Absensi Saya</a><br>
                        <a href="{{ route('karyawan.invoice.gaji') }}" class="text-blue-500 hover:underline mt-2 inline-block">Lihat Invoice Gaji Saya</a>
                    </div>
                @else
                    <p class="mt-6 text-center text-gray-500">Fitur karyawan tidak tersedia karena data karyawan Anda belum diatur oleh admin.</p>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection