@extends('component.app')


@section('content')
    <div class="content">
        <div class="mt-5 pt-5">
            <h1 class="text-center">Select Hasil E-Voting</h1>
            <form action="{{ route('beranda.admin') }}" method="get">
                <div class="input-group mb-3 w-50 mx-auto">
                    <select class="form-control  " name="search" aria-label="Search" aria-describedby="button-addon2">
                        <option selected disabled>Select</option>
                        @foreach ($select as $item)
                            <option value="{{ $item->id }}">Kegiatan : {{ $item->kegiatan }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-dark" type="submit" id="button-addon2">Search kegiatan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <!-- Card Total User (Merah) -->
            <div class="col-md-3">
                <div class="card shadow bg-danger">
                    <div class="card-body">
                        <h5 class="card-title">Total User</h5>
                        <p class="card-text">{{$total_user}}</p>
                    </div>
                </div>
            </div>

            <!-- Card Total Kegiatan (Biru) -->
            <div class="col-md-3">
                <div class="card shadow bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Kegiatan</h5>
                        <p class="card-text">{{$total_kegiatan}}</p>
                    </div>
                </div>
            </div>

            <!-- Card Total Kandidat (Kuning) -->
            <div class="col-md-3">
                <div class="card shadow bg-warning">
                    <div class="card-body">
                        <h5 class="card-title">Total Kandidat</h5>
                        <p class="card-text">{{$total_kandidat}}</p>
                    </div>
                </div>
            </div>

            <!-- Card Total Suara (Hijau) -->
            <div class="col-md-3">
                <div class="card shadow bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Total Suara</h5>
                        <p class="card-text">{{$total_suara}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="pemilu">
        <div class="container mb-5 mt-5">
            <div class="row">
                <div class="col border-bottom p-2 text-center">
                    <h1>E-voting Hasil {{$kegiatan}}</h1>
                </div>
            </div>
            <div class="row d-flex justify-content-center mt-4 mb-5">
                @if ($data)
                    <div class="col">
                        <div id="hasil">

                        </div>
                    </div>
                    <div class="col">
                        <div id="hasil2">

                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>


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

                var suaraKandidat = {!! json_encode($data) !!};


                var dataGrafik = [];
                suaraKandidat.forEach(function(item) {
                    dataGrafik.push({
                        name: item.nama,
                        y: item.jumlah_suara
                    });
                });




                Highcharts.chart('hasil2', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Grafik Suara Kandidat'
                    },
                    xAxis: {
                        type: 'category',
                        title: {
                            text: 'Kandidat'
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Jumlah Suara'
                        }
                    },
                    series: [{
                        name: 'Jumlah Suara',
                        colorByPoint: true,
                        data: dataGrafik
                    }]
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
