@extends('component.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <h1>Suara Users Kegiatan {{$kegiatan}}</h1>
        </div>
        <!-- Tabel Responsif -->
        @if (session()->has('success'))
            @include('component.alert', [
                'message' => session('success'),
                'status' => 'success',
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
        <div class="d-flex justify-content-end">
            <div class="col-6 mb-2 ">

                <div class="form-inline float-right">
                    <input class="form-control mr-sm-2" type="search" id="search" placeholder="Search"
                        aria-label="Search">
                    <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Search</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="input-group mb-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Santri</th>
                                <th scope="col">NIK</th>
                                <th scope="col">Jenis Kelamin</th>
                                <th scope="col">Pilihan</th>
                                <th scope="col">Tanggal Waktu</th>
                                <th scope="col">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody id="user">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $i }}</td>
                                    
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->jenis_kelamin }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->tanggal_waktu }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                  
                                        
                                    
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination">
                        {{ $data->onEachSide(5)->links() }} 
                    </div>
                </div>
            </div>
        </div>
    </div>



    


    @foreach ($data as $item)
        <div class="modal fade" id="editUserModal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('user-manejement.update', ['user_manejement' => $item->id]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="foto_lama" value="{{$item->foto}}">
                                <label for="foto">Foto:</label>
                                <input type="file" class="form-control-file" id="foto" name="foto">
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama:</label>
                                <input type="text" class="form-control" id="nama" name="name" value="{{ $item->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $item->email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="nik">NIK:</label>
                                <input type="text" class="form-control" id="nik" name="nik" value="{{ $item->nik }}" required>
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin:</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="Laki laki" {{ $item->jenis_kelamin === 'Laki laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ $item->jenis_kelamin === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="admin" {{ $item->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user" {{ $item->role === 'user' ? 'selected' : '' }}>User</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach








@endsection
