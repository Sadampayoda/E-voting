@extends('component.nav')


@section('content')
    <div class="container mt-5">
        <div class="row mt-5 pt-5">
            @if (session())
                <div class="col">
                    <div class="">
                        <div class="row d-flex justify-content-center mt-5">
                            <div class="col">
                                @if (session()->has('error'))
                                    @include('component.alert', [
                                        'message' => session('error'),
                                        'status' => 'error',
                                    ])
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                </div>
            @endif
        </div>
        <div class="row ">
            <div class="col">
                <div class="card pb-4 shadow ">
                    <div class="row mb-4 p-3 d-flex justify-content-center">
                        <div class="col-6">
                            <h3 class="text-center border-bottom pb-2">Register E-voting</h3>
                        </div>
                    </div>
                    <form action="{{route('beranda.newAkun')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-6 ">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-8">
                                        <div class="form-group mb-4">
                                            <label for="name">Nama</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="nik">NIK</label>
                                            <input type="number" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                                <option value="Laki Laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-8">
                                        <div class="form-group mb-4">
                                            <label for="foto">Foto</label>
                                            <input type="file" class="form-control" id="foto" name="foto">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="confirmed">Konfirmasi</label>
                                            <input type="password" class="form-control" id="confirmed" name="confirmed" placeholder="Masukkan konfirmasi password">
                                        </div>
                                        <div class="form-group mb-4">
                                            <div class="d-grid">
                                                <button class="btn btn-dark">Buat Akun Baru</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
