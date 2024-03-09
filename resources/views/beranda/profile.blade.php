@extends('component.app')


@section('content')
    <div class="container mt-5">
        <div class="row mt-5 pt-5">
            @if (session())
                <div class="col">
                    <div class="">
                        <div class="row d-flex justify-content-center mt-5">
                            <div class="col">
                                @if (session()->has('success'))
                                    @include('component.alert', [
                                        'message' => session('success'),
                                        'status' => 'success',
                                    ])
                                @endif
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
            <div class="col-md-6">
                <div class="row">
                    <div class="col">
                        <div class="card shadow ">
        
                            <img class="figure-img img-fluid rounded" src="{{ asset('image/users/' . $user->foto) }}"
                                alt="">
        
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card shadow p-3 mt-3">
                            <button class="btn btn-dark" data-toggle="modal" data-target="#editPasswordModal">Ubah Password</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow p-3">
                    <div class="row d-flex justify-content-center">
                        <div class="col-5 border-bottom pb-2 pt-2 text-center">
                            <h3>Profile {{ auth()->user()->name }}</h3>
                        </div>
                    </div>
                    <form action="{{route('beranda.profile.edit')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-9">
                                <div class="form-group mb-4">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Masukkan nama" value="{{ $user->name }}">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Masukkan email" value="{{ $user->email }}">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="nik">NIK</label>
                                    <input type="text" class="form-control" id="nik" name="nik"
                                        placeholder="Masukkan NIK" value="{{ $user->nik }}">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="Laki Laki" {{ $user->jenis_kelamin == 'Laki Laki' ? 'selected' : '' }}>
                                            Laki-laki
                                        </option>
                                        <option value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="foto">Foto</label>
                                    <input type="file" class="form-control" id="foto" name="foto">
                                    <input type="hidden" name="foto_lama" value="{{ $user->foto }}">
                                </div>
                                <div class="form-group mb-4">
                                    <div class="d-grid">
                                        <button class="btn btn-dark">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="editPasswordModal" tabindex="-1" role="dialog" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPasswordModalLabel">Ubah Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('beranda.profile.password') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="current_password">Password Saat Ini</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">Password Baru</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
