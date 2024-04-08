<?php

namespace App\Http\Controllers;

use App\Charts\QuickQountChart;
use App\Models\Kegiatan;
use App\Models\kandidat;
use App\Models\Suara;
use App\Models\User;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Console\Output\Output;

// use Symfony\Component\HttpFoundation\Session\Session;

class BerandaController extends Controller
{
    public function index()
    {

        // dd($data);
        return view('beranda.index',[
            'total_user' => User::count(),
            'total_kegiatan' => Kegiatan::count(),
            'total_kandidat' => Kandidat::count(),
            'total_suara' => Suara::count(),
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
            $request->session()->regenerate();

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
        // $data = Kandidat::where('id_kegiatan', $id)->get();
        // dd($data);
        return view('beranda.kandidat', [
            'data' => Kandidat::where('id_kegiatan', $id)->get(),
            'total_user' => User::count(),
            'total_kegiatan' => Kegiatan::count(),
            'total_kandidat' => Kandidat::count(),
            'total_suara' => Suara::count(),
        ]);
    }

    public function hasil($id)
    {

        if ($id) {

            $suaraKandidat = Suara::rightJoin('kandidats', 'suaras.id_kandidat', '=', 'kandidats.id')
                ->leftJoin('users', 'suaras.id_user', '=', 'users.id')
                ->leftJoin('kegiatans', 'kegiatans.id', '=', 'kandidats.id_kegiatan')
                ->select('kandidats.nama',  DB::raw('COUNT(suaras.id_kandidat) as jumlah_suara'))
                ->where('kegiatans.id', $id)
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

        $suaraPerKandidat = Kandidat::select('kandidats.nama', DB::raw('COUNT(kandidats.nama) as suara'), 'suaras.tanggal')
            ->join('suaras', 'kandidats.id', '=', 'suaras.id_kandidat')
            ->join('kegiatans', 'kegiatans.id', '=', 'suaras.id_kegiatan')
            ->where('kegiatans.id', $id)
            ->groupBy('suaras.tanggal', 'kandidats.nama')
            ->get();


        // print_r(json_encode($suaraPerKandidat));
        $kegiatan = Kegiatan::find($id);

        // Buat rentang tanggal secara manual
        $dateRange = [];
        $startDate = $kegiatan->tanggal_dari;
        $endDate = $kegiatan->tanggal_sampai;
        $currentDate = $startDate;

        while ($currentDate <= $endDate) {
            $dateRange[] = $currentDate;
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }

        // Query database
        $suaraPerKandidat = Kandidat::select('kandidats.nama', DB::raw('COUNT(kandidats.nama) as suara'), 'suaras.tanggal')
            ->join('suaras', 'kandidats.id', '=', 'suaras.id_kandidat')
            ->join('kegiatans', 'kegiatans.id', '=', 'suaras.id_kegiatan')
            ->where('kegiatans.id', $id)
            ->groupBy('suaras.tanggal', 'kandidats.nama')
            ->get();

        // Inisialisasi struktur data
        $data = [];
        foreach ($dateRange as $date) {
            $data[$date] = [];
        }

        // Isi struktur data dengan hasil query
        foreach ($suaraPerKandidat as $suara) {
            $tanggal = $suara->tanggal;
            $nama = $suara->nama;
            $suaraCount = $suara->suara;

            if (!isset($data[$tanggal][$nama])) {
                $data[$tanggal][$nama] = $suaraCount;
            } else {
                $data[$tanggal][$nama] += $suaraCount;
            }
        }

        // Nullkan tanggal yang tidak memiliki suara
        foreach ($data as $tanggal => $kandidat) {
            foreach ($kandidat as $nama => $suara) {
                if ($suara === null) {
                    unset($data[$tanggal][$nama]);
                }
            }
        }
        // print_r($data);
        // die;
        $uniqueCandidates = [];
        foreach ($data as $tanggal => $kandidat) {
            foreach ($kandidat as $nama => $suara) {
                if (!in_array($nama, $uniqueCandidates)) {
                    $uniqueCandidates[] = $nama;
                }
            }
        }

        // 2. Membuat struktur data baru untuk Highcharts
        $highchartsData = [];
        foreach ($uniqueCandidates as $nama) {
            $seriesData = [];
            foreach ($data as $tanggal => $kandidat) {
                $seriesData[] = isset($kandidat[$nama]) ? $kandidat[$nama] : 0;
            }
            $highchartsData[] = [
                'name' => $nama,
                'data' => $seriesData,
            ];
        }

        // 3. Menggabungkan data kandidat dengan nama yang sama menjadi satu dataset
        $mergedHighchartsData = [];
        foreach ($highchartsData as $item) {
            $name = $item['name'];
            if (!isset($mergedHighchartsData[$name])) {
                $mergedHighchartsData[$name] = [
                    'name' => $name,
                    'data' => $item['data'],
                ];
            } else {
                foreach ($item['data'] as $key => $value) {
                    if ($value !== null) {
                        $mergedHighchartsData[$name]['data'][$key] += $value;
                    }
                }
            }
        }
        $chartData = [];
        foreach ($mergedHighchartsData as $name => $data) {
            $chartData[] = [
                'name' => $name,
                'data' => $data['data']
            ];
        }
        // print_r($chartData);
        // die;

        return view('beranda.hasil', [
            'select' => Kegiatan::all(),
            'data' => $suaraKandidat,
            'hasil' => $dataKandidat,
            'dateRange' => $dateRange,
            'chartHasil' => $chartData,
            'kandidat' => Kandidat::where('id_kegiatan', $id)->paginate(5),
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
        $dateRange = [];
        $chartData = [];

        if ($request->search) {


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


            $suaraPerKandidat = Kandidat::select('kandidats.nama', DB::raw('COUNT(kandidats.nama) as suara'), 'suaras.tanggal')
                ->join('suaras', 'kandidats.id', '=', 'suaras.id_kandidat')
                ->join('kegiatans', 'kegiatans.id', '=', 'suaras.id_kegiatan')
                ->where('kegiatans.id', $request->search)
                ->groupBy('suaras.tanggal', 'kandidats.nama')
                ->get();


            // print_r(json_encode($suaraPerKandidat));
            $kegiatan = Kegiatan::find($request->search);

            // Buat rentang tanggal secara manual
            $dateRange = [];
            $startDate = $kegiatan->tanggal_dari;
            $endDate = $kegiatan->tanggal_sampai;
            $currentDate = $startDate;

            while ($currentDate <= $endDate) {
                $dateRange[] = $currentDate;
                $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
            }

            
            $suaraPerKandidat = Kandidat::select('kandidats.nama', DB::raw('COUNT(kandidats.nama) as suara'), 'suaras.tanggal')
                ->join('suaras', 'kandidats.id', '=', 'suaras.id_kandidat')
                ->join('kegiatans', 'kegiatans.id', '=', 'suaras.id_kegiatan')
                ->where('kegiatans.id', $request->search)
                ->groupBy('suaras.tanggal', 'kandidats.nama')
                ->get();


            $data = [];
            foreach ($dateRange as $date) {
                $data[$date] = [];
            }


            foreach ($suaraPerKandidat as $suara) {
                $tanggal = $suara->tanggal;
                $nama = $suara->nama;
                $suaraCount = $suara->suara;

                if (!isset($data[$tanggal][$nama])) {
                    $data[$tanggal][$nama] = $suaraCount;
                } else {
                    $data[$tanggal][$nama] += $suaraCount;
                }
            }


            foreach ($data as $tanggal => $kandidat) {
                foreach ($kandidat as $nama => $suara) {
                    if ($suara === null) {
                        unset($data[$tanggal][$nama]);
                    }
                }
            }

            $uniqueCandidates = [];
            foreach ($data as $tanggal => $kandidat) {
                foreach ($kandidat as $nama => $suara) {
                    if (!in_array($nama, $uniqueCandidates)) {
                        $uniqueCandidates[] = $nama;
                    }
                }
            }


            $highchartsData = [];
            foreach ($uniqueCandidates as $nama) {
                $seriesData = [];
                foreach ($data as $tanggal => $kandidat) {
                    $seriesData[] = isset($kandidat[$nama]) ? $kandidat[$nama] : 0;
                }
                $highchartsData[] = [
                    'name' => $nama,
                    'data' => $seriesData,
                ];
            }


            $mergedHighchartsData = [];
            foreach ($highchartsData as $item) {
                $name = $item['name'];
                if (!isset($mergedHighchartsData[$name])) {
                    $mergedHighchartsData[$name] = [
                        'name' => $name,
                        'data' => $item['data'],
                    ];
                } else {
                    foreach ($item['data'] as $key => $value) {
                        if ($value !== null) {
                            $mergedHighchartsData[$name]['data'][$key] += $value;
                        }
                    }
                }
            }
            $chartData = [];
            foreach ($mergedHighchartsData as $name => $data) {
                $chartData[] = [
                    'name' => $name,
                    'data' => $data['data']
                ];
            }
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
            $total_kandidat = Kandidat::join('kegiatans', 'kegiatans.id', '=', 'kandidats.id_kegiatan')->where('kegiatans.id', $request->search)->count();
            $dataKegiatan = Kegiatan::where('id', $request->search)->first();
            $kegiatan = $dataKegiatan->kegiatan;
        }

        return view('beranda.dashboard', [
            'data' => $suaraKandidat,
            'hasil' => $dataKandidat,
            'total_kegiatan' => Kegiatan::count(),
            'total_kandidat' => $total_kandidat,
            'total_suara' => $total_suara,
            'total_user' => User::count(),
            'select' => Kegiatan::all(),
            'kegiatan' => $kegiatan,
            'dateRange' => $dateRange,
            'chartHasil' => $chartData
        ]);
    }

    public function logout(Request $request)
    {
        // Session::flush()
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // return redirect();
        // return 'o';
        return redirect()->route('beranda.index');
    }

    public function nik(Request $request)
    {
        // dd($request);
        // return $request->nik;
        $cekNik = User::where('nik', $request->nik)->count();
        if ($cekNik > 0) {
            return 'success';
        } else {
            return 'failed';
        }
    }

    public function register()
    {
        return view('beranda.register');
    }

    public function newAkun(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'nik' => 'required|string|unique:users',
            'jenis_kelamin' => 'required|in:Laki Laki,Perempuan',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:6',
        ]);

        if ($request->password != $request->confirmed) {
            return redirect()->back()->with('error', 'Password dan Konfirmasi tidak sesuai');
        }
        $fotoName = time() . '.' . $request->foto->extension();



        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nik = $request->nik;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->foto = $fotoName;
        $user->password = bcrypt($request->password);
        $user->role = 'user';
        $user->save();
        $request->foto->move('image/users', $fotoName);
        return redirect()->route('beranda.login');
    }

    public function profile()
    {
        return view('beranda.profile', [
            'user' => User::find(auth()->user()->id),
        ]);
    }

    public function editProfile(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);


        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nik' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki Laki,Perempuan',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        $user->name = $request->name;
        $user->email = $request->email;
        $user->nik = $request->nik;
        $user->jenis_kelamin = $request->jenis_kelamin;


        if ($request->hasFile('foto')) {

            if ($user->foto) {
                File::delete('image/users/' . $user->foto);
            }
            $fotoName = time() . '.' . $request->foto->extension();
            $request->foto->move('image/users', $fotoName);
            $user->foto = $fotoName;
        }


        $user->save();

        return redirect()->back()->with('success', 'Data Profile berhasil di edit');
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        $user = User::findOrFail(auth()->user()->id);

        if ($request->new_password != $request->new_password_confirmation) {
            return back()->with('error', 'Password baru dan password konfirmasi tidak cocok');
        }
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password saat ini salah.');
        }


        $user->password = bcrypt($request->new_password);
        $user->save();


        return redirect()->back()->with('success', 'Data Password berhasil di edit');
    }

    public function kegiatan()
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
        return view('beranda.kegiatan', [
            'data' => $data,
            'total_user' => User::count(),
            'total_kegiatan' => Kegiatan::count(),
            'total_kandidat' => Kandidat::count(),
            'total_suara' => Suara::count(),
        ]);
    }
}
