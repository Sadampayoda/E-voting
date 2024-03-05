<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .content {
            background-image: url('{{ asset('image/beranda/pemilu.jpg') }}');
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            color: #fff;
            text-align: center;
            padding-top: 150px;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.5);
            /* Warna latar belakang navbar */
        }

        
    </style>
</head>

<body style="background: #eee">

    <nav class="navbar fixed-top p-2 navbar-expand-lg bg-dark ">
        <div class="container">
          <a class="navbar-brand text-light" href="#">E-Voting</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto">
              <a class="nav-link text-light active" aria-current="page" href="{{route('beranda.index')}}">Home</a>
              <a class="nav-link text-light" href="{{route('beranda.hasil')}}">Hasil E-voting</a>
              {{-- <a class="nav-link text-light" href="#">Pricing</a> --}}

              @if (auth()->user())
                <a class="nav-link text-light" href="{{route('beranda.logout')}}">Logout</a>
                
              @else
                <a class="nav-link text-light" href="{{route('beranda.login')}}">Login</a>
                
              @endif
            </div>
          </div>
        </div>
      </nav>

    @yield('content')

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
