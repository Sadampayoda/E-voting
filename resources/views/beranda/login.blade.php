@extends('component.nav')


@section('content')
    <div class="container mt-5">
        <div class="row d-flex justify-content-center mt-5">
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
            <h1 class="text-center">Login E-Voting</h1>
            <div class="col-7">
                <form action="{{ route('beranda.validasi') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Submit E-voting</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
