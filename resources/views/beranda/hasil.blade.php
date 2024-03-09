@extends('component.nav')


@section('content')
    {{-- @dd($select) --}}
    <div class="content">
        @if (session()->has('success'))
            @include('component.alert', [
                'message' => session('success'),
                'status' => 'success',
            ])
        @endif
        <div class="mt-5 pt-5">

        </div>
    </div>

    <section id="pemilu">
        <div class="container mb-5 mt-5">
            <div class="row">
                <div class="col border-bottom p-2 text-center">
                    <h1>E-voting Hasil</h1>
                </div>
            </div>
            <div class="row d-flex justify-content-center mt-4 mb-5">
                @if ($data)
                    <div class="col-5">
                        <div id="hasil">

                        </div>
                    </div>
                    <div class="col-7">
                        <div id="hasil2">

                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>


    <section id="pemilu">
        <div class="container mb-5 mt-5">
            <div class="row">
                <div class="col border-bottom p-2 text-center">
                    <h1>Kandidat</h1>
                </div>
            </div>
            <div class="row d-flex justify-content-center mt-4 mb-5">

                @foreach ($kandidat as $item)
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
                                        data-bs-target="#wakil">Lihat Wakil</button>

                                </div>
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>



    <!-- Modal -->
    <div class="modal fade" id="wakil" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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

    {{-- @php

        var_dump($hasil);
        die();
    @endphp --}}


    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    @if ($data)
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                var suaraKandidat = {!! json_encode($chartHasil) !!};
                console.log(suaraKandidat)
                var dataGrafik = [];
                // suaraKandidat.forEach(function(item) {
                //     dataGrafik.push({
                //         name: item.nama,
                //         y: item.jumlah_suara
                //     });
                // });




                Highcharts.chart('hasil2', {
                    chart: {
                        type: 'spline'
                    },
                    title: {
                        text: 'Jumlah suara per tanggal'
                    },

                    subtitle: {
                        text: 'By Job Category. Source: <a href="https://irecusa.org/programs/solar-jobs-census/" target="_blank">IREC</a>.',
                        align: 'left'
                    },

                    yAxis: {
                        title: {
                            text: 'Jumlah Suara'
                        }
                    },

                    xAxis: {
                        categories: {!! json_encode($dateRange) !!}
                    },

                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },



                    series: suaraKandidat,

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }

                });

            });


            var hasil = {!! json_encode($hasil) !!};


            var dataHasil = [];
            hasil.forEach(function(hasil) {
                dataHasil.push({
                    name: hasil.name,
                    y: hasil.y
                });
            });

            Highcharts.chart('hasil', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Suara Kandidat'
                },
                tooltip: {
                    valueSuffix: '%'
                },
                subtitle: {
                    text: 'Source:<a href="https://www.mdpi.com/2072-6643/11/3/684/htm" target="_default">MDPI</a>'
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: [{
                            enabled: true,
                            distance: 20
                        }, {
                            enabled: true,
                            distance: -40,
                            format: '{point.percentage:.1f}%',
                            style: {
                                fontSize: '1.2em',
                                textOutline: 'none',
                                opacity: 0.7
                            },
                            filter: {
                                operator: '>',
                                property: 'percentage',
                                value: 10
                            }
                        }]
                    }
                },
                series: [{
                    name: 'Percentage',
                    colorByPoint: true,
                    data: dataHasil
                }]
            });
        </script>
    @endif
@endsection
