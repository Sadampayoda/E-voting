<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\kandidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
        return view('beranda.index',[
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
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('beranda.index');
            }
        }

        return redirect()->back()->with('error','Email dan Password anda salah');
        
    }

    public function kandidat($id)
    {
        return view('beranda.kandidat',[
            'data' => Kandidat::where('id_kegiatan',$id)->paginate(5),
        ]);
    }
}
