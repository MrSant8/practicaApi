<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Asteroids</title>
</head>

<body>
    <div class="container">
        <h1 class="my-4">Data</h1>

        @foreach ($data['near_earth_objects'] as $date => $asteroids)
            <h2 class="my-3">{{ $date }}</h2>

            @foreach ($asteroids as $asteroid)
                <div class="card mb-3">
                    <div class="card-body">
                        <h3 class="card-title">{{ $asteroid['name'] }}</h3>
                        <p class="card-text">
                            <strong>Estimated Diameter:</strong> {{ $asteroid['estimated_diameter']['meters']['estimated_diameter_min'] }} - {{ $asteroid['estimated_diameter']['meters']['estimated_diameter_max'] }} meters
                        </p>
                        <p class="card-text">
                            <strong>Potentially Hazardous:</strong> {{ $asteroid['is_potentially_hazardous_asteroid'] ? 'Yes' : 'No' }}
                        </p>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
</body>

</html>l