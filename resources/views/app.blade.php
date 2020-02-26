<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simulator Empire</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            min-height: 100vh;
            margin: 0;
        }

        .alert {
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-8">
                <h1 class="text-left">SIMULASI MONTE CARLO APP</h1>
            </div>
            <div class="col-4 d-flex align-items-center justify-content-end">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="#" class="btn btn-primary">Monte Carlo</a>
                    <a href="/regresi" class="btn btn-secondary">Regresi</a>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-3">
                <form action="{{ route('addRequest') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input autocomplete="off" type="number" class="form-control" placeholder="Jumlah permintaan"
                            name="qty" aria-label="Jumlah permintaan" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" id="button-addon2">Add</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-9">
                @if (\Session::has('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Yeay !</strong> Data berhasil ditambahkan
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-3">
                <h3>Data Awal</h3>
                <table class="table table-bordered table-striped">
                    <tr class="thead-dark">
                        <th>Hari Ke</th>
                        <th>Jumlah</th>
                    </tr>
                    @foreach ($request as $item)
                    <tr>
                        <td align="center">{{$item->days_to}}</td>
                        <td align="center">{{$item->qty}}</td>
                    </tr>
                    @endforeach
                </table>

                @php
                $pages = $request->getUrlRange('1', $request->lastPage());
                @endphp
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="{{$request->previousPageUrl()}}">Prev</a></li>
                        @foreach ($pages as $item)
                        @if ($item === $request->url($request->currentPage()))
                        <li class="page-item active"><a class="page-link" href="#">{{$request->currentPage()}}</a></li>
                        @else
                        @if ($loop->iteration <= 2) <li class="page-item"><a class="page-link"
                                href="{{$item}}">{{$loop->iteration}}</a></li>
                            @endif
                            @if ($item === $request->url($request->lastPage()))
                            <li class="page-item"><a class="page-link"
                                    href="{{$request->url($request->lastPage())}}">{{$request->lastPage()}}</a></li>
                            @endif
                            @endif
                            @endforeach
                            <li class="page-item"><a class="page-link" href="{{$request->nextPageUrl()}}">Next</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-12">
                        <h3>Grouping</h3>
                        <table class="table table-bordered table-striped">
                            <tr class="thead-dark">
                                <th>Group Jumlah</th>
                                <th>Frekuensi Permintaan</th>
                                <th>Probabilitas</th>
                                <th>Komulatif</th>
                                <th>Interval</th>
                            </tr>
                            @php
                            $currentKomulatif = 0;
                            $currentInterval = 0;
                            $mapInterval = [];
                            @endphp
                            @foreach ($group as $item)
                            <tr>
                                <td align="center">{{ $item->qty }}</td>
                                <td align="center">{{ $item->count }}</td>
                                @php
                                $probabilitas = $item->count / $request->total();
                                @endphp
                                <td align="center">{{ number_format((float)$probabilitas, 2, '.', '') }}</td>
                                @php
                                $currentKomulatif;
                                $currentKomulatif += $item->count / $request->total();
                                @endphp
                                <td align="center">{{ number_format((float)$currentKomulatif, 2, '.', '') }}</td>
                                <td align="center">{{ number_format((float)$currentInterval, 2, '.', '') }} -
                                    {{ number_format((float)$currentKomulatif, 2, '.', '')}}</td>
                                @php
                                $interval = [
                                'min' => $currentInterval,
                                'max' => $currentKomulatif,
                                'value' => $item->qty
                                ];
                                array_push($mapInterval, $interval);
                                $currentInterval = $currentKomulatif + 0.01;
                                @endphp
                            </tr>
                            @endforeach
                            <tr>
                                <td align="center" class="font-weight-bold">Jumlah</td>
                                <td align="center" class="font-weight-bold">{{ $request->total() }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <hr>
                        <h3>Prediksi Permintaan 10 Hari Kedepan</h3>
                        <hr>
                        <table class="table table-bordered table-striped">
                            <tr class="thead-dark">
                                <th>Permintaan Laptop Hari Ke</th>
                                <th>Angka Acak</th>
                                <th>Permintaan</th>
                            </tr>
                            @for ($i = 0; $i < 10; $i++) <tr>
                                <td align="center">{{ $request->total() + $i + 1 }}</td>
                                @php
                                $randomVal = rand(0, 10) / 10;
                                @endphp
                                <td align="center">{{ $randomVal }}</td>
                                <td align="center">
                                    @foreach ($mapInterval as $item)
                                    @if ($randomVal >= $item['min'] && $randomVal <= $item['max']) {{ $item['value'] }}
                                        @endif @endforeach </td> </tr> @endfor </table> <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
</script>

</html>