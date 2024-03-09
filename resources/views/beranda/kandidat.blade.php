@extends('component.nav')

@section('content')
    <div class="content">
      <div class="container">
        <div class="row welcome-container">
            <div class="col-md-5">
                <h1>Lihat Kegiatan E-Voting</h1>
                <p>Selamat datang di halaman kami. Mohon untuk memberikan suara Anda!</p>
                <p>Coblos dengan bijak dan bertanggung jawab.</p>
                
                <div class="row ">
                    <div class="col-md-3">
                        <div class="card shadow ">
                            <div class="card-body">
                                <h5 class="card-title">Total BEM</h5>
                                <p class="card-text">{{ $total_user }}</p>
                            </div>
                        </div>
                    </div>
        
                   
                    <div class="col-md-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title">Total Kegiatan</h5>
                                <p class="card-text">{{ $total_kegiatan }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title">Total Kandidat</h5>
                                <p class="card-text">{{ $total_kandidat }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title">Total Suara</h5>
                                <p class="card-text">{{ $total_suara }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img src="{{asset('image/beranda/welcome.png')}}" alt="Gambar Selamat Datang" class="img-fluid">
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
                <div class="card m-4 p-3 shadow" style="width: 30rem;">
                    <img src="{{ asset('image/kandidat/'.$item->foto) }}" width="200" height="200" class="card-img-top" alt="Foto Kandidat">
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
                                <button type="button"  class="btn btn-outline-dark " data-bs-toggle="modal" data-bs-target="#wakil">Lihat Wakil</button>

                            </div>
                        </li>
                    </ul>
                </div>
                @endforeach
            </div>
        </div>
    </section>

 
  
  <!-- Modal -->
  <div class="modal fade" id="wakil" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="wakilLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="wakilLabel">Wakil</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col">
                <img src="{{asset('image/kandidat/'.$item->foto_wakil)}}" alt="" class="img-fluid">
            </div>
          </div>
          <div class="row">
            <div class="col">
                <label for="wakil">Nama Wakil</label>
                <input type="text" class="form-control"  id="wakil" value="{{$item->nama_wakil}}" disabled>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection
