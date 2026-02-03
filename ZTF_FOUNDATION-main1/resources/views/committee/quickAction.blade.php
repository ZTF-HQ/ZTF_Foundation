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
            <a href="{{route('staff.index')}}" class="action-card">
                <i class="fas fa-users action-icon"></i>

                    <h3>Liste des Utilisateurs en Enregistre </h3>
            </a> 
            <a href="{{route('staff.create')}}" class="action-card">
            <i class="fas fa-user-plus action-icon"></i>

                <h3>Ajouter un utilisateur</h3>
            </a>
            <a href="#" class="action-card">
                <i class="fas fa-chart-line action-icon"></i>
            <h3>Statistiques & Compte rendu du travail</h3>
            </a>
        </div>
</body>
</html>