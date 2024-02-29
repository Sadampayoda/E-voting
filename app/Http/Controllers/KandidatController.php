<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KandidatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        

        // dd($data);
        
        return view('admin.kandidat.index',[
            'data' => Kandidat::where('id_kegiatan',$request->kandidat)->paginate(5),
            'id' => $request->kandidat
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
        // dd($request->id_kegiatan);
        $validatedData = $request->validate([
            'id_kegiatan' => 'required',
            'nama' => 'required|string',
            'nama_wakil' => 'required|string',
            'nik' => 'required|string',
            'nik_wakil' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_wakil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'visi' => 'required|string',
            'misi' => 'required|string',
        ]);

        if ($request->hasFile('foto')) {
            $fotoName = time() . '.' . $request->foto->extension();
            $request->foto->move('image/kandidat', $fotoName);
            $validatedData['foto'] = $fotoName;
            
        }
        if ($request->hasFile('foto_wakil')) {
            $fotoName = time() . '.' . $request->foto_wakil->extension();
            $request->foto_wakil->move('image/kandidat', $fotoName);
            $validatedData['foto_wakil'] = $fotoName;
            
        }

        
        
        

        
        Kandidat::create($validatedData);

        
        return redirect()->route('kandidat.index',['kandidat' => $request->id_kegiatan])->with('success', 'Kandidat berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Kandidat $kandidat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kandidat $kandidat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kandidat = Kandidat::findOrFail($id);

        $request->validate([
            'nama' => 'required|string',
            'nama_wakil' => 'required|string',
            'nik' => 'required|string',
            'nik_wakil' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_wakil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'visi' => 'required|string',
            'misi' => 'required|string',
        ]);

        $kandidat->nama = $request->nama;
        $kandidat->nama_wakil = $request->nama_wakil;
        $kandidat->visi = $request->visi;
        $kandidat->misi = $request->misi;
        $kandidat->nik = $request->nik;
        $kandidat->nik_wakil = $request->nik_wakil;
        // $kandidat->jenis_kelamin = $request->jenis_kelamin;
        // $kandidat->role = $request->role;

        if ($request->hasFile('foto')) {
            
            if ($kandidat->foto) {
                Storage::delete('public/image/kandidat/' . $kandidat->foto);
            }
            $fotoName = time() . '.' . $request->foto->extension();
            $request->foto->move('image/kandidat', $fotoName);
            $kandidat->foto = $fotoName;
        }
        if ($request->hasFile('foto_wakil')) {
            
            if ($kandidat->foto_wakil) {
                Storage::delete('public/image/kandidat/' . $kandidat->foto_wakil);
            }
            $fotoName = time() . '.' . $request->foto_wakil->extension();
            $request->foto_wakil->move('image/kandidat', $fotoName);
            $kandidat->foto_wakil = $fotoName;
        }

        $kandidat->save();

        
        return redirect()->route('kandidat.index',['kandidat' => $request->id_kegiatan])->with('success', 'Data Kendidat berhasil diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
        Kandidat::where('id',$id)->delete();
        return redirect()->route('kandidat.index',['kandidat' => $request->id_kegiatan])->with('success', 'Data Kendidat berhasil dihapus.');

    }
}
