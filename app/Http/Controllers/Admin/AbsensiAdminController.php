<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiAdminController extends Controller
{
    public function rekap(Request $request)
    {
        $karyawans = Karyawan::pluck('user_id', 'id')->map(function ($userId) {
            return \App\Models\User::find($userId)->name;
        });

        $query = Absensi::with('karyawan.user');

        if ($request->filled('karyawan_id')) {
            $query->where('karyawan_id', $request->karyawan_id);
        }

        if ($request->filled('bulan') && $request->filled('tahun')) {
            $bulan = $request->bulan;
            $tahun = $request->tahun;
            $query->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
        } else {
            // Default to current month
            $query->whereMonth('tanggal', Carbon::now()->month)->whereYear('tanggal', Carbon::now()->year);
        }

        $absensi = $query->orderBy('tanggal', 'desc')->paginate(15);

        return view('admin.absensi.rekap', compact('absensi', 'karyawans'));
    }
}