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
            <h1>Select Hasil E-Voting</h1>
            <form action="{{route('beranda.hasil')}}" method="get">
                <div class="input-group mb-3 w-50 mx-auto">
                    <select class="form-control  " name="search" aria-label="Search"
                        aria-describedby="button-addon2">
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

    <section id="pemilu">
        <div class="container mb-5 mt-5">
            <div class="row">
                <div class="col border-bottom p-2 text-center">
                    <h1>E-voting Hasil</h1>
                </div>
            </div>
            <div class="row d-flex justify-content-center mt-4 mb-5" >
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
