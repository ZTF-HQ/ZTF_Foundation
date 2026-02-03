<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Services par Départements - {{config('app.name')}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/services-list.css') }}">
</head>
<body>
    <div class="container">
        <header class="page-header">
            <div class="header-content">
                <h1>Liste des Services par Départements</h1>
                <nav class="breadcrumb">
                    <a href="{{ route('committee.dashboard') }}">Tableau de bord</a> / 
                    <span>Liste des Services</span>
                </nav>
            </div>
            <div class="header-actions">
                <a href="{{ route('committee.dashboard') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </header>

        <main class="main-content">
            <div class="departments-container">
                @forelse($departments as $department)
                    <div class="department-card">
                        <div class="department-header">
                            <h2>
                                <i class="fas fa-building"></i>
                                {{ $department->name }}
                            </h2>
                            <span class="service-count">
                                {{ $department->services->count() }} service(s)
                            </span>
                        </div>
                        
                        <div class="services-list">
                            @if($department->services->count() > 0)
                                @foreach($department->services as $service)
                                    <div class="service-item">
                                        <div class="service-info">
                                            <i class="fas fa-cog service-icon"></i>
                                            <div class="service-details">
                                                <h3>{{ $service->name }}</h3>
                                                <p>{{ $service->description ?? 'Aucune description disponible' }}</p>
                                            </div>
                                        </div>
                                        <div class="service-stats">
                                            <div class="stat">
                                                <i class="fas fa-users"></i>
                                                <span>{{ $service->users_count ?? 0 }} employés</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="no-services">
                                    <i class="fas fa-info-circle"></i>
                                    <p>Aucun service dans ce département</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="no-departments">
                        <i class="fas fa-exclamation-circle"></i>
                        <h2>Aucun département trouvé</h2>
                        <p>Il n'y a actuellement aucun département enregistré dans le système.</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</body>
</html>