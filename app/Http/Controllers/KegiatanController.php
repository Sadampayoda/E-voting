<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Suara;
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
        

        return view('admin.kegiatan.index', [
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

        return view('admin.kegiatan.show', [
            'data' => Suara::join('users', 'users.id', '=', 'suaras.id_user')->join('kegiatans', 'kegiatans.id', '=', 'suaras.id_kegiatan')->join('kandidats', 'kandidats.id_kegiatan', '=', 'kegiatans.id')->where('suaras.id_kegiatan', $kegiatan->id)->paginate(10),
            'kegiatan' => $kegiatan->kegiatan
        ]);
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
        Kegiatan::where('id', $kegiatan->id)->delete();
        return redirect()->back()->with('success', 'Data Kegiatan berhasil diperbarui.');
    }
}
