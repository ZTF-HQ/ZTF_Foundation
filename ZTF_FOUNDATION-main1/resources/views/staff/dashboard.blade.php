<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Tableau de bord Staff</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboards.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        /* Cards & Sections */
        .stat-card { background: white; border-radius: 8px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s ease; }
        .stat-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.15); transform: translateY(-2px); }
        .stat-card.gradient-blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .stat-card.gradient-pink { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
        .stat-card.gradient-cyan { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
        .stat-card.gradient-green { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; }
        .stat-card-title { font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.5rem; }
        .stat-card-value { font-size: 2.5rem; font-weight: 700; margin: 0.5rem 0; }
        
        /* Sections */
        .section-card { background: white; border-radius: 8px; padding: 1.5rem; margin-top: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .section-card h2 { margin: 0 0 1.5rem 0; color: #1e293b; display: flex; align-items: center; gap: 0.75rem; font-size: 1.25rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 1rem; }
        .section-card h2 i { color: #667eea; font-size: 1.5rem; }
        
        /* Form Section */
        .form-section { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); padding: 1.5rem; border-radius: 8px; margin: 1.5rem 0; }
        .form-section h3 { color: white; margin: 0 0 0.5rem 0; display: flex; align-items: center; gap: 0.5rem; }
        
        /* Buttons */
        .btn-group { display: flex; gap: 0.5rem; flex-wrap: wrap; }
        .btn-group .btn { padding: 0.75rem 1.5rem; border: none; border-radius: 5px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer; transition: all 0.3s; font-weight: 500; }
        .btn-modify { background: #ff6b6b; color: white; }
        .btn-modify:hover { background: #ff5252; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4); }
        .btn-download { background: #51cf66; color: white; }
        .btn-download:hover { background: #40c057; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(81, 207, 102, 0.4); }
        .btn-fill { background: #007bff; color: white; }
        .btn-fill:hover { background: #0056b3; transform: translateY(-2px); }
        
        /* Empty State */
        .empty-state { background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 3rem 2rem; border-radius: 8px; border-left: 4px solid #ffc107; text-align: center; }
        .empty-state i { font-size: 2.5rem; color: #ffc107; margin-bottom: 1rem; display: inline-block; }
        .empty-state h3 { color: #1e293b; margin: 0.5rem 0; }
        .empty-state p { color: #64748b; margin: 0.5rem 0; }
        
        /* Tables */
        .table-responsive { overflow-x: auto; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th { background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); padding: 1rem; text-align: left; font-weight: 600; color: #475569; border-bottom: 2px solid #e2e8f0; }
        td { padding: 1rem; border-bottom: 1px solid #e2e8f0; }
        tr:hover { background: #f8fafc; }
        tr:last-child td { border-bottom: none; }
        
        /* Badges */
        .badge { display: inline-block; padding: 0.35rem 0.85rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .badge-info { background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd; }
        
        /* Info Cards */
        .info-card { padding: 1.25rem; border-left: 4px solid; background: #f8f9fa; border-radius: 4px; transition: all 0.3s; }
        .info-card:hover { transform: translateX(4px); }
        .info-card.primary { border-left-color: #667eea; }
        .info-card.warning { border-left-color: #f59e0b; }
        .info-card.success { border-left-color: #22c55e; }
        .info-card h4 { margin: 0 0 0.5rem 0; color: #1e293b; display: flex; align-items: center; gap: 0.5rem; font-size: 1rem; }
        .info-card h4 i { font-size: 1.1rem; }
        .info-card p { margin: 0; color: #64748b; font-size: 0.9rem; }
        
        /* Responsive */
        @media (max-width: 768px) {
            .btn-group { flex-direction: column; }
            .btn-group .btn { width: 100%; justify-content: center; }
            .info-card { margin-bottom: 1rem; }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">ZTF FOUNDATION</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->matricule ?? 'STAFF' }}</div>
                    <div class="user-role">Staff</div>
                </div>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="{{ route('staff.dashboard') }}" class="nav-link active">
                            <i class="fas fa-home"></i>
                            Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile.edit') }}" class="nav-link">
                            <i class="fas fa-user-circle"></i>
                            Mon Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('BigForm') }}" class="nav-link">
                            <i class="fas fa-file-alt"></i>
                            Formulaire
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link">
                            <i class="fas fa-globe"></i>
                            Site Web
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="nav-link">
                            @csrf
                            <i class="fas fa-sign-out-alt"></i>
                            <button type="submit" style="background: none; border: none; color: inherit; padding: 0; cursor: pointer;">
                                Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Tableau de Bord</h1>
                <div class="breadcrumb">Accueil / Espace Personnel</div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card gradient-blue">
                    <div class="stat-card-title"><i class="fas fa-file-alt"></i> Formulaires Soumis</div>
                    <div class="stat-card-value">{{ $totalFormsSubmitted }}</div>
                </div>
                <div class="stat-card gradient-pink">
                    <div class="stat-card-title"><i class="fas fa-file-pdf"></i> PDFs Générés</div>
                    <div class="stat-card-value">{{ $totalPDFsGenerated }}</div>
                </div>
                <div class="stat-card gradient-cyan">
                    <div class="stat-card-title"><i class="fas fa-chart-pie"></i> Profil Complété</div>
                    <div class="stat-card-value">{{ $profileCompletion }}%</div>
                </div>
                <div class="stat-card gradient-green">
                    <div class="stat-card-title"><i class="fas fa-users"></i> Collègues</div>
                    <div class="stat-card-value">{{ $departmentColleagues }}</div>
                </div>
            </div>

            <!-- Formulaire HQ Staff Section -->
            @if($lastForm)
            <div class="form-section">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h3><i class="fas fa-file-contract"></i> Votre Formulaire HQ Staff</h3>
                        <p style="margin: 0; opacity: 0.95; font-size: 0.9rem;">Dernière soumission : <strong>{{ $lastForm->created_at->format('d/m/Y H:i') }}</strong></p>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('staff.form.edit', $lastForm->id) }}" class="btn btn-modify">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="{{ route('staff.form.download', $lastForm->id) }}" class="btn btn-download">
                            <i class="fas fa-download"></i> Télécharger
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="empty-state">
                <i class="fas fa-info-circle"></i>
                <h3>Aucun formulaire soumis</h3>
                <p>Remplissez le formulaire HQ Staff 9 sections pour commencer votre dossier</p>
                <a href="{{ route('BigForm') }}" class="btn btn-fill" style="margin-top: 1rem; display: inline-block;">
                    <i class="fas fa-file-alt"></i> Remplir le formulaire
                </a>
            </div>
            @endif

            <!-- Info Cards Grid -->
            <div class="stats-grid" style="margin-top: 2rem;">
                <div class="stat-card">
                    <h3 style="margin: 0 0 1rem 0; color: #667eea; display: flex; align-items: center; gap: 0.5rem; font-size: 1rem;">
                        <i class="fas fa-building"></i> Mon Département
                    </h3>
                    @if($user->department)
                        <p style="margin: 0.5rem 0; font-weight: 600; color: #1e293b;">{{ $user->department->name }}</p>
                        <p style="margin: 0.5rem 0; color: #64748b; font-size: 0.875rem;">
                            <i class="fas fa-user-tie" style="color: #667eea; margin-right: 0.5rem;"></i>
                            Chef : {{ $user->department->head->name ?? 'Non assigné' }}
                        </p>
                    @else
                        <p style="margin: 0.5rem 0; color: #64748b; text-align: center; padding: 1rem 0;">
                            <i class="fas fa-info-circle" style="color: #ffc107; margin-right: 0.5rem;"></i>
                            Vous n'êtes pas assigné à un département
                        </p>
                    @endif
                </div>

                <div class="stat-card">
                    <h3 style="margin: 0 0 1rem 0; color: #667eea; display: flex; align-items: center; gap: 0.5rem; font-size: 1rem;">
                        <i class="fas fa-briefcase"></i> Mes Services ({{ $totalServices }})
                    </h3>
                    @if($user->services->isNotEmpty())
                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                            @foreach($user->services as $service)
                                <span class="badge badge-info"><i class="fas fa-check-circle" style="margin-right: 0.3rem;"></i>{{ $service->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <p style="margin: 0.5rem 0; color: #64748b; text-align: center; padding: 1rem 0;">
                            <i class="fas fa-info-circle" style="color: #ffc107; margin-right: 0.5rem;"></i>
                            Non assigné à un service
                        </p>
                    @endif
                </div>

                <div class="stat-card">
                    <h3 style="margin: 0 0 1rem 0; color: #667eea; display: flex; align-items: center; gap: 0.5rem; font-size: 1rem;">
                        <i class="fas fa-user-shield"></i> État du Compte
                    </h3>
                    <p style="margin: 0.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-circle" style="color: {{ $recentActivities['is_online'] ? '#43e97b' : '#cbd5e1' }}; font-size: 0.6rem;"></i>
                        <strong style="color: #1e293b;">{{ $recentActivities['is_online'] ? 'En ligne' : 'Hors ligne' }}</strong>
                    </p>
                    <p style="margin: 0.5rem 0; color: #64748b; font-size: 0.875rem;">
                        <i class="fas fa-calendar" style="color: #667eea; margin-right: 0.5rem;"></i>
                        Depuis le {{ $user->created_at->format('d/m/Y') }}
                    </p>
                </div>
            </div>

            <!-- Formulaires Récents -->
            @if($recentForms->isNotEmpty())
            <div class="section-card">
                <h2>
                    <i class="fas fa-history"></i> Formulaires Récents
                </h2>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-user" style="margin-right: 0.5rem;"></i>Nom Complet</th>
                                <th><i class="fas fa-envelope" style="margin-right: 0.5rem;"></i>Email</th>
                                <th><i class="fas fa-calendar" style="margin-right: 0.5rem;"></i>Date de Soumission</th>
                                <th style="text-align: center;"><i class="fas fa-check" style="margin-right: 0.5rem;"></i>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentForms as $form)
                            <tr>
                                <td><strong>{{ $form->fullName }}</strong></td>
                                <td>{{ $form->email }}</td>
                                <td><span style="color: #64748b;">{{ $form->created_at->format('d/m/Y H:i') }}</span></td>
                                <td style="text-align: center;"><span class="badge badge-success">✓ Soumis</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- PDFs Téléchargés -->
            @if($staffPdfs->isNotEmpty())
            <div class="section-card">
                <h2>
                    <i class="fas fa-file-pdf"></i> PDFs Téléchargés
                </h2>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-file-pdf" style="margin-right: 0.5rem;"></i>Fichier</th>
                                <th><i class="fas fa-calendar-check" style="margin-right: 0.5rem;"></i>Date de Création</th>
                                <th style="text-align: center;"><i class="fas fa-cogs" style="margin-right: 0.5rem;"></i>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staffPdfs as $pdf)
                            <tr>
                                <td>
                                    <i class="fas fa-file-pdf" style="color: #f5576c; margin-right: 0.5rem;"></i>
                                    <strong>{{ Str::limit($pdf->filename, 40) }}</strong>
                                </td>
                                <td><span style="color: #64748b;">{{ $pdf->created_at->format('d/m/Y H:i') }}</span></td>
                                <td style="text-align: center;">
                                    <a href="{{ Storage::url($pdf->pdf_file) }}" class="btn btn-download" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                                        <i class="fas fa-download"></i> Télécharger
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Activités Récentes -->
            <div class="section-card">
                <h2>
                    <i class="fas fa-activity"></i> Activités Récentes
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                    <div class="info-card primary">
                        <h4><i class="fas fa-sign-in-alt"></i> Dernière connexion</h4>
                        <p>{{ $recentActivities['last_login'] }}</p>
                    </div>
                    <div class="info-card warning">
                        <h4><i class="fas fa-user-edit"></i> Profil mis à jour</h4>
                        <p>{{ $recentActivities['profile_updated'] }}</p>
                    </div>
                    <div class="info-card success">
                        <h4><i class="fas fa-mouse"></i> Dernière activité</h4>
                        <p>{{ $recentActivities['last_activity'] }}</p>
                    </div>
                </div>
            </div>

            <div style="padding: 2rem 0; text-align: center; color: #64748b; font-size: 0.875rem;">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }} - Tous droits réservés</p>
            </div>
        </main>
    </div>

    <script>
        // Auto-hide sidebar on mobile
        if (window.innerWidth <= 768) {
            document.querySelector('.sidebar').style.width = '0';
        }
    </script>
</body>
</html>
