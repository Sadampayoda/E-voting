@extends('component.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <h1>Kegiatan</h1>
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
                <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#createUserModal">
                    Tambah Kegiatan
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
                                <th scope="col">Kegiatan</th>
                                <th scope="col">Tahun</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Waktu</th>
                                <th scope="col">Status</th>
                                <th scope="col">Kandidat</th>
                                <th scope="col">Data Suara</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="kegiatan">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $item->kegiatan }}</td>
                                    <td>{{ $item->tahun }}</td>
                                    <td>{{ $item->tanggal_dari }} - {{ $item->tanggal_sampai }}</td>
                                    <td>{{ $item->waktu_dari }}-{{ $item->waktu_sampai }}</td>
                                    @if ($item->status == 'Belum Mulai')
                                        <td><i class="btn btn-danger">{{ $item->status }}</i></td>
                                    @elseif ($item->status == 'Sudah Mulai')
                                        <td><i class="btn btn-warning">{{ $item->status }}</i></td>
                                    @else
                                        <td><i class="btn btn-success">{{ $item->status }}</i></td>
                                    @endif

                                    <td><a class="btn btn-outline-dark"
                                            href="{{ route('kandidat.index', ['kandidat' => $item->id]) }}">Kandidat</a></td>

                                    <td><a class="btn btn-outline-dark"
                                            href="{{ route('kegiatan.show', ['kegiatan' => $item->id]) }}">Lihat</a></td>
                                    <td>
                                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal"
                                            data-target="#editKandidatModal{{ $item->id }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('kegiatan.destroy', ['kegiatan' => $item->id]) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-secondary" type="submit"
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

    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Tambah User Manajemen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('kegiatan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kegiatan">Kegiatan:</label>
                            <input type="text" class="form-control" id="kegiatan" name="kegiatan" required>
                        </div>
                        <div class="form-group">
                            <label for="tahun">Tahun:</label>
                            <input type="number" class="form-control" id="tahun" name="tahun" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_dari">Tanggal Dari:</label>
                            <input type="date" class="form-control" id="tanggal_dari" name="tanggal_dari" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_sampai">Tanggal Sampai:</label>
                            <input type="date" class="form-control" id="tanggal_sampai" name="tanggal_sampai" required>
                        </div>
                        <div class="form-group">
                            <label for="waktu_dari">Waktu Dari:</label>
                            <input type="time" class="form-control" id="waktu_dari" name="waktu_dari" required>
                        </div>
                        <div class="form-group">
                            <label for="waktu_sampai">Waktu Sampai:</label>
                            <input type="time" class="form-control" id="waktu_sampai" name="waktu_sampai" required>
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
                    <form action="{{ route('kegiatan.update', ['kegiatan' => $item->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="kegiatan">Kegiatan:</label>
                                <input type="text" class="form-control" id="kegiatan" name="kegiatan"
                                    value="{{ $item->kegiatan }}" required>
                            </div>
                            <div class="form-group">
                                <label for="tahun">Tahun:</label>
                                <input type="number" class="form-control" id="tahun" name="tahun"
                                    value="{{ $item->tahun }}" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_dari">Tanggal Dari:</label>
                                <input type="date" class="form-control" id="tanggal_dari" name="tanggal_dari"
                                    value="{{ $item->tanggal_dari }}" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_sampai">Tanggal Sampai:</label>
                                <input type="date" class="form-control" id="tanggal_sampai" name="tanggal_sampai"
                                    value="{{ $item->tanggal_sampai }}" required>
                            </div>
                            <div class="form-group">
                                <label for="waktu_dari">Waktu Dari:</label>
                                <input type="time" class="form-control" id="waktu_dari" name="waktu_dari"
                                    value="{{ $item->waktu_dari }}" required>
                            </div>
                            <div class="form-group">
                                <label for="waktu_sampai">Waktu Sampai:</label>
                                <input type="time" class="form-control" id="waktu_sampai" name="waktu_sampai"
                                    value="{{ $item->waktu_sampai }}" required>
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


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.getElementById('search');

            searchInput.addEventListener('keyup', function() {
                var search = this.value;
                var xhr = new XMLHttpRequest();

                xhr.open('GET', "{{ route('search.kegiatan') }}?search=" + search, true);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            document.getElementById('kegiatan').innerHTML = xhr.responseText;
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
