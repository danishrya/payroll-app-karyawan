@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Detail Karyawan: ') }} {{ $karyawan->user->name }}
    </h2>
@endsection

@section('slot')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Data Akun User -->
                <div class="border-b border-gray-200 pb-5 mb-5">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Data Akun User</h3>
                    <dl class="mt-2 divide-y divide-gray-200">
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $karyawan->user->name }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $karyawan->user->email }}</dd>
                        </div>
                         <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Role</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ Str::title($karyawan->user->role) }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Terdaftar Sejak</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $karyawan->user->created_at->format('d M Y, H:i') }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Data Detail Karyawan -->
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Data Detail Karyawan</h3>
                     <dl class="mt-2 divide-y divide-gray-200">
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">NIK</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $karyawan->nik ?? '-' }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $karyawan->no_telepon ?? '-' }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $karyawan->alamat ?? '-' }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Posisi</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $karyawan->posisi }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Tanggal Masuk</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $karyawan->tanggal_masuk->format('d M Y') }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Gaji Pokok</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Rp {{ number_format($karyawan->gaji_pokok, 2, ',', '.') }}</dd>
                        </div>
                         <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Data Dibuat Pada</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $karyawan->created_at->format('d M Y, H:i') }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">Terakhir Diperbarui</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $karyawan->updated_at->format('d M Y, H:i') }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-200">
                    <div class="flex justify-end">
                        <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                            Edit Karyawan
                        </a>
                        <a href="{{ route('admin.karyawan.index') }}" class="ml-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection