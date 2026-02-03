<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('dashboards.css')}}">
</head>
<body>
        <div class="actions-grid">
            <a href="{{route('permissions.index')}}" class="action-card">
                <i class="fas fa-user-shield action-icon"></i>


                    <h3>Liste des Permission avec role associe</h3>
            </a>
            <a href="{{route('permissions.create')}}" class="action-card">
                <i class="fas fa-user-shield action-icon"></i><i class="fas fa-key fa-2x action-icon"></i>

                <h3>Cree une Permission avec role associe</h3>
            </a>
            <a href="#" class="action-card">
                <i class="fas fa-chart-line action-icon"></i>
            <h3>Statistiques d'utilisation</h3>
            </a>
        </div>
</body>
</html>