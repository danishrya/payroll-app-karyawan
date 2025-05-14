<?php
namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Gaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KaryawanPageController extends Controller
{
    public function dashboard()
    {
        $karyawan = Auth::user()->karyawan;
        if (!$karyawan) {
            // Jika user karyawan belum punya data karyawan, redirect atau beri pesan
            return redirect()->route('profile.edit')->with('warning', 'Lengkapi data karyawan Anda terlebih dahulu.');
        }

        $today = Carbon::today();
        $absensiHariIni = Absensi::where('karyawan_id', $karyawan->id)
                                ->whereDate('tanggal', $today)
                                ->first();

        return view('karyawan.dashboard', compact('karyawan', 'absensiHariIni'));
    }

    public function presensiMasuk(Request $request)
    {
        $karyawan = Auth::user()->karyawan;
        $today = Carbon::today();

        $absensiAda = Absensi::where('karyawan_id', $karyawan->id)
                            ->whereDate('tanggal', $today)
                            ->first();

        if ($absensiAda && $absensiAda->jam_masuk) {
            return redirect()->route('karyawan.dashboard')->with('error', 'Anda sudah melakukan presensi masuk hari ini.');
        }

        Absensi::updateOrCreate(
            ['karyawan_id' => $karyawan->id, 'tanggal' => $today],
            ['jam_masuk' => Carbon::now()->format('H:i:s'), 'status' => 'hadir']
        );

        return redirect()->route('karyawan.dashboard')->with('success', 'Presensi masuk berhasil dicatat.');
    }

    public function presensiPulang(Request $request)
    {
        $karyawan = Auth::user()->karyawan;
        $today = Carbon::today();

        $absensi = Absensi::where('karyawan_id', $karyawan->id)
                            ->whereDate('tanggal', $today)
                            ->first();

        if (!$absensi || !$absensi->jam_masuk) {
            return redirect()->route('karyawan.dashboard')->with('error', 'Anda belum melakukan presensi masuk hari ini.');
        }

        if ($absensi->jam_pulang) {
            return redirect()->route('karyawan.dashboard')->with('error', 'Anda sudah melakukan presensi pulang hari ini.');
        }

        $absensi->update(['jam_pulang' => Carbon::now()->format('H:i:s')]);

        return redirect()->route('karyawan.dashboard')->with('success', 'Presensi pulang berhasil dicatat.');
    }

    public function riwayatAbsensi()
    {
        $karyawan = Auth::user()->karyawan;
        $riwayat = Absensi::where('karyawan_id', $karyawan->id)
                            ->orderBy('tanggal', 'desc')
                            ->paginate(10);
        return view('karyawan.riwayat_absensi', compact('riwayat'));
    }

    public function invoiceGaji()
    {
        $karyawan = Auth::user()->karyawan;
        $invoices = Gaji::where('karyawan_id', $karyawan->id)
                        ->orderBy('tahun', 'desc')
                        ->orderBy('bulan', 'desc')
                        ->paginate(10);
        return view('karyawan.invoice_gaji', compact('invoices'));
    }
}