<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GajiAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Gaji::with('karyawan.user');
         if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->where('bulan', $request->bulan)->where('tahun', $request->tahun);
        }
        $gajis = $query->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->paginate(10);
        return view('admin.gaji.index', compact('gajis'));
    }

    public function formHitung()
    {
        return view('admin.gaji.form_hitung');
    }

    public function prosesHitung(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:'.(date('Y')-5).'|max:'.date('Y'),
            'potongan_per_alpha' => 'required|numeric|min:0', // Contoh potongan
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $potongan_per_alpha = $request->potongan_per_alpha;

        $karyawans = Karyawan::all();
        $gajiGeneratedCount = 0;

        foreach ($karyawans as $karyawan) {
            $absensiBulanIni = Absensi::where('karyawan_id', $karyawan->id)
                                    ->whereMonth('tanggal', $bulan)
                                    ->whereYear('tanggal', $tahun)
                                    ->get();

            $total_hadir = $absensiBulanIni->where('status', 'hadir')->count();
            $total_izin = $absensiBulanIni->where('status', 'izin')->count();
            $total_sakit = $absensiBulanIni->where('status', 'sakit')->count();
            $total_tanpa_keterangan = $absensiBulanIni->where('status', 'tanpa keterangan')->count();

            // Atau jika 'tanpa keterangan' adalah default saat tidak ada jam masuk/pulang
            // Anda mungkin perlu logika lebih canggih untuk menghitung 'tanpa keterangan'
            // Misalnya, hari kerja dikurangi hadir, izin, sakit.

            $potongan = $total_tanpa_keterangan * $potongan_per_alpha;
            $gaji_bersih = $karyawan->gaji_pokok - $potongan;

            Gaji::updateOrCreate(
                [
                    'karyawan_id' => $karyawan->id,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ],
                [
                    'total_hadir' => $total_hadir,
                    'total_izin' => $total_izin,
                    'total_sakit' => $total_sakit,
                    'total_tanpa_keterangan' => $total_tanpa_keterangan,
                    'gaji_pokok' => $karyawan->gaji_pokok,
                    'potongan' => $potongan,
                    'gaji_bersih' => $gaji_bersih,
                    'keterangan_gaji' => 'Gaji bulan '. Carbon::create()->month($bulan)->translatedFormat('F') .' '. $tahun,
                    'tanggal_pembayaran' => Carbon::now(), // Bisa diatur sesuai kebutuhan
                ]
            );
            $gajiGeneratedCount++;
        }

        return redirect()->route('admin.gaji.index')->with('success', "$gajiGeneratedCount data gaji berhasil dihitung/diperbarui untuk $bulan/$tahun.");
    }
}