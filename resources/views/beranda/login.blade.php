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
                <div class="card shadow ">
                    <div class="row">
                        <div class="col-md-6 bg-primary d-flex align-items-center justify-content-center">
                            <img class="img-fluid" src="{{ asset('image/beranda/login.png') }}" width="400" alt="">
                        </div>
                        <div class="col-md-6 p-5">
                            <div class="row d-flex justify-content-center">
                                <div class="col-8">
                                    <h3 class="text-center border-bottom pb-2">Login E-voting</h3>
                                    <form action="{{ route('beranda.validasi') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label"><i class="bi bi-person"></i>
                                                Email </label>
                                            {{-- <i class="bi bi-person-circle"></i> --}}
                                            <input type="email" name="email" class="form-control"
                                                id="exampleInputEmail1" aria-describedby="emailHelp">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label"><i
                                                    class="bi bi-key-fill"></i> Password</label>
                                            <input type="password" name="password" class="form-control"
                                                id="exampleInputPassword1">
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">Submit E-voting</button>
                                        </div>
                                    </form>
                                    <div class="mb-5 text-center mt-2">
                                        <p class="text-muted">Belum punya akun ? klik link <a href="{{route('beranda.register')}}">disini</a></p.>
                                    </div>
                                    <div class="mb-2 mt-2">
                                        <p class="text-muted text-center">"Isilah dengan informasi akun Anda untuk mengakses layanan kami.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
