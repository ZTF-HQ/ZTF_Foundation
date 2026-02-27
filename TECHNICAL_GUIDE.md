# 🔧 ZTF FOUNDATION - GUIDE TECHNIQUE POUR DÉVELOPPEURS

**Document:** Quick Reference pour continuité du développement  
**Audience:** Développeurs reprenant le projet  
**Langue:** Français/Anglais  

---

## 1️⃣ DÉMARRAGE RAPIDE

### Installation & Setup
```bash
# Clone et setup
git clone <repo>
cd ZTF_FOUNDATION-main1

# Install dependencies
composer install
npm install

# Generate app key
php artisan key:generate

# Setup database
php artisan migrate
php artisan seed

# Install Passport (OAuth2)
php artisan passport:install

# Start dev server
composer run dev
# Ou séparément:
php artisan serve                    # Port 8000
php artisan queue:listen             # Background jobs
npm run dev                          # Vite dev server
```

### Vérifier l'installation
```bash
# Vérifier les migrations
php artisan migrate:status

# Vérifier les modèles
php artisan tinker
>>> App\Models\User::count()
>>> App\Models\Department::count()

# Vérifier les routes
php artisan route:list | grep dashboard

# Tester l'API
curl http://localhost:8000/api/v1/getAllUsers
```

---

## 2️⃣ COMMANDES ESSENTIELLES

### Laravel Artisan
```bash
# Modèles & Migrations
php artisan make:model NomModel -m      # Create model + migration
php artisan make:migration create_table # New migration
php artisan migrate                     # Run migrations
php artisan migrate:rollback            # Undo migrations
php artisan migrate:fresh               # Reset DB

# Controllers
php artisan make:controller NomController
php artisan make:controller NomController --model=User

# Tests
php artisan test                        # Run all tests
php artisan test --filter=UserTest      # Run specific test
composer test                           # Via composer script

# Debugging
php artisan tinker                      # Interactive shell
php artisan route:list                  # List all routes
php artisan config:clear                # Clear config cache
```

### Database
```bash
# Seeders
php artisan db:seed
php artisan db:seed --class=UserSeeder

# Fresh setup
php artisan migrate:fresh --seed

# Query Builder (in tinker)
>>> DB::table('users')->get()
>>> User::with('roles', 'permissions')->first()
```

---

## 3️⃣ ARCHITECTURE PATTERNS

### Model Relationships (Eloquent)

#### Types principales
```php
// 1:1 - Un à un
public function profile() {
    return $this->hasOne(Profile::class);
}
public function user() {
    return $this->belongsTo(User::class);
}

// 1:M - Un à plusieurs
public function posts() {
    return $this->hasMany(Post::class);
}
public function user() {
    return $this->belongsTo(User::class);
}

// M:M - Plusieurs à plusieurs (pivot table)
public function roles() {
    return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id')
                ->withTimestamps();
}
```

#### Dans ce projet
```php
// User - Department (M:1)
User::department()              // ✅ FK directe
User::departments()             // ⚠️ REDONDANT M:M

// User - Role (M:M)
User::roles()                   // Via role_users pivot

// User - Permission (M:M)
User::permissions()             // Via permission_users pivot

// User - Service (1:1 Principal + M:M Secondary)
User::primaryService()          // FK directe pour service principal
User::services()                // M:M pour services secondaires

// Department - Head (1:1)
Department::head()              // ✅ Correct (head_id FK)
Department::headDepartment()    // ❌ ERREUR - À SUPPRIMER
```

---

## 4️⃣ RÉPERTOIRE DE TOUS LES FICHIERS À RISQUE

### 🔴 FICHIERS CRITIQUES (Corriger immédiatement)

```
app/Models/Department.php
├─ Ligne ~50: ❌ public function headDepartment()
├─ Problème: belongsTo(User, 'user_id') - user_id n'existe pas
└─ Action: SUPPRIMER cette fonction

app/Models/User.php
├─ Ligne ~80: ❌ public function comite()
├─ Problème: belongsTo(Committee, 'department_id') - mauvaise clé
├─ Action: Corriger → belongsTo(Committee, 'committee_id')
└─ Ligne ~120: ❌ public function user() - duplique head()
   └─ Action: SUPPRIMER
```

### 🟠 FICHIERS AVEC AVERTISSEMENTS

```
app/Models/Permission.php
├─ Ligne ~: public function roles()
├─ Problème: Table pivot 'role_has_permissions' (incohérent)
└─ Action: Renommer table → 'permission_roles'

app/Models/Role.php
├─ ✅ OK - Table 'permission_roles' correcte

resources/views/staff/dashboard.blade.php
├─ Ligne 228: ❌ Erreur CSS dans style inline
├─ Problème: Blade syntax {{ }} dans attribut style
└─ Action: Utiliser :style Tailwind ou séparer style

public/css/welcome.css
├─ Lignes 58, 598: ⚠️ backdrop-filter sans -webkit-
└─ Action: Ajouter -webkit-backdrop-filter

public/app.css
├─ Lignes 1-3: @tailwind directives (linter warning)
├─ Lignes 91, 542, 918: backdrop-filter sans -webkit-
└─ Action: Même que welcome.css
```

### ✅ FICHIERS VÉRIFIÉS OK

```
app/Models/Role.php                ✅ Relations correctes
app/Models/Service.php             ✅ OK
app/Models/DepartmentSkill.php     ✅ OK
app/Http/Controllers/Auth/*        ✅ Auth opérationnel
app/Http/Controllers/Api/*         ✅ API OK
routes/web.php                     ✅ Routes définies
routes/api.php                     ✅ API routes OK
```

---

## 5️⃣ WORKFLOWS COURANTS

### Ajouter une nouvelle fonctionnalité

```bash
# 1. Créer le modèle
php artisan make:model NomModel -m

# 2. Définir la migration (database/migrations/...)
# Schema::create('nom_models', function (Blueprint $table) { ... })

# 3. Exécuter la migration
php artisan migrate

# 4. Ajouter les relations dans le modèle
# public function xxx() { return $this->xxxx(); }

# 5. Créer le controller
php artisan make:controller NomModelController --model=NomModel

# 6. Ajouter les routes (routes/web.php ou routes/api.php)
# Route::resource('nomModels', NomModelController::class);

# 7. Créer les vues (resources/views/nomModels/*)

# 8. Ajouter des tests (tests/Feature/NomModelTest.php)
php artisan make:test NomModelTest

# 9. Tester
php artisan test
```

### Ajouter une relation

```php
// 1. Dans le modèle principal
public function roles() {
    return $this->belongsToMany(
        Role::class, 
        'role_user',  // nom de la table pivot
        'user_id',    // foreign key du modèle actuel
        'role_id'     // foreign key du modèle associé
    )->withTimestamps();
}

// 2. Dans le modèle associé (inverse)
public function users() {
    return $this->belongsToMany(
        User::class,
        'role_user',
        'role_id',
        'user_id'
    )->withTimestamps();
}

// 3. Utiliser la relation
$user = User::find(1);
$user->roles;              // Charger les rôles
$user->roles()->attach(2); // Ajouter un rôle
$user->roles()->detach(2); // Enlever un rôle
$user->roles()->sync([1, 2]); // Synchroniser les rôles
```

### Ajouter une permission

```php
// 1. Créer une permission
Permission::create([
    'name' => 'edit-users',
    'display_name' => 'Edit Users',
    'description' => 'Can edit other users'
]);

// 2. L'attacher à un rôle
$role = Role::findByName('admin');
$permission = Permission::findByName('edit-users');
$role->permissions()->attach($permission);

// 3. Vérifier dans une vue
@can('edit-users')
    <a href="{{ route('users.edit', $user) }}">Edit</a>
@endcan

// 4. Vérifier dans un contrôleur
if ($user->can('edit-users')) {
    // do something
}
```

---

## 6️⃣ STRUCTURE DES VUES BLADE

### Layout Principal
```blade
<!-- resources/views/layouts/app.blade.php -->
<body>
    @if (auth()->check())
        @include('layouts.sidebar')
        <main>
            {{ $slot }}
        </main>
    @else
        <!-- Public layout -->
    @endif
</body>
```

### Component Pattern
```blade
<!-- Créer component -->
<x-dashboard.card title="Title">
    Contenu du component
</x-dashboard.card>

<!-- resources/views/components/dashboard/card.blade.php -->
<div class="card">
    <h2>{{ $title }}</h2>
    {{ $slot }}
</div>
```

### Directive Blade utiles
```blade
<!-- Authentification -->
@auth
    User is logged in
@else
    User is not logged in
@endauth

<!-- Autorisation -->
@can('edit-post', $post)
    <a href="#">Edit</a>
@endcan

<!-- Erreurs de formulaire -->
@error('email')
    <span class="error">{{ $message }}</span>
@enderror

<!-- Boucles -->
@foreach($users as $user)
    <p>{{ $user->name }}</p>
@empty
    <p>No users</p>
@endforeach

<!-- Conditions -->
@if (condition)
    <!-- code -->
@elseif (condition2)
    <!-- code -->
@else
    <!-- code -->
@endif
```

---

## 7️⃣ DEBUGGING & TROUBLESHOOTING

### Logs
```bash
# Voir les logs en temps réel
tail -f storage/logs/laravel.log

# Ou dans le code
Log::info('Message', ['context' => $value]);
Log::error('Error occurred', ['exception' => $e]);
```

### Tinker (Interactive Shell)
```bash
php artisan tinker

# Debugger une relation
>>> $user = User::find(1);
>>> $user->department;       // Charger department
>>> $user->roles()->pluck('name'); // Rôles
>>> $user->permissions;      // Permissions

# Tester une requête
>>> DB::table('users')->where('email', 'test@test.com')->first();
```

### Debugger dans le code
```php
// Dump & Die
dd($variable);      // Affiche et arrête

// Dump (continue)
dump($variable);    // Affiche et continue

// Log
Log::debug('Value:', ['var' => $variable]);
```

### Erreurs communes

| Erreur | Cause | Solution |
|--------|-------|----------|
| `SQLSTATE[HY000]: General error` | Migration échouée | `php artisan migrate:rollback && migrate` |
| `Class not found` | Autoload non rafraîchi | `composer dump-autoload` |
| `Call to undefined method` | Relation mal nommée | Vérifier le nom dans le modèle |
| `Integrity constraint violation` | FK invalide | Vérifier les IDs et tables |
| `TokenMismatchException` | CSRF token invalide | Ajouter `@csrf` dans le formulaire |

---

## 8️⃣ CONVENTIONS DU PROJET

### Nommage
```
Modèles:        User, Department, Role (Singular, PascalCase)
Tables:         users, departments, roles (Plural, snake_case)
Controllers:    UserController, DepartmentController (Noun + Controller)
Routes:         users, departments (Resource names, plural, kebab-case)
Views:          resources/views/users/index.blade.php (Plural folder)
Variables:      $user, $users, $department (camelCase)
Methods:        createUser(), updateDepartment() (Verb + Noun)
Properties:     protected $fillable, protected $casts
```

### API Versioning
```
/api/v1/users           - Version 1
/api/v2/users           - Version 2
```

### Middleware Pattern
```php
// Dans routes/web.php
Route::middleware('auth')->group(function () {
    // Protected routes
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin only
});
```

---

## 9️⃣ TESTING AVEC PEST

### Structure Test
```php
// tests/Feature/UserTest.php
use Tests\TestCase;

class UserTest extends TestCase {
    
    /** @test */
    public function user_can_view_profile() {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
                        ->get('/profile');
        
        $response->assertStatus(200);
        $response->assertSee($user->name);
    }
}
```

### Commandes Test
```bash
php artisan test                        # Tous les tests
php artisan test --filter=UserTest      # Test spécifique
php artisan test --filter=user_can      # Par method name
php artisan test tests/Feature/UserTest.php  # Fichier spécifique
```

---

## 🔟 RESSOURCES & DOCUMENTATION

### Documentation Officielle
- [Laravel 12 Docs](https://laravel.com/docs/12.x)
- [Eloquent Relations](https://laravel.com/docs/12.x/eloquent-relationships)
- [Blade Templates](https://laravel.com/docs/12.x/blade)
- [Authentication](https://laravel.com/docs/12.x/authentication)

### Tools & Services
- [Laravel Tinker](https://github.com/laravel/tinker)
- [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar)
- [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper)

### Dans le projet
- `ANALYSE_UML_MCD.md` - Analyse des modèles
- `PLAN_CORRECTION_MODELS.md` - Plan de corrections
- `STAFF_DASHBOARD_MOBILE_FIXES.md` - Fixes UI
- `STATE_OF_PROJECT.md` - État global (CE FICHIER)

---

## 1️⃣1️⃣ CHECKLIST AVANT DE COMMITTER

```bash
✅ Tester en local
   php artisan test

✅ Linter le code
   composer run pint

✅ Vérifier les migrations
   php artisan migrate:status

✅ Vérifier les erreurs
   php artisan config:clear

✅ Vérifier les logs
   tail -f storage/logs/laravel.log

✅ Tester l'API
   curl http://localhost:8000/api/v1/getAllUsers

✅ Committer avec message clairs
   git commit -m "Fix: Corriger relation headDepartment"
```

---

## 1️⃣2️⃣ CONTACT & SUPPORT

Pour les questions ou blocages:
1. Consulter la documentation (voir section 10)
2. Vérifier les logs: `storage/logs/laravel.log`
3. Utiliser tinker pour tester: `php artisan tinker`
4. Demander dans l'équipe

---

**Dernière mise à jour:** 3 février 2026  
**Version Laravel:** 12.x  
**Version PHP:** 8.2+  
**Status:** Documentation à jour
