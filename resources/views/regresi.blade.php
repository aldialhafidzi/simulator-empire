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
                <h1 class="text-left">REGRESI</h1>
            </div>
            <div class="col-4 d-flex align-items-center justify-content-end">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="#" class="btn btn-primary">Monte Carlo</a>
                    <a href="#" class="btn btn-secondary">Regresi</a>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-4">
                <form action="{{ route('addRegresi') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group">
                                <input required autocomplete="off" type="number" class="form-control" placeholder="X"
                                    name="x" aria-label="X" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" id="button-addon2">Add</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group">
                                <input required autocomplete="off" type="number" class="form-control" placeholder="Y"
                                    name="y" aria-label="Y" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" id="button-addon2">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-8">
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
            <div class="col-4">
                <h3>Data Awal : {{$jumlahData}} Data</h3>
                <table class="table table-bordered table-striped">
                    <tr class="thead-dark">
                        <th>No</th>
                        <th>X</th>
                        <th>Y</th>
                        <th>X^2</th>
                        <th>X * Y</th>
                    </tr>
                    @foreach ($request as $item)
                    <tr>
                        <td align="center">{{$loop->iteration}}</td>
                        <td align="center">{{$item->x}}</td>
                        <td align="center">{{$item->y}}</td>
                        <td align="center">{{$item->x_pangkat_dua}}</td>
                        <td align="center">{{$item->x_kali_y}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td align="center" class="font-weight-bold">Total</td>
                        <td align="center" class="font-weight-bold">{{$totalX}}</td>
                        <td align="center" class="font-weight-bold">{{$totalY}}</td>
                        <td align="center" class="font-weight-bold">{{$totalX_Pangkat_Dua}}</td>
                        <td align="center" class="font-weight-bold">{{$totalX_Kali_Y}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-8">
                <h3>Persamaan</h3>
                <table class="table table-bordered">
                    <tr>
                        <td align="center">a</td>
                        <td align="center">{{$data_a->a1}}</td>
                        <td align="center">{{$data_a->a2}}</td>
                        <td align="center" class="font-weight-bold">{{$data_a->a3}}</td>
                    </tr>
                    <tr>
                        <td align="center"></td>
                        <td align="center">{{$data_a->a4}}</td>
                        <td align="center">{{$data_a->a5}}</td>
                        <td align="center" class="font-weight-bold">{{$data_a->a6}}</td>
                    </tr>
                    <tr>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center" class="font-weight-bold">{{$data_a->a_total}}</td>
                    </tr>
                </table>
                <hr>
                <table class="table table-bordered">
                    <tr>
                        <td align="center">b</td>
                        <td align="center">{{$data_b->b1}}</td>
                        <td align="center">{{$data_b->b2}}</td>
                        <td align="center" class="font-weight-bold">{{$data_b->b3}}</td>
                    </tr>
                    <tr>
                        <td align="center"></td>
                        <td align="center">{{$data_b->b4}}</td>
                        <td align="center">{{$data_b->b5}}</td>
                        <td align="center" class="font-weight-bold">{{$data_b->b6}}</td>
                    </tr>
                    <tr>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center" class="font-weight-bold">{{$data_b->b_total}}</td>
                    </tr>
                </table>
                <h3>Penaksiran</h3>
                <table class="table table-bordered table-striped">
                    <tr>
                        <td align="center" class="font-weight-bold">X</td>
                        <td align="center" class="font-weight-bold">
                            {{ number_format((float)$penaksiran->x1, 3, '.', '')}}</td>
                        <td align="center" class="font-weight-bold">
                            {{ number_format((float)$penaksiran->x2, 3, '.', '')}}</td>
                        <td align="center" class="font-weight-bold">
                            {{ number_format((float)$penaksiran->x3, 3, '.', '')}}</td>
                        <td align="center" class="font-weight-bold">
                            {{ number_format((float)$penaksiran->x4, 3, '.', '')}}</td>
                        <td align="center" class="font-weight-bold">
                            {{ number_format((float)$penaksiran->x5, 3, '.', '')}}</td>
                        <td align="center" class="font-weight-bold">
                            {{ number_format((float)$penaksiran->x6, 3, '.', '')}}</td>
                        <td align="center" class="font-weight-bold">
                            {{ number_format((float)$penaksiran->x7, 3, '.', '')}}</td>
                    </tr>
                    <tr>
                        <td align="center" class="font-weight-bold">Y</td>
                        <td align="center" class="font-weight-bold">
                            {{ number_format((float)$penaksiran->y1, 3, '.', '')}}</td>
                        <td align="center" class="font-weight-bold">
                            {{ number_format((float)$penaksiran->y2, 3, '.', '')}}</td>
                        <td align="center" class="font-weight-bold">
                            {{ number_format((float)$penaksiran->y3, 3, '.', '')}}</td>
                        <td align="center" class="font-weight-bold">
                            {{ number_format((float)$penaksiran->y4, 3, '.', '')}}</td>
                        <td align="center" class="font-weight-bold">
                            {{ number_format((float)$penaksiran->y5, 3, '.', '')}}</td>
                        <td align="center" class="font-weight-bold">
                            {{ number_format((float)$penaksiran->y6, 3, '.', '')}}</td>
                        <td align="center" class="font-weight-bold">
                            {{ number_format((float)$penaksiran->y7, 3, '.', '')}}</td>
                    </tr>
                </table>
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