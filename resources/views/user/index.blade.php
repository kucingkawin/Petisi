@extends('user.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-bottom: 10px">
                <div class="card-header">Dashboard User</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Selamat datang di dashboard user, <strong>{{ Auth::user()->name }}</strong>. Berikut adalah data terakhir pada akun ini.</p>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Nilai</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Banyak Petisi Ditandatangani</td>
                                <td>{{ $banyakPetisiDitandatangani[0]->nilai }}</td>
                                <td><a href="{{ route('user.petisiDitandatangani') }}">Lihat Petisi Ditandatangani</a></td>
                            </tr>
                            <tr>
                                <td>Banyak Petisi Saya (Dibuat)</td>
                                <td>{{ $banyakPetisiSaya[0]->nilai }}</td>
                                <td><a href="{{ route('user.petisiSaya') }}">Lihat Petisi Saya</a></td>
                            </tr>
                            <tr>
                                <td>Banyak Komentar</td>
                                <td>{{ $banyakKomentar[0]->nilai }}</td>
                                <td><a href="{{ route('user.petisiDikomentari') }}">Lihat Petisi Dikomentari</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card" style="margin-bottom: 10px">
                <div class="card-header">Petisi Tertinggi</div>

                <div class="card-body">                   
                    <canvas id="chartPetisiTertinggi" style='max-width: 500px' width="300" height="300"></canvas>
                </div>
            </div>
            <div class="card" style="margin-bottom: 10px">
                <div class="card-header">Komentator Terbanyak</div>

                <div class="card-body">
                    <canvas id="chartKomentatorTertinggi" style='max-width: 500px' width="300" height="300"></canvas>
                </div>
            </div>    
        </div>
    </div>
</div>
@endsection

@section('script')

@php
    //Untuk chart petisi tertinggi, $petisiTertinggi
    $i = 0;
    $labelPetisiTertinggi = '';
    $nilaiPetisiTertinggi = '';
    $warnaPetisiTertinggi = '';
    foreach($petisiTertinggi as $satuPetisiTertinggi)
    {
        $isiLabelPetisiTertinggi = "'" . $satuPetisiTertinggi->judul . "'";
        $isiNilaiPetisiTertinggi = $satuPetisiTertinggi->banyak_tanda_tangan_petisi;
        $isiWarnaPetisiTertinggi = "'rgba(255, 0, 0, 0.2)'";
        if($i == 0)
        {
            $labelPetisiTertinggi .= $isiLabelPetisiTertinggi;
            $nilaiPetisiTertinggi .= $isiNilaiPetisiTertinggi;
            $warnaPetisiTertinggi .= $isiWarnaPetisiTertinggi;
        }
        else
        {
            $labelPetisiTertinggi .= ", " . $isiLabelPetisiTertinggi;
            $nilaiPetisiTertinggi .= ', ' . $isiNilaiPetisiTertinggi;
            $warnaPetisiTertinggi .= ', ' . $isiWarnaPetisiTertinggi;
        }

        $i += 1;
    }

    //Untuk chart komentator tertinggi, $komentatorTertinggi
    $i = 0;
    $labelKomentatorTertinggi = '';
    $nilaiKomentatorTertinggi = '';
    $warnaKomentatorTertinggi = '';
    foreach($komentatorTertinggi as $satuKomentatorTertinggi)
    {
        $isiLabelKomentatorTertinggi = "'" . $satuKomentatorTertinggi->username . "'";
        $isiNilaiKomentatorTertinggi = $satuKomentatorTertinggi->banyak_komentar;
        $isiWarnaKomentatorTertinggi = "'rgba(0, 0, 255, 0.2)'";
        if($i == 0)
        {
            $labelKomentatorTertinggi .= $isiLabelKomentatorTertinggi;
            $nilaiKomentatorTertinggi .= $isiNilaiKomentatorTertinggi;
            $warnaKomentatorTertinggi .= $isiWarnaKomentatorTertinggi;
        }
        else
        {
            $labelKomentatorTertinggi .= ", " . $isiLabelKomentatorTertinggi;
            $nilaiKomentatorTertinggi .= ', ' . $isiNilaiKomentatorTertinggi;
            $warnaKomentatorTertinggi .= ', ' . $isiWarnaKomentatorTertinggi;
        }

        $i += 1;
    }
@endphp

<script src="{{ asset('js/chart.min.js') }}"></script>
<script>
    //Petisi tertinggi.
    var canvasChartPetisiTertinggi = document.getElementById('chartPetisiTertinggi').getContext('2d');
    var chartPetisiTertinggi = new Chart(canvasChartPetisiTertinggi, {
        type: 'bar',
        data: {
            labels: {!! '[' . $labelPetisiTertinggi . ']' !!},
            datasets: [{
                label: 'Banyak Tanda Tangan Petisi',
                data: {!! '[' . $nilaiPetisiTertinggi . ']' !!},
                backgroundColor: {!! '[' . $warnaPetisiTertinggi . ']' !!},
                borderColor: {!! '[' . $warnaPetisiTertinggi . ']' !!},
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }]
            }
        }
    });

    //Komentator tertinggi.
    var canvasChartKomentatorTertinggi = document.getElementById('chartKomentatorTertinggi').getContext('2d');
    var chartKomentatorTertinggi = new Chart(canvasChartKomentatorTertinggi, {
        type: 'bar',
        data: {
            labels: {!! '[' . $labelKomentatorTertinggi . ']' !!},
            datasets: [{
                label: 'Banyak Komentar',
                data: {!! '[' . $nilaiPetisiTertinggi . ']' !!},
                backgroundColor: {!! '[' . $warnaKomentatorTertinggi . ']' !!},
                borderColor: {!! '[' . $warnaKomentatorTertinggi . ']' !!},
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }]
            }
        }
    });
</script>
@endsection
