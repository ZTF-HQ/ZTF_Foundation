# ✅ CHECKLIST - PROCHAINES ACTIONS

**Créé:** 3 février 2026  
**Pour:** Nouvelle IA reprenant le projet  
**Durée totale estimée:** 5-7 jours

---

## 📋 CHECKLIST PHASE 1 - CRITIQUE (Jour 1)

### ✂️ Supprimer `Department::headDepartment()`
- [ ] Ouvrir `app/Models/Department.php`
- [ ] Trouver la fonction `headDepartment()` (ligne ~50)
- [ ] Lire les 3 lignes avant/après pour confirmer
- [ ] Supprimer les ~3 lignes de la fonction
- [ ] Vérifier qu'il reste la fonction `head()` (qui est correcte)
- [ ] Commit: `git commit -m "Fix: Remove invalid headDepartment() relation"`
- [ ] Durée: **< 1 minute**
- [ ] Test: `php artisan tinker` → `Department::first()->head()` doit fonctionner

### 🔧 Corriger `User::comite()` → `User::committee()`
- [ ] Ouvrir `app/Models/User.php`
- [ ] Trouver la fonction `comite()` (ligne ~80)
- [ ] Remplacer `department_id` par `committee_id` dans belongsTo
- [ ] Optionnel: Renommer `comite()` en `committee()` pour cohérence
- [ ] Vérifier: Certifier que `users.committee_id` existe en DB
- [ ] Commit: `git commit -m "Fix: Correct committee foreign key in User model"`
- [ ] Durée: **< 2 minutes**
- [ ] Test: `php artisan tinker` → `User::first()->committee` doit fonctionner

### ✂️ Supprimer `User::user()` (dupliquée)
- [ ] Ouvrir `app/Models/User.php`
- [ ] Trouver la fonction `user()` (ligne ~120)
- [ ] Confirmer qu'elle fait la même chose que `head()`
- [ ] Supprimer la fonction `user()`
- [ ] Keeper la fonction `head()`
- [ ] Commit: `git commit -m "Fix: Remove duplicate user() method in User model"`
- [ ] Durée: **< 1 minute**
- [ ] Test: Vérifier que `User::first()->head()` fonctionne encore

### 🎨 Corriger erreur CSS ligne 228 (Blade style inline)
- [ ] Ouvrir `resources/views/staff/dashboard.blade.php`
- [ ] Aller à la ligne 228
- [ ] Identifier le problème: `{{ }}` dans attribut style
- [ ] OPTION A: Utiliser Tailwind `:style`
  ```blade
  <!-- AVANT -->
  <i style="color: {{ $recentActivities['is_online'] ? '#43e97b' : '#cbd5e1' }}; font-size: 0.6rem;"></i>
  
  <!-- APRÈS (Option A) -->
  <span :style="{ color: recentActivities.is_online ? '#43e97b' : '#cbd5e1' };">
    <i style="font-size: 0.6rem;"></i>
  </span>
  ```
- [ ] OPTION B: Séparer le style inline
  ```blade
  <span style="color: {{ $recentActivities['is_online'] ? '#43e97b' : '#cbd5e1' }};">
    <i class="fas fa-circle" style="font-size: 0.6rem;"></i>
  </span>
  ```
- [ ] Choisir l'option
- [ ] Appliquer la correction
- [ ] Commit: `git commit -m "Fix: Correct Blade syntax in dashboard inline style"`
- [ ] Durée: **2-5 minutes**
- [ ] Test: `npm run build` ne doit pas avoir d'erreur CSS

### ✅ Valider Phase 1
- [ ] Exécuter: `php artisan tinker`
  - [ ] `Department::first()->head()` ✅ OK
  - [ ] `User::first()->committee` ✅ OK
  - [ ] `User::first()->head()` ✅ OK
  - [ ] Pas d'erreur sur les relations
- [ ] Exécuter: `npm run build` - Pas d'erreur de compilation
- [ ] Commit final: `git commit -m "Chore: Phase 1 critical fixes complete"`
- [ ] Durée: **5 minutes**

---

## 📝 CHECKLIST PHASE 2 - STANDARDISATION (Jours 2-3)

### 🔄 Résoudre Redondance User ↔ Department
- [ ] Consulter: `PLAN_CORRECTION_MODELS.md` section 3.1
- [ ] Choisir: OPTION A (garder FK, supprimer pivot)
- [ ] Vérifier l'utilisation de `departments()` dans le projet
  ```bash
  grep -r "->departments()" app/ resources/
  ```
- [ ] Si peu d'utilisation → Procéder à la suppression
- [ ] Créer migration: `php artisan make:migration drop_department_user_table`
  ```php
  Schema::dropIfExists('department_user');
  ```
- [ ] Dans `User.php`: Supprimer la fonction `departments()`
- [ ] Dans `Department.php`: Supprimer la fonction `users()` (pivot)
  - [ ] Garder `departmentUsers()` (hasMany FK)
- [ ] Exécuter: `php artisan migrate`
- [ ] Commit: `git commit -m "Refactor: Remove User-Department redundancy"`
- [ ] Durée: **1-2 heures**
- [ ] Test: `php artisan test` - Vérifier aucune relation cassée

### 🏷️ Standardiser Noms Pivot Role-Permission
- [ ] Consulter: `PLAN_CORRECTION_MODELS.md` section 2.1
- [ ] Créer migration: `php artisan make:migration rename_role_has_permissions_table`
  ```php
  Schema::rename('role_has_permissions', 'permission_roles');
  ```
- [ ] Exécuter la migration: `php artisan migrate`
- [ ] Vérifier dans `Permission.php`: 
  ```php
  public function roles() {
      return $this->belongsToMany(Role::class, 'permission_roles', ...);
  }
  ```
- [ ] Commit: `git commit -m "Chore: Standardize role_permission pivot table naming"`
- [ ] Durée: **1-2 heures**
- [ ] Test: `php artisan tinker` → `Role::first()->permissions()` ✅

### ✅ Valider Phase 2
- [ ] Exécuter: `php artisan migrate:status` - Tout OK
- [ ] Exécuter: `php artisan test` - Tous tests passent
- [ ] Exécuter: `php artisan tinker`
  - [ ] `User::first()->department` ✅
  - [ ] `Role::first()->permissions()` ✅
- [ ] Commit final: `git commit -m "Chore: Phase 2 standardization complete"`
- [ ] Durée: **5 minutes**

---

## 📱 CHECKLIST PHASE 3 - UI/UX MOBILE (Jours 4-5)

### 🍔 Corriger Dashboard Mobile Menu Burger
- [ ] Consulter: `STAFF_DASHBOARD_MOBILE_FIXES.md`
- [ ] Ouvrir: `resources/views/staff/dashboard.blade.php`
- [ ] Implémenter les corrections CSS:
  - [ ] Ajouter `.mobile-menu-toggle` (mobile only)
  - [ ] Ajouter `.sidebar-overlay` (clickable)
  - [ ] Ajouter media queries pour mobile
- [ ] Implémenter la logique JavaScript:
  - [ ] Fonction `toggleMobileSidebar()`
  - [ ] Close on click outside
  - [ ] Close on resize > 768px
- [ ] Tester en mobile:
  - [ ] Click hamburger → Sidebar s'ouvre ✅
  - [ ] Overlay aparaît ✅
  - [ ] Click overlay → Sidebar se ferme ✅
  - [ ] Click lien → Sidebar se ferme ✅
- [ ] Commit: `git commit -m "Fix: Implement responsive mobile menu for staff dashboard"`
- [ ] Durée: **2-3 heures**
- [ ] Test: Tester sur mobile/tablet (DevTools)

### 🌐 Ajouter support Safari backdrop-filter
- [ ] Ouvrir: `public/css/welcome.css`
- [ ] Chercher: `backdrop-filter` (lignes 58, 598)
- [ ] Ajouter avant: `-webkit-backdrop-filter: blur(...);`
- [ ] Ouvrir: `public/app.css`
- [ ] Chercher: `backdrop-filter` (lignes 91, 542, 918)
- [ ] Ajouter le prefix `-webkit-` à chaque occurrence
- [ ] Commit: `git commit -m "Fix: Add webkit prefix for Safari backdrop-filter support"`
- [ ] Durée: **30 minutes**
- [ ] Test: Vérifier en Safari (ou simulator)

### ✅ Valider Phase 3
- [ ] Tester mobile responsiveness:
  - [ ] 480px: Menu burger fonctionne
  - [ ] 768px: Menu burger fonctionne
  - [ ] 1024px+: Menu caché, sidebar toujours visible
- [ ] Tester tous les dashboards:
  - [ ] Staff Dashboard: Menu fonctionne
  - [ ] Department Dashboard: Menu fonctionne
  - [ ] Committee Dashboard: Menu fonctionne
- [ ] Commit final: `git commit -m "Chore: Phase 3 UI/UX mobile fixes complete"`
- [ ] Durée: **10 minutes**

---

## 🧪 CHECKLIST PHASE 4 - TESTS & DOCUMENTATION (Jours 5-7)

### ✅ Ajouter Tests Pest
- [ ] Créer: `tests/Feature/ModelsTest.php`
  - [ ] Test `Department::head()` relation
  - [ ] Test `User::committee()` relation
  - [ ] Test `User::department()` relation
  - [ ] Test `Role::permissions()` relation
  - [ ] Test `Permission::roles()` relation
- [ ] Exécuter: `php artisan test`
- [ ] Tous tests doivent passer ✅
- [ ] Commit: `git commit -m "Test: Add comprehensive model relationship tests"`
- [ ] Durée: **2-3 heures**

### 📖 Mettre à jour documentation
- [ ] Vérifier tous les fichiers .md sont à jour
  - [ ] [x] STATE_OF_PROJECT.md
  - [ ] [x] TECHNICAL_GUIDE.md
  - [ ] [x] QUICK_START.md
  - [ ] [x] ANALYSE_UML_MCD.md
  - [ ] [x] PLAN_CORRECTION_MODELS.md
  - [ ] [x] STAFF_DASHBOARD_MOBILE_FIXES.md
  - [ ] [x] VISUAL_SUMMARY.md
  - [ ] [x] INDEX.md
  - [ ] [x] CHECKLIST.md (ce fichier)
- [ ] Commit: `git commit -m "Docs: Update documentation after all fixes"`
- [ ] Durée: **30 minutes**

### 🎯 Validation Finale
- [ ] Exécuter: `php artisan test` → ✅ Tous tests passent
- [ ] Exécuter: `npm run build` → ✅ Aucune erreur
- [ ] Exécuter: `php artisan tinker`
  - [ ] Relations critiques fonctionnent
  - [ ] Pas d'exceptions runtime
- [ ] Tester manuellement:
  - [ ] Login fonctionne
  - [ ] Dashboards chargent
  - [ ] Navigation fonctionne
  - [ ] Mobile responsive OK
- [ ] Commit final: `git commit -m "Release: All critical fixes and tests complete - Ready for staging"`
- [ ] Durée: **1-2 heures**

---

## 🚀 POST-CORRECTION ACTIONS

### Déploiement Staging
- [ ] Pousser les changements: `git push`
- [ ] Déployer en staging
- [ ] Exécuter les migrations: `php artisan migrate`
- [ ] Vérifier fonctionnalités clés
- [ ] Tests QA complets

### Déploiement Production
- [ ] Backup de production
- [ ] Déployer les changements
- [ ] Exécuter les migrations
- [ ] Monitoring pour erreurs
- [ ] Notification à l'équipe

### Améliorations Futures
- [ ] Ajouter plus de tests (coverage > 80%)
- [ ] Implémenter des newféatures
- [ ] Optimiser les performances
- [ ] Améliorer la documentation

---

## 📊 TRACKER DE PROGRESSION

```
╔════════════════════════════════════════════════════════════╗
║           PROGRESSION DU PROJET                           ║
╠════════════════════════════════════════════════════════════╣

PHASE 1 - CRITIQUES (Jour 1)
[ ] Supprimer headDepartment()
[ ] Corriger comite()
[ ] Supprimer user() dupliquée
[ ] Corriger CSS ligne 228
[ ] Valider Phase 1
═══════════════════════════════════════════ 0%

PHASE 2 - STANDARDISATION (Jours 2-3)
[ ] Redondance User-Department
[ ] Noms pivot Role-Permission
[ ] Valider Phase 2
═══════════════════════════════════════════ 0%

PHASE 3 - UI/UX (Jours 4-5)
[ ] Menu burger mobile
[ ] Safari backdrop-filter
[ ] Valider Phase 3
═══════════════════════════════════════════ 0%

PHASE 4 - TESTS & DOCS (Jours 5-7)
[ ] Tests Pest
[ ] Mise à jour documentation
[ ] Validation finale
═══════════════════════════════════════════ 0%

═════════════════════════════════════════════════════════════
STATUT GLOBAL:                              🔴 COMMENCER
═════════════════════════════════════════════════════════════

Durée totale estimée: 5-7 jours de travail
Commit attendus: ~15 commits
Tests à passer: 100%
```

---

## 📞 EN CAS DE PROBLÈME

### Le code ne compile
```bash
# Solution
php artisan config:clear
composer dump-autoload
npm run build
```

### Une relation ne fonctionne pas
```bash
# Vérifier dans tinker
php artisan tinker
>>> $user = User::first()
>>> $user->department  # Vérifier s'il retourne l'objet
>>> $user->committee   # Idem
```

### Une migration échoue
```bash
# Rollback et retry
php artisan migrate:rollback
php artisan migrate
```

### Les tests ne passent pas
```bash
# Exécuter un test spécifique
php artisan test tests/Feature/ModelsTest.php
# Voir l'erreur complète
php artisan test --verbose
```

---

## ✨ NOTES IMPORTANTES

- ✅ Faire les commits régulièrement (après chaque phase)
- ✅ Tester après chaque changement
- ✅ Ne pas sauter les validations
- ✅ Consulter la documentation si bloqué
- ✅ Demander de l'aide si besoin
- ✅ Documenter tout changement

---

## 📋 DOCUMENTS DE RÉFÉRENCE

À avoir ouvert en permanence:
1. `STATE_OF_PROJECT.md` - État global
2. `PLAN_CORRECTION_MODELS.md` - Instructions précises
3. `TECHNICAL_GUIDE.md` - Reference technique
4. `VISUAL_SUMMARY.md` - Schémas visuels

---

**Checklist créée:** 3 février 2026  
**Durée estimée:** 5-7 jours  
**Status:** Prête à commencer  

Bonne chance! 🚀
