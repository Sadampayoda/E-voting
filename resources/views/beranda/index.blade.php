@extends('component.nav')


@section('content')
    <div class="content">
        @if (session()->has('success'))
            @include('component.alert', [
                'message' => session('success'),
                'status' => 'success',
            ])
        @endif
        <div class="container">
            <div class="row welcome-container">
                <div class="col-md-5">
                    <h1>Welcome E-Voting</h1>
                    <p>Selamat datang di halaman kami. Mohon untuk memberikan suara Anda!</p>
                    <p>Coblos dengan bijak dan bertanggung jawab.</p>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" id="search" placeholder="Search..." aria-label="Search"
                            aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-dark" id="searchButton" type="button" id="button-addon2">Search NIK</button>
                        </div>
                    </div>
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
