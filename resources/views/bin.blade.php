<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <table id="cities" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>city</th>
                            <th>state</th>
                            <th>status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($cities as $city)

                        <tr>
                            <td>{{ $city->id }}</td>
                            <td>{{ $city->city_name }}</td>
                            <td>{{ $city->status }}</td>
                            <td>{{ $city->state_name }}</td>

                            <td><button class="btn btn-info"><a href="/restore/{{ $city->id }}">Restore</a></button></td>
                            <td><button class="btn btn-danger">Delete</button></td>
                        </tr>

                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</body>

</html>