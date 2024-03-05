@extends('component.nav')


@section('content')
    <div class="content">
        @if (session()->has('success'))
            @include('component.alert', [
                'message' => session('success'),
                'status' => 'success',
            ])
        @endif
        <div class="mt-5 pt-5">
            <h1>Welcome to E-Voting</h1>
            <div class="input-group mb-3 w-50 mx-auto">
                <input type="number" class="form-control" id="search" placeholder="Search..." aria-label="Search"
                    aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-dark" id="searchButton" type="button" id="button-addon2">Search NIK</button>
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
                                    <p class="card-text">Pemilu ini di selenggarakan tanggal {{ $item->tanggal_dari }}
                                        dengan waktu sampai {{ $item->waktu_dari }} - {{ $item->waktu_sampai }} dan
                                        berakhir tanggal {{ $item->tanggal_sampai }} </p>
                                    <a href="{{ route('beranda.kandidat', $item->id) }}"
                                        class="btn btn-dark card-link">Lihat
                                        Kandidat</a>
                                    <a href="{{ route('suara.index', ['suara' => $item->id]) }}"
                                        class="btn btn-dark card-link">Voting Sekarang</a>
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
                                    <p class="card-text">Pemilu ini di selenggarakan tanggal {{ $item->tanggal_dari }}
                                        dengan waktu sampai {{ $item->waktu_dari }} - {{ $item->waktu_sampai }} dan
                                        berakhir tanggal {{ $item->tanggal_sampai }} </p>
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

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                </div>
                <div class="modal-body">
                    NIK found in the database.
                </div>
                <div class="modal-footer">
                    <button type="button" id="success" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    
                </div>
                <div class="modal-body">
                    NIK not found in the database.
                </div>
                <div class="modal-footer">
                    <button type="button" id="error" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    

    <script>
        $(document).ready(function() {
            $('#searchButton').click(function() {
                var nik = $('#search').val();
                console.log(nik)
                $.ajax({
                    type: 'POST',
                    url: "{{ route('beranda.nik') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        nik: nik
                    },
                    success: function(response) {
                        // alert(response)
                        if (response === 'success') {
                            $('#successModal').modal('show');
                        } else {
                            $('#errorModal').modal('show');
                            $('#errorModal').on('shown.bs.modal', function() {
                                $('.modal-backdrop').addClass('bg-danger');
                            });
                        }
                    },
                    error: function() {
                        alert('Error occurred while processing your request.');
                    }
                });
            });
            $('#success').click(function() {
                $('#successModal').modal('hide');
            });

            
            $('#error').click(function() {
                $('#errorModal').modal('hide');
            });
        });
    </script>
@endsection
