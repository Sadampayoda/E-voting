@extends('component.nav')

@section('content')
{{-- @dd($data) --}}
{{-- @dd($data) --}}
    <section id="pemilu">
        <div class="container mb-5 mt-5">
            <div class="row">
                <div class="col border-bottom p-2 text-center">
                    <h1>Tentukan suaramu</h1>
                    <p>Kegiatan {{ $data[0]->kegiatan }}</p>
                </div>
            </div>
            <div class="row d-flex justify-content-center mt-4 mb-5">

                @foreach ($data as $item)
                
                    <div class="card m-4 p-3 shadow" style="width: 30rem;">
                        <img src="{{ asset('image/kandidat/' . $item->foto) }}" width="200" height="200"
                            class="card-img-top" alt="Foto Kandidat">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Nomor Urut: {{ $loop->iteration }}</h6>
                            <p class="card-text">{{ $item->deskripsi }}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Visi:</strong> {{ $item->visi }}</li>
                            <li class="list-group-item"><strong>Misi:</strong> {{ $item->misi }}</li>
                            <li class="list-group-item">
                                <div class="d-grid">
                                    <button type="button" class="btn btn-outline-dark " data-bs-toggle="modal"
                                        data-bs-target="#wakil{{$item->id_kandidat}}">Lihat Wakil</button>

                                </div>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center">

                            <div class="card" style="width: 25rem;">
                                <div class="card-header">
                                    Click untuk vote no {{ $loop->iteration }}
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <form action="{{route('suara.store')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="id_kandidat" value="{{$item->id_kandidat}}">
                                            <input type="hidden" name="id_kegiatan" value="{{$item->id_kegiatan}}">
                                            <input type="hidden" name="id_user" value="{{auth()->user()->id}}">
                                            <div class="d-grid">
                                                <button class="btn btn-dark">Vote Sekarang</button>
                                            </div>
                                        </form>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    @foreach ($data as $item )
        <div class="modal fade" id="wakil{{$item->id_kandidat}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="wakilLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="wakilLabel">Wakil</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <img src="{{ asset('image/kandidat/' . $item->foto_wakil) }}" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="wakil">Nama Wakil</label>
                                <input type="text" class="form-control" id="wakil" value="{{ $item->nama_wakil }}"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
