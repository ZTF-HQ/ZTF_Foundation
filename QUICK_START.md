# ⚡ RÉSUMÉ ULTRA-COURT - ZTF FOUNDATION

## En 2 minutes

**Quoi:** Plateforme de gestion d'organisation (Laravel 12)  
**État:** 65% fonctionnel | ⚠️ 2 bugs critiques  
**Stack:** Laravel + Passport + Tailwind + Alpine.js  

---

## ✅ CE QUI MARCHE

- ✅ Login/Authentification 2FA
- ✅ Gestion Utilisateurs, Rôles, Permissions
- ✅ Départements + Services + Comités
- ✅ Export PDF
- ✅ API REST
- ✅ Dashboards (Desktop)

---

## ❌ CE QUI NE MARCHE PAS

### 🔴 CRITIQUES (Fixer tout de suite)

1. **`Department::headDepartment()`** - Foreign key `user_id` n'existe pas
   - Fichier: `app/Models/Department.php` ligne ~50
   - Solution: ✂️ Supprimer la fonction

2. **`User::comite()`** - Mauvaise clé étrangère (`department_id` au lieu de `committee_id`)
   - Fichier: `app/Models/User.php` ligne ~80
   - Solution: Corriger la clé

### 🟠 AVERTISSEMENTS

3. **Redondance User-Department** - 2 relations pour la même chose
4. **Noms pivot incohérents** - `permission_roles` vs `role_has_permissions`
5. **Menu burger mobile** - N'ouvre pas la sidebar en mobile

### 🟡 BUGS COSMÉTIQUES

6. **Erreur CSS ligne 228** - Blade {{ }} dans attribut style
7. **Safari backdrop-filter** - Manque prefix `-webkit-`

---

## 🚀 À FAIRE EN PRIORITÉ

```
JOUR 1: Fixer les 2 bugs critiques
JOUR 2-3: Standardiser les noms
JOUR 4-5: Fixer l'UI mobile
```

---

## 📁 FICHIERS À COMPRENDRE

1. **`STATE_OF_PROJECT.md`** ← Lis d'abord! (État global détaillé)
2. **`TECHNICAL_GUIDE.md`** ← Referentiel technique
3. **`ANALYSE_UML_MCD.md`** ← Analyse des relations
4. **`PLAN_CORRECTION_MODELS.md`** ← Roadmap corrections
5. **`STAFF_DASHBOARD_MOBILE_FIXES.md`** ← Fix du menu mobile

---

## 🔧 COMMANDES ESSENTIELLES

```bash
# Setup
composer install && npm install && php artisan migrate

# Développement
composer run dev

# Tests
php artisan test

# Debugging
php artisan tinker

# Voir les routes
php artisan route:list
```

---

## 📊 SCORES

```
Backend Logic:     ✅ 80%
Models/Relations:  ⚠️  70%
Frontend Desktop:  ✅ 75%
Frontend Mobile:   ⚠️  40%
API:              ✅ 85%
Tests:            ⚠️  30%
───────────────────────────
GLOBAL:           ⚠️  65%
```

---

## 💡 QUICK NOTES

- **16 Modèles Eloquent** avec relations complexes
- **100+ routes** web + API
- **27 Contrôleurs** répartis
- **Authentification:** Passport OAuth2
- **Autorisation:** Rôles + Permissions granulaires
- **Structure:** Multi-département avec comités

---

## 👀 EN CAS DE PROBLÈME

1. Lire les logs: `tail -f storage/logs/laravel.log`
2. Utiliser tinker: `php artisan tinker`
3. Vérifier les migrations: `php artisan migrate:status`
4. Consulter `STATE_OF_PROJECT.md` section "Troubleshooting"

---

**Créé:** 3 février 2026 | **Pour:** Nouvelle IA reprenant le projet
