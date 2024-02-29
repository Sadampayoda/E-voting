<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SearchController extends Controller
{
    public function user(Request $request)
    {
        $data =  User::where('name', 'like', '%' . $request->search . '%')->paginate(10);
        if ($request->search == '') {
            $data = User::paginate(10);
        }
        return view('admin.user.search', [
            'data' => $data
        ]);
    }

    public function kegiatan(Request $request)
    {
        $data =  Kegiatan::where('kegiatan', 'like', '%' . $request->search . '%')->paginate(5);
        if ($request->search == '') {
            $data = Kegiatan::paginate(5);
        }
        $data->map(function ($data) {



            $tahun_sekarang = date("Y-m-d");
            $tahun = date("Y-m-d", strtotime($data->tahun));


            if ($tahun == $tahun_sekarang) {
                $data->status = 'Sudah Mulai';
            } elseif ($tahun < $tahun) {
                $data->status = 'Belum Mulai';
            } else {
                $data->status = 'Selesai';
            }
        });
        return view('admin.kegiatan.search', [
            'data' => $data
        ]);
    }

    public function kandidat(Request $request)
    {
        $data =  Kandidat::where('id_kegiatan',$request->kandidat)->where('nama', 'like', '%' . $request->search . '%')->paginate(10);
        if ($request->search == '') {
            $data = Kandidat::where('id_kegiatan',$request->kandidat)->paginate(10);
        }

        return view('admin.kandidat.search',[
            'data' => $data,
            'id' => $request->kandidat
        ]);
    }

    public function santri(Request $request)
    {
        $data =  User::where('name', 'like', '%' . $request->search . '%')->where('role','user')->paginate(10);
        if ($request->search == '') {
            $data = User::where('role','user')->paginate(10);
        }
        return view('admin.santri.search', [
            'data' => $data
        ]);
    }
}
