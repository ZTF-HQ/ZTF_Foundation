<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ config('app.name') }} - Tableau de bord Ouvriers</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/staff-dashboard.css?v=' . filemtime(public_path('css/staff-dashboard.css'))) }}">
</head>
<body>
  @include('partials.welcome-message')
  
  <!-- Mobile Overlay -->
  <div class="sidebar-overlay" onclick="toggleMobileSidebar()"></div>
  
  <div class="dashboard-wrapper">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="logo">
          <i class="fas fa-user-tie"></i>
          <span>STAFF</span>
        </div>
        <button class="sidebar-toggle" onclick="toggleSidebar()">
          <i class="fas fa-bars"></i>
        </button>
      </div>

      <nav class="sidebar-nav">
        <ul>
          <li>
            <a href="{{ route('staff.dashboard') }}" class="nav-link active">
              <i class="fas fa-home"></i>
              <span>Tableau de bord</span>
            </a>
          </li>
          <li>
            <a href="{{ route('profile.edit') }}" class="nav-link">
              <i class="fas fa-user"></i>
              <span>Mon Profil</span>
            </a>
          </li>
          <li>
            <a href="{{ route('home') }}" class="nav-link">
              <i class="fas fa-globe"></i>
              <span>Site Web</span>
            </a>
          </li>
          <li class="divider"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="nav-link logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Déconnexion</span>
              </button>
            </form>
          </li>
        </ul>
      </nav>

      <div class="sidebar-footer">
        <div class="user-card">
          <div class="user-avatar">
            <i class="fas fa-user"></i>
          </div>
          <div class="user-info">
            <p class="user-name">{{ $user->name ?? $user->email }}</p>
            <p class="user-role">Staff</p>
          </div>
        </div>
      </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
      <!-- HEADER -->
      <div class="page-header">
        <div class="header-left">
          <button class="mobile-menu-toggle" onclick="toggleMobileSidebar()">
            <i class="fas fa-bars"></i>
          </button>
          <h1>Tableau de Bord</h1>
          <p class="breadcrumb">
            <a href="{{ route('staff.dashboard') }}">Accueil</a> / Espace Personnel
          </p>
        </div>
        <div class="header-right">
          <span class="status-badge">
            <span class="status-dot"></span>
            En ligne
          </span>
        </div>
      </div>

      <!-- CONTAINER -->
      <div class="container">
        <!-- PROFILE CARD -->
        <div class="profile-section">
          <div class="profile-card">
            <div class="avatar"><i class="fas fa-user"></i></div>
            <div class="profile-info">
              <h2>{{ $user->matricule }}</h2>
              <div class="profile-meta">
                <div><i class="fas fa-envelope"></i>{{ $user->email }}</div>
                <div><i class="fas fa-building"> </i>Departement : {{ $user->department->name ?? 'Non assigné' }}</div>
                <div><i class="fas fa-briefcase">  </i>Service : 
                  @if($user->services->isNotEmpty())
                    {{ $user->services->first()->name }}
                  @else
                    Non assigné
                  @endif
                </div>
                <div><i class="fas fa-user-tie"></i>Rôle : {{ $user->roles->isNotEmpty() ? $user->roles->first()->display_name : 'Non défini' }}</div>
              </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
              <i class="fas fa-user-edit"></i> Modifier mon profil
            </a>
          </div>
        </div>

        <!-- FORMULAIRE HQ STAFF -->
        @if($lastForm)
        <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); padding: 2rem; border-radius: 10px; margin: 2rem 0; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
          <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
            <div>
              <h3 style="margin: 0 0 0.5rem 0; color: white;"><i class="fas fa-file-contract"></i> Votre Formulaire HQ Staff</h3>
              <p style="margin: 0; color: rgba(255,255,255,0.9); font-size: 0.9rem;">Dernière soumission : <strong>{{ $lastForm->created_at->format('d/m/Y H:i') }}</strong></p>
            </div>
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
              <a href="{{ route('staff.form.edit', $lastForm->id) }}" class="btn btn-warning" style="background: #ff6b6b; border: none; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <i class="fas fa-edit"></i> Modifier
              </a>
              <a href="{{ route('staff.form.download', $lastForm->id) }}" class="btn btn-success" style="background: #51cf66; border: none; color: white; padding: 0.75rem 1.5rem; border-radius: 5px; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <i class="fas fa-download"></i> Télécharger
              </a>
            </div>
          </div>
        </div>
        @else
        <div style="background: #f8f9fa; padding: 2rem; border-radius: 10px; margin: 2rem 0; border-left: 4px solid #ffc107; text-align: center;">
          <i class="fas fa-info-circle" style="font-size: 2rem; color: #ffc107; margin-bottom: 1rem;"></i>
          <h3 style="margin: 0.5rem 0;">Aucun formulaire soumis</h3>
          <p style="margin: 0.5rem 0; color: #666;">Remplissez le formulaire HQ Staff 9 sections pour commencer votre dossier</p>
          <a href="{{ route('BigForm') }}" class="btn btn-primary" style="margin-top: 1rem; background: #007bff; border: none; color: white; padding: 0.75rem 2rem; border-radius: 5px; text-decoration: none; display: inline-block; cursor: pointer;">
            <i class="fas fa-file-alt"></i> Remplir le formulaire
          </a>
        </div>
        @endif

        <!-- STATISTIQUES PRINCIPALES -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
          <!-- Formule soumis -->
          <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; justify-content: space-between;">
              <div>
                <p style="font-size: 0.9rem; opacity: 0.9; margin: 0;">Formulaires Soumis</p>
                <h3 style="font-size: 2.5rem; font-weight: bold; margin: 0.5rem 0;">{{ $totalFormsSubmitted }}</h3>
              </div>
              <i class="fas fa-file-alt" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
          </div>

          <!-- PDFs générés -->
          <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; justify-content: space-between;">
              <div>
                <p style="font-size: 0.9rem; opacity: 0.9; margin: 0;">PDFs Générés</p>
                <h3 style="font-size: 2.5rem; font-weight: bold; margin: 0.5rem 0;">{{ $totalPDFsGenerated }}</h3>
              </div>
              <i class="fas fa-file-pdf" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
          </div>

          <!-- Complétion du profil -->
          <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; justify-content: space-between;">
              <div>
                <p style="font-size: 0.9rem; opacity: 0.9; margin: 0;">Profil Complété</p>
                <h3 style="font-size: 2.5rem; font-weight: bold; margin: 0.5rem 0;">{{ $profileCompletion }}%</h3>
              </div>
              <i class="fas fa-chart-pie" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
          </div>

          <!-- Collègues -->
          <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; justify-content: space-between;">
              <div>
                <p style="font-size: 0.9rem; opacity: 0.9; margin: 0;">Collègues</p>
                <h3 style="font-size: 2.5rem; font-weight: bold; margin: 0.5rem 0;">{{ $departmentColleagues }}</h3>
              </div>
              <i class="fas fa-users" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
          </div>
        </div>

        <!-- GRID -->
        <div class="grid">
          <!-- DEPARTEMENT -->
          <div class="card">
            <div class="card-header">
              <h3><i class="fas fa-building"></i> Mon Département</h3>
              @if($user->department)
                <span class="badge badge-success">Actif</span>
              @else
                <span class="badge badge-danger">Inactif</span>
              @endif
            </div>
            @if($user->department)
              <div class="card-content">
                <p><strong>Nom :</strong> {{ $user->department->name }}</p>
                <p><strong>Chef de Departement :</strong> {{ $user->department->head->name ?? 'Non renseigné' }}</p>
                <p><strong>Description :</strong> {{ Str::limit($user->department->description,150) }}</p>
              </div>
            @else
              <p class="text-gray-500" style="padding: 1.5rem;">Vous n'êtes pas encore assigné à un département.</p>
            @endif
          </div>

          <!-- SERVICES -->
          <div class="card">
            <div class="card-header">
              <h3><i class="fas fa-briefcase"></i> Mes Services</h3>
              @if($user->services->isNotEmpty())
                <span class="badge badge-success">{{ $totalServices }}</span>
              @endif
            </div>
            @if($user->services->isNotEmpty())
              <div class="card-content">
                @foreach($user->services as $service)
                  <p>
                    <i class="fas fa-check-circle" style="color: var(--success-color);"></i>
                    <strong>{{ $service->name }}</strong>
                  </p>
                @endforeach
              </div>
            @else
              <p class="text-gray-500" style="padding: 1.5rem;">Vous n'êtes pas encore assigné à un service.</p>
            @endif
          </div>

          <!-- COMPTE -->
          <div class="card">
            <div class="card-header">
              <h3><i class="fas fa-user-shield"></i> État du Compte</h3>
            </div>
            <div class="card-content">
              <p><i class="fas fa-circle" style="color: {{ $recentActivities['is_online'] ? '#43e97b' : '#cccccc' }};"></i> Statut : 
                <span class="badge {{ $recentActivities['is_online'] ? 'badge-success' : 'badge-warning' }}">
                  {{ $recentActivities['is_online'] ? 'En ligne' : 'Hors ligne' }}
                </span>
              </p>
              <p><i class="fas fa-clock"></i> Dernière connexion : {{ $recentActivities['last_login'] }}</p>
              <p><i class="fas fa-calendar-check"></i> Compte créé le : {{ $user->created_at->format('d/m/Y H:i') }}</p>
            </div>
          </div>
        </div>

        <!-- FORMULAIRES RÉCENTS -->
        @if($recentForms->isNotEmpty())
        <div class="card" style="margin-top: 2rem;">
          <div class="card-header">
            <h3><i class="fas fa-file-alt"></i> Formulaires Récents</h3>
            <span class="badge badge-info">{{ $recentForms->count() }}</span>
          </div>
          <div class="card-content">
            <div style="overflow-x: auto;">
              <table style="width: 100%; border-collapse: collapse;">
                <thead>
                  <tr style="border-bottom: 2px solid #e0e0e0;">
                    <th style="text-align: left; padding: 1rem; font-weight: 600;">Nom</th>
                    <th style="text-align: left; padding: 1rem; font-weight: 600;">Email</th>
                    <th style="text-align: left; padding: 1rem; font-weight: 600;">Date</th>
                    <th style="text-align: center; padding: 1rem; font-weight: 600;">Statut</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($recentForms as $form)
                  <tr style="border-bottom: 1px solid #f0f0f0;">
                    <td style="padding: 1rem;">{{ $form->fullName }}</td>
                    <td style="padding: 1rem;">{{ $form->email }}</td>
                    <td style="padding: 1rem;">{{ $form->created_at->format('d/m/Y H:i') }}</td>
                    <td style="padding: 1rem; text-align: center;">
                      <span class="badge badge-success">Soumis</span>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        @endif

        <!-- PDFs TÉLÉCHARGÉS -->
        @if($staffPdfs->isNotEmpty())
        <div class="card" style="margin-top: 2rem;">
          <div class="card-header">
            <h3><i class="fas fa-file-pdf"></i> PDFs Téléchargés</h3>
            <span class="badge badge-info">{{ $staffPdfs->count() }}</span>
          </div>
          <div class="card-content">
            <div style="overflow-x: auto;">
              <table style="width: 100%; border-collapse: collapse;">
                <thead>
                  <tr style="border-bottom: 2px solid #e0e0e0;">
                    <th style="text-align: left; padding: 1rem; font-weight: 600;">Fichier</th>
                    <th style="text-align: left; padding: 1rem; font-weight: 600;">Date de création</th>
                    <th style="text-align: center; padding: 1rem; font-weight: 600;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($staffPdfs as $pdf)
                  <tr style="border-bottom: 1px solid #f0f0f0;">
                    <td style="padding: 1rem;">
                      <i class="fas fa-file-pdf" style="color: #f5576c; margin-right: 0.5rem;"></i>
                      {{ Str::limit($pdf->filename, 40) }}
                    </td>
                    <td style="padding: 1rem;">{{ $pdf->created_at->format('d/m/Y H:i') }}</td>
                    <td style="padding: 1rem; text-align: center;">
                      <a href="{{ Storage::url($pdf->pdf_file) }}" class="btn btn-sm btn-primary" target="_blank">
                        <i class="fas fa-download"></i> Télécharger
                      </a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        @endif

        <!-- ACTIVITÉS -->
        <div class="card" style="margin-top: 2rem;">
          <div class="card-header">
            <h3><i class="fas fa-history"></i> Activités Récentes</h3>
          </div>
          <div class="card-content">
            <ul class="activity">
              <li>
                <div class="activity-icon"><i class="fas fa-sign-in-alt"></i></div>
                <div class="activity-content">
                  <h4>Dernière connexion</h4>
                  <p>{{ $recentActivities['last_login'] }}</p>
                </div>
              </li>
              <li>
                <div class="activity-icon"><i class="fas fa-user-edit"></i></div>
                <div class="activity-content">
                  <h4>Dernière mise à jour du profil</h4>
                  <p>{{ $recentActivities['profile_updated'] }}</p>
                </div>
              </li>
              <li>
                <div class="activity-icon"><i class="fas fa-mouse"></i></div>
                <div class="activity-content">
                  <h4>Dernière activité</h4>
                  <p>{{ $recentActivities['last_activity'] }}</p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    function toggleSidebar() {
      const sidebar = document.querySelector('.sidebar');
      sidebar.classList.toggle('collapsed');
    }

    function toggleMobileSidebar() {
      const sidebar = document.querySelector('.sidebar');
      const overlay = document.querySelector('.sidebar-overlay');
      
      sidebar.classList.toggle('active');
      if (overlay) {
        overlay.classList.toggle('active');
      }
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
      const sidebar = document.querySelector('.sidebar');
      const toggle = document.querySelector('.mobile-menu-toggle');
      
      if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
        if (window.innerWidth <= 768) {
          sidebar.classList.remove('active');
          const overlay = document.querySelector('.sidebar-overlay');
          if (overlay) {
            overlay.classList.remove('active');
          }
        }
      }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
      const sidebar = document.querySelector('.sidebar');
      if (window.innerWidth > 768) {
        sidebar.classList.remove('active');
        const overlay = document.querySelector('.sidebar-overlay');
        if (overlay) {
          overlay.classList.remove('active');
        }
      }
    });
  </script>
</body>
</html>

