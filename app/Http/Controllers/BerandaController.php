<?php

namespace App\Http\Controllers;

use App\Charts\QuickQountChart;
use App\Models\Kegiatan;
use App\Models\kandidat;
use App\Models\Suara;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
// use Symfony\Component\HttpFoundation\Session\Session;

class BerandaController extends Controller
{
    public function index()
    {
        $data = Kegiatan::all();
        $data->map(function ($data) {
            $tanggalSekarang = strtotime(date('Y-m-d'));


            $tanggalDari = strtotime($data->tanggal_dari);
            $tanggalSampai = strtotime($data->tanggal_sampai);


            if ($tanggalSekarang < $tanggalDari) {
                $data->status = "Belum Mulai";
            } elseif ($tanggalSekarang >= $tanggalDari && $tanggalSekarang <= $tanggalSampai) {
                $data->status = "Sedang Berlangsung";
            } else {
                $data->status = "Selesai";
            }
        });

        // dd($data);
        return view('beranda.index', [
            'data' => $data
        ]);
    }

    public function login()
    {
        return view('beranda.login');
    }

    public function validasilogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if (Auth::attempt($credentials)) {

            if (auth()->user()->role == 'admin') {
                return redirect()->route('beranda.admin');
            } else {
                return redirect()->route('beranda.index');
            }
        }

        return redirect()->back()->with('error', 'Email dan Password anda salah');
    }

    public function kandidat($id)
    {
        return view('beranda.kandidat', [
            'data' => Kandidat::where('id_kegiatan', $id)->paginate(5),
        ]);
    }

    public function hasil(Request $request)
    {

        $suaraKandidat = null;
        $dataKandidat = null;
        if($request->search)
        {

            $suaraKandidat = Suara::rightJoin('kandidats', 'suaras.id_kandidat', '=', 'kandidats.id')
                ->leftJoin('users', 'suaras.id_user', '=', 'users.id')
                ->leftJoin('kegiatans', 'kegiatans.id', '=', 'kandidats.id_kegiatan')
                ->select('kandidats.nama',  DB::raw('COUNT(suaras.id_kandidat) as jumlah_suara'))
                ->where('kegiatans.id', $request->search)
                ->groupBy('kandidats.nama')
                ->get();
    
            $totalSuara = $suaraKandidat->sum('jumlah_suara');
    
            
            $dataKandidat = [];
    
            foreach ($suaraKandidat as $suara) {
                
                $persentaseSuara = ($suara->jumlah_suara / $totalSuara) * 100;
    
                $dataKandidat[] = [
                    'name' => $suara->nama,
                    'y' => $persentaseSuara
                ];
            }
        }



        // var_dump($t);die;
        // $seriesData = [];

        // // Loop melalui data suara kandidat untuk menyiapkan data series
        // foreach ($suaraKandidat as $suara) {
        //     $namaKandidat = $suara->nama;
        //     $tanggalSuara = $suara->tanggal_suara;
        //     $jumlahSuara = $suara->jumlah_suara;

        //     // Menyiapkan data series berdasarkan hasil query
        //     $seriesData[$namaKandidat][] = [(strtotime($tanggalSuara) * 1000), (int)$jumlahSuara];
        // }


        return view('beranda.hasil', [
            'select' => Kegiatan::all(),
            'data' => $suaraKandidat,
            'hasil' => $dataKandidat
            // 'chart' => $chart->build()
        ]);
    }

    public function admin(Request $request)
    {
        $suaraKandidat = null;
        $dataKandidat = null;
        $total_suara = 'Pilih Kegiatan';
        $total_kandidat = 'Pilih Kegiatan';
        $kegiatan = '';

        if($request->search)
        {

            $suaraKandidat = Suara::rightJoin('kandidats', 'suaras.id_kandidat', '=', 'kandidats.id')
                ->leftJoin('users', 'suaras.id_user', '=', 'users.id')
                ->leftJoin('kegiatans', 'kegiatans.id', '=', 'kandidats.id_kegiatan')
                ->select('kandidats.nama',  DB::raw('COUNT(suaras.id_kandidat) as jumlah_suara'))
                ->where('kegiatans.id', $request->search)
                ->groupBy('kandidats.nama')
                ->get();
    
            $totalSuara = $suaraKandidat->sum('jumlah_suara');
    
            
            $dataKandidat = [];
    
            foreach ($suaraKandidat as $suara) {
                
                $persentaseSuara = ($suara->jumlah_suara / $totalSuara) * 100;
    
                $dataKandidat[] = [
                    'name' => $suara->nama,
                    'y' => $persentaseSuara
                ];
            }
            $total_suara = $totalSuara;
            $total_kandidat = Kandidat::join('kegiatans','kegiatans.id','=','kandidats.id_kegiatan')->where('kegiatans.id',$request->search)->count();
            $dataKegiatan = Kegiatan::where('id',$request->search)->first();
            $kegiatan = $dataKegiatan->kegiatan;
        }

        return view('beranda.dashboard',[
            'data' => $suaraKandidat,
            'hasil' => $dataKandidat,
            'total_kegiatan' => Kegiatan::count(),
            'total_kandidat' => $total_kandidat,
            'total_suara' => $total_suara,
            'total_user' => User::count(),
            'select' => Kegiatan::all(),
            'kegiatan' => $kegiatan
            
        ]);
    }

    public function logout(Request $request)
    {
        // Session::flush();
        
        Auth::logout();

        return redirect()->route('beranda.index');
    }

    public function nik(Request $request)
    {
        // dd($request);
        // return $request->nik;
        $cekNik = User::where('nik',$request->nik)->count();
        if($cekNik > 0){
            return 'success';
        }else{
            return 'failed';
        }
        
    }
}
