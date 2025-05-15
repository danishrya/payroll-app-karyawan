<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class KaryawanpageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawans = Karyawan::paginate(10);
        return view('admin.karyawan.index', ['karyawans' => $karyawans]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:karyawans',
            'password' => 'required|string|min:8|confirmed',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'join_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'phone' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'karyawan'; // Default role for new employees

        Karyawan::create($validated);

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:karyawans,email,'.$karyawan->id,
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'join_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'phone' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        // Only update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $karyawan->update($validated);

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        if (Auth::user()->id == $karyawan->id) {
                    return redirect()->route('admin.karyawan.index')
                        ->with('error', 'Anda tidak dapat menghapus akun anda sendiri.');
                }

        $karyawan->delete();

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}