@extends('component.nav')


@section('content')
    <div class="content">
        <div class="mt-5 pt-5">
            <h1>Welcome to E-Voting</h1>
            <div class="input-group mb-3 w-50 mx-auto">
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search"
                    aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-dark" type="button" id="button-addon2">Search NIK</button>
                </div>
            </div>
        </div>
    </div>

    <section id="pemilu">
        <div class="container mb-5 mt-5">
            <div class="row">
                <div class="col border-bottom p-2 text-center">
                    <h1>E-voting Saat ini</h1>
                </div>
            </div>
            <div class="row d-flex justify-content-center mt-4 mb-5">
                @foreach ($data as $item)
                    @if ($item->status == 'Sedang Berlangsung')
                        <div class="col-4">
                            <div class="card" style="width: 30rem;">
                                <img src="{{ asset('image/beranda/gambar-vote.jpg') }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">Pemilu ini di selenggarakan tanggal {{$item->tanggal_dari}} dengan waktu sampai {{$item->waktu_dari}} - {{$item->waktu_sampai}} dan
                                        berakhir tanggal {{$item->tanggal_sampai}} </p>
                                    <a href="{{route('beranda.kandidat',$item->id)}}" class="btn btn-dark card-link">Lihat Kandidat</a>
                                    <a href="#" class="btn btn-dark card-link">Voting Sekarang</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <section id="pemilu" style="height: 400px">
        <div class="container mb-5 mt-5">
            <div class="row">
                <div class="col border-bottom p-2 text-center">
                    <h1>E-voting Segera</h1>
                </div>
            </div>
            <div class="row d-flex justify-content-center mt-4 mb-5">
                @foreach ($data as $item)
                    @if ($item->status == 'Belum Mulai')
                        <div class="col-4">
                            <div class="card" style="width: 30rem;">
                                <img src="{{ asset('image/beranda/gambar-vote.jpg') }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">Pemilu ini di selenggarakan tanggal {{$item->tanggal_dari}} dengan waktu sampai {{$item->waktu_dari}} - {{$item->waktu_sampai}} dan
                                        berakhir tanggal {{$item->tanggal_sampai}} </p>
                                    <a href="#" class="btn btn-dark card-link">Lihat Kandidat</a>
                                    <a href="#" class="btn btn-dark card-link">Voting Sekarang</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endsection
