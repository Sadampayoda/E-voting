<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Kegiatan::paginate(5);
        
        // return $tanggal_sekarang;
        $data->map(function($data){
            
            
            $tahun_sekarang = date("Y-m-d");
            $tahun = date("Y-m-d", strtotime($data->tahun));
            // $waktu_sekarang = Carbon::now()->toTimeString();
            // $tanggal_dari = Carbon::parse($data->tanggal_awal);
            // $tanggal_sampai = Carbon::parse($data->tanggal_sampai);
            // dd($tahun,$tahun_sekarang);
            
            if ($tahun == $tahun_sekarang) {
                $data->status = 'Sudah Mulai';
            } elseif ($tahun < $tahun) {
                $data->status = 'Belum Mulai';
            } else {
                $data->status = 'Selesai';
            }            

            
        });
        // $tess = Kegiatan::all();
        // $tes = Carbon::parse($tess[0]->tahun);
        // $tahun_sekarang = date("Y");
        // $tahun = date("Y", strtotime($tess[0]->tahun));
        // return dd(strval($tahun) == strval($tahun_sekarang));
        
        return view('admin.kegiatan.index',[
            'data' => $data
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
        $validator = $request->validate([
            'kegiatan' => 'required|string',
            'tahun' => 'required|integer',
            'tanggal_dari' => 'required|date',
            'tanggal_sampai' => 'required|date|after_or_equal:tanggal_dari',
            'waktu_dari' => 'required|date_format:H:i',
            'waktu_sampai' => 'required|date_format:H:i|after:waktu_dari',
        ]);



        // Proses penyimpanan data
        // Misalnya:
        Kegiatan::create($request->all());

        return redirect()->back()->with('success', 'Data Kegiatan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kegiatan $kegiatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kegiatan $kegiatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validator = $request->validate([
            'kegiatan' => 'required|string',
            'tahun' => 'required|integer',
            'tanggal_dari' => 'required|date',
            'tanggal_sampai' => 'required|date|after_or_equal:tanggal_dari',
            'waktu_dari' => 'required',
            'waktu_sampai' => 'required',
        ]);

        

        
        $data = Kegiatan::findOrFail($kegiatan->id);
        $data->update($request->all());

        return redirect()->back()->with('success', 'Data Kegiatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kegiatan $kegiatan)
    {
        Kegiatan::where('id',$kegiatan->id)->delete();
        return redirect()->back()->with('success', 'Data Kegiatan berhasil diperbarui.');
    }
}
