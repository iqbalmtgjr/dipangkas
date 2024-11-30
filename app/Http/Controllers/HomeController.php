<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Mitra;
use App\Models\Grafik;
use App\Models\Pangkas;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        if (auth()->user()->role == 'admin') {
            return redirect('dashboard');
        }
        if (auth()->user()->role == 'admin_mitra') {
            $total_hariini = Pangkas::where('mitra_id', auth()->user()->mitra_id)->whereDate('created_at', date('Y-m-d'))->count();
            $pendapatan_hariini = Pangkas::where('mitra_id', auth()->user()->mitra_id)->whereDate('created_at', date('Y-m-d'))->sum('total_harga');

            $kategori_hariini = [];
            foreach (Kategori::where('mitra_id', auth()->user()->mitra_id)->get() as $kategori) {
                $kategori_hariini[$kategori->id] = Pangkas::where('mitra_id', auth()->user()->mitra_id)->whereDate('created_at', date('Y-m-d'))->where('kategori_id', $kategori->id)->count();
            }
            // dd($kategori_hariini);
            // $dewasa_hariini = Pangkas::where('mitra_id', auth()->user()->mitra_id)->whereDate('created_at', date('Y-m-d'))->where('kategori_id', 1)->count();
            // $anak_hariini = Pangkas::where('mitra_id', auth()->user()->mitra_id)->whereDate('created_at', date('Y-m-d'))->where('kategori_id', 2)->count();
            $pendapatan_seluruh = Pangkas::where('mitra_id', auth()->user()->mitra_id)->sum('total_harga');

            //atur bulan
            $bln = Grafik::where('mitra_id', auth()->user()->mitra_id)->first();
            if ($bln == null) {
                $bln = Grafik::create([
                    'mitra_id' => auth()->user()->mitra_id,
                    'tgl' => date('m'),
                ]);
                $bln = $bln->tgl;
            } else {
                $bln = $bln->tgl;
            }

            // dd($bln);
            $tanggal_awal = Carbon::create(date('Y'), $bln, 1);

            $pangkass = Pangkas::where('mitra_id', auth()->user()->mitra_id)->where('created_at', '>=', $tanggal_awal)
                ->get()
                ->groupBy(function ($pangkas) {
                    return Carbon::parse($pangkas->created_at)->format('d');
                });


            $pendapatan_bulan = Pangkas::where('mitra_id', auth()->user()->mitra_id)->where('created_at', '>=', $tanggal_awal)->sum('total_harga');

            //grafik
            $tanggal = $pangkass->map(function ($tanggal) {
                return [
                    'tanggal' => $tanggal->first()->created_at->format('d F Y'),
                ];
            })->values();
            $tanggal = json_encode($tanggal->pluck('tanggal'));

            $total_perhari = $pangkass->map(function ($item) {
                return $item->count();
            })->values();
            $total_perhari = json_encode($total_perhari);
        } else {
            $total_hariini = Pangkas::where('mitra_id', auth()->user()->mitra_id)->where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->count();
            $pendapatan_hariini = Pangkas::where('mitra_id', auth()->user()->mitra_id)->where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->sum('total_harga');
            // foreach (Kategori::where('mitra_id', auth()->user()->mitra_id)->get() as $kategori) {
            //     $kategori->kategori . ' ' . $pendapatan_hariini = Pangkas::where('mitra_id', auth()->user()->mitra_id)->where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->where('kategori_id', $kategori->id)->count();
            // }

            $kategori_hariini = [];
            foreach (Kategori::where('mitra_id', auth()->user()->mitra_id)->get() as $kategori) {
                $kategori_hariini[$kategori->id] = Pangkas::where('mitra_id', auth()->user()->mitra_id)->where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->where('kategori_id', $kategori->id)->count();
            }
            // $dewasa_hariini = Pangkas::where('mitra_id', auth()->user()->mitra_id)->where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->where('kategori_id', 1)->count();
            // $anak_hariini = Pangkas::where('mitra_id', auth()->user()->mitra_id)->where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->where('kategori_id', 2)->count();

            $pendapatan_seluruh = Pangkas::where('mitra_id', auth()->user()->mitra_id)->where('user_id', auth()->user()->id)->sum('total_harga');

            //grafik
            // $tanggal_awal = Carbon::now()->firstOfMonth()->format('Y-m-d');
            $bln = Grafik::where('mitra_id', auth()->user()->mitra_id)->first();
            if ($bln == null) {
                $bln = Grafik::create([
                    'mitra_id' => auth()->user()->mitra_id,
                    'tgl' => date('m'),
                ]);
                $bln = $bln->tgl;
            } else {
                $bln = $bln->tgl;
            }

            // dd($bln);
            $tanggal_awal = Carbon::create(date('Y'), $bln, 1);
            // dd($tanggal_awal);

            $pangkass = Pangkas::where('mitra_id', auth()->user()->mitra_id)->where('user_id', auth()->user()->id)->where('created_at', '>=', $tanggal_awal)
                ->get()
                ->groupBy(function ($pangkas) {
                    return Carbon::parse($pangkas->created_at)->format('d');
                });


            $pendapatan_bulan = Pangkas::where('mitra_id', auth()->user()->mitra_id)->where('user_id', auth()->user()->id)->where('created_at', '>=', $tanggal_awal)->sum('total_harga');

            $tanggal = $pangkass->map(function ($tanggal) {
                return [
                    'tanggal' => $tanggal->first()->created_at->format('d F Y'),
                ];
            })->values();
            $tanggal = json_encode($tanggal->pluck('tanggal'));
            // dd($tanggal);

            $total_perhari = $pangkass->map(function ($item) {
                return $item->count();
            })->values();
            $total_perhari = json_encode($total_perhari);
        }

        // dd($tanggal);


        return view('home', compact('bln', 'total_hariini', 'pendapatan_hariini', 'kategori_hariini', 'tanggal', 'total_perhari', 'pendapatan_bulan', 'pendapatan_seluruh'));
    }

    public function index2()
    {
        $mitra = Mitra::all();
        $users = User::where('id', '!=', 1)->get();
        $pendapatan_mitra = Pangkas::avg('total_harga');
        $reratawaktu_pengunjung = (new DateTime())->setTimestamp(Pangkas::avg('created_at'))->format('H:i');
        return view('home2', compact('mitra', 'users', 'pendapatan_mitra', 'reratawaktu_pengunjung'));
    }

    public function update(Request $request)
    {
        $bln = Grafik::find(1)->tgl;
        if ($request->has('bulan')) {
            if ($bln == 12) {
                $bulan_depan = 1;
            } else {
                $bulan_depan = $bln + 1;
            }
            Grafik::find(1)->update([
                'tgl' => $bulan_depan
            ]);
        }
        return redirect('home');
    }
}
