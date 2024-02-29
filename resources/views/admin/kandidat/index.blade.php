@extends('component.app')

@section('content')
{{-- @dd($kandidat) --}}
    <div class="container mt-4">
        <div class="row">
            <h1>Kandidat Kegiatan</h1>
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
        <div class="row">
            <div class="col-6 mb-2">
                <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#createKandidatModal" data-id="{{ $id }}">
                    Tambah Kandidat Kegiatan
                </button>
            </div>
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
                                <th scope="col">Foto</th>
                                <th scope="col">Nama Kandidat</th>
                                <th scope="col">NIK</th>
                                <th scope="col">Visi & Misi dan Wakil</th>

                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="kandidat">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td><img src="{{ asset('image/kandidat/' . $item->foto) }}" width="75" height="75"
                                            alt=""></td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td><button class="btn btn-dark" type="button" data-toggle="modal"
                                            data-target="#detailKandidatModal{{ $item->id }}">Visi Misi dan wakil</td>

                                    <td>
                                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal"
                                            data-target="#editKandidatModal{{ $item->id }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('kandidat.destroy', ['kandidat' => $item->id]) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-secondary" name="id_kegiatan" value="{{$id}}" type="submit"
                                                onclick="return confirm('Anda yakin ingin menghapus data ini?')">Delete</button>
                                        </form>
                                    </td>
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

    <div class="modal fade" id="createKandidatModal" tabindex="-1" role="dialog"
        aria-labelledby="createKandidatModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createKandidatModalLabel">Tambah Kandidat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('kandidat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_kegiatan" value="{{ $id }}">

                        <div class="form-group">
                            <label for="nama">Nama:</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_wakil">Nama Wakil:</label>
                            <input type="text" class="form-control" id="nama_wakil" name="nama_wakil" required>
                        </div>

                        <div class="form-group">
                            <label for="nik">NIK:</label>
                            <input type="text" class="form-control" id="nik" name="nik" required>
                        </div>
                        <div class="form-group">
                            <label for="nik_wakil">NIK Wakil:</label>
                            <input type="text" class="form-control" id="nik_wakil" name="nik_wakil" required>
                        </div>

                        <div class="form-group">
                            <label for="foto">Foto:</label>
                            <input type="file" class="form-control-file" id="foto" name="foto">
                        </div>

                        <div class="form-group">
                            <label for="foto_wakil">Foto wakil :</label>
                            <input type="file" class="form-control-file" id="foto_wakil" name="foto_wakil">
                        </div>

                        <div class="form-group">
                            <label for="visi">Visi:</label>
                            <textarea class="form-control" id="visi" name="visi" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="misi">Misi:</label>
                            <textarea class="form-control" id="misi" name="misi" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($data as $item)
        <div class="modal fade" id="editKandidatModal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editKandidatModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editKandidatModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('kandidat.update', ['kandidat' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" name="id_kegiatan" value="{{ $id }}">

                            <div class="form-group">
                                <label for="nama">Nama:</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="{{ $item->nama }}" required>
                            </div>

                            <div class="form-group">
                                <label for="nama_wakil">Nama Wakil:</label>
                                <input type="text" class="form-control" id="nama_wakil" name="nama_wakil"
                                    value="{{ $item->nama_wakil }}" required>
                            </div>

                            <div class="form-group">
                                <label for="nik">NIK:</label>
                                <input type="text" class="form-control" id="nik" name="nik"
                                    value="{{ $item->nik }}" required>
                            </div>
                            <div class="form-group">
                                <label for="nik_wakil">NIK Wakil:</label>
                                <input type="text" class="form-control" id="nik_wakil" name="nik_wakil"
                                    value="{{ $item->nik_wakil }}" required>
                            </div>

                            <div class="form-group">
                                <label for="foto">Foto:</label>
                                <input type="hidden" name="foto_lama" value="{{ $item->foto }}">
                                <input type="file" class="form-control-file" id="foto" name="foto">
                                @if ($item->foto)
                                    <img src="{{ asset('image/kandidat/' . $item->foto) }}" alt="Foto"
                                        width="100">
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label for="foto_wakil">Foto:</label>
                                <input type="hidden" name="foto_lama_wakil" value="{{ $item->foto_wakil }}">
                                <input type="file" class="form-control-file" id="foto_wakil" name="foto_wakil">
                                @if ($item->foto)
                                    <img src="{{ asset('image/kandidat/' . $item->foto_wakil) }}" alt="Foto_wakil"
                                        width="100">
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="visi">Visi:</label>
                                <textarea class="form-control" id="visi" name="visi" rows="3" required>{{ $item->visi }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="misi">Misi:</label>
                                <textarea class="form-control" id="misi" name="misi" rows="3" required>{{ $item->misi }}</textarea>
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


    @foreach ($data as $item)
        <div class="modal fade" id="detailKandidatModal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="detailKandidatModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailKandidatModalLabel">Visi, Misi, dan Wakil</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="visi">Visi:</label>
                            <textarea class="form-control" id="visi" rows="3" readonly>{{ $item->visi }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="misi">Misi:</label>
                            <textarea class="form-control" id="misi" rows="3" readonly>{{ $item->misi }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="wakil">Wakil:</label>
                            <img src="{{asset('image/kandidat/'.$item->foto_wakil)}}" alt="" class="img-fluid" width="100" height="100">
                            <input type="text" class="form-control" id="wakil" value="{{ $item->nama_wakil }}"
                                readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.getElementById('search');

            searchInput.addEventListener('keyup', function() {
                var search = this.value;
                var xhr = new XMLHttpRequest();

                xhr.open('GET', "{{ route('search.kandidat') }}?search=" + search +"&kandidat="+ {{$id}} , true);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            document.getElementById('kandidat').innerHTML = xhr.responseText;
                        } else {
                            console.error('Terjadi kesalahan: ' + xhr.status);
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        }
                    }
                };
                xhr.send();
            });
        });
    </script>
@endsection
