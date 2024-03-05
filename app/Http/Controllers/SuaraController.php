<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Kegiatan;
use App\Models\Suara;
use App\Models\User;
use Illuminate\Http\Request;

class SuaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(!auth()->user()){
            return redirect()->route('beranda.login');
        }

        $data = Kegiatan::find($request->suara);


        $tanggalSekarang = strtotime(date('Y-m-d'));


        $tanggalDari = strtotime($data->tanggal_dari);
        $tanggalSampai = strtotime($data->tanggal_sampai);


        if (!$tanggalSekarang >= $tanggalDari && !$tanggalSekarang <= $tanggalSampai) {
            return redirect()->route('beranda.index');
        }
        $cekUsers = User::join('suaras','suaras.id_user','=','users.id')->join('kegiatans','kegiatans.id','=','suaras.id_kegiatan')->where('users.id',auth()->user()->id)->where('kegiatans.id',$request->suara)->count();
        if($cekUsers > 0)
        {
            return redirect()->route('beranda.index');
        }



        return view('suara.index', [
            'data' => Kandidat::select('kandidats.id as id_kandidat', 'kandidats.*', 'kegiatans.*')->join('kegiatans', 'kegiatans.id', '=', 'kandidats.id_kegiatan')->where('kegiatans.id', $request->suara)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $validasi = $request->validate([
            'id_user' => 'required',
            'id_kandidat' => 'required',
            'id_kegiatan' => 'required',
        ]);

        $validasi['tanggal_waktu'] = now();
        $validasi['tanggal'] = now();

        Suara::create($validasi);
        return redirect()->route('beranda.index')->with('success', 'Terima kasih telah vote dengan jujur');
    }

    /**
     * Display the specified resource.
     */
    public function show(Suara $suara)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Suara $suara)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Suara $suara)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Suara $suara)
    {
        //
    }
}
