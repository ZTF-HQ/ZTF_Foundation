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
            <a href="{{route('roles.index')}}" class="action-card">
                <i class="fas fa-user-shield action-icon"></i>


                    <h3>Liste des Roles avec Permission associe</h3>
            </a>
            <a href="{{route('roles.create')}}" class="action-card">
                <i class="fas fa-user-shield action-icon"></i><i class="fas fa-key fa-2x action-icon"></i>

                <h3>Cree un Role avec Permission</h3>
            </a>
            <a href="#" class="action-card">
                <i class="fas fa-chart-line action-icon"></i>
            <h3>Assignation des roles</h3>
            </a>
        </div>
</body>
</html>