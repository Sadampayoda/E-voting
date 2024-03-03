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
                    <h1>Kandidat</h1>
                </div>
            </div>
            <div class="row d-flex justify-content-center mt-4 mb-5">
                @foreach ($data as $item)
                    <div class="col-4 m-5">
                        <div class="card" style="width: 30rem;">
                            <img src="{{ asset('image/kandidat/'.$item->foto) }}" width="200" height="200" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text"> </p>
                                <a href="#" class="btn btn-dark card-link">Lihat Wakil</a>
                                <a href="#" class="btn btn-dark card-link">Voting Sekarang</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
