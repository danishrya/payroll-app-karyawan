<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class KaryawanCrudController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::with('user')->paginate(10);
        return view('admin.karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('admin.karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nik' => ['nullable', 'string', 'max:20', 'unique:'.Karyawan::class],
            'alamat' => ['nullable', 'string'],
            'no_telepon' => ['nullable', 'string', 'max:15'],
            'posisi' => ['required', 'string', 'max:100'],
            'tanggal_masuk' => ['required', 'date'],
            'gaji_pokok' => ['required', 'numeric', 'min:0'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'karyawan',
        ]);

        Karyawan::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'posisi' => $request->posisi,
            'tanggal_masuk' => $request->tanggal_masuk,
            'gaji_pokok' => $request->gaji_pokok,
        ]);

        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function show(Karyawan $karyawan)
    {
        $karyawan->load('user');
        return view('admin.karyawan.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan)
    {
        $karyawan->load('user');
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
         $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email,'.$karyawan->user_id],
            'nik' => ['nullable', 'string', 'max:20', 'unique:'.Karyawan::class.',nik,'.$karyawan->id],
            'alamat' => ['nullable', 'string'],
            'no_telepon' => ['nullable', 'string', 'max:15'],
            'posisi' => ['required', 'string', 'max:100'],
            'tanggal_masuk' => ['required', 'date'],
            'gaji_pokok' => ['required', 'numeric', 'min:0'],
        ]);

        $karyawan->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => ['confirmed', Rules\Password::defaults()]]);
            $karyawan->user->update(['password' => Hash::make($request->password)]);
        }

        $karyawan->update([
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'posisi' => $request->posisi,
            'tanggal_masuk' => $request->tanggal_masuk,
            'gaji_pokok' => $request->gaji_pokok,
        ]);

        return redirect()->route('admin.karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        // User akan terhapus otomatis karena onDelete('cascade') di migrasi karyawan
        // Atau bisa dihapus manual: $karyawan->user()->delete();
        $karyawan->delete();
        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}