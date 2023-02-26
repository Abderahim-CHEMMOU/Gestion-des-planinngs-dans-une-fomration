<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\PlanningController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('main');
});

// Menus de site
Route::view('/home', 'home')->middleware('auth');

Route::view('/admin', 'admin.home')->middleware('auth')->middleware('is_admin')
    ->name('admin.home');

// Se connecter
Route::get('/login', [AuthenticatedSessionController::class, 'showForm'])
    ->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'login']);
// Se déconnecter
Route::get('/logout', [AuthenticatedSessionController::class, 'logout'])
    ->middleware('auth')->name('logout');

// Créer un compte
Route::get('/auth/register', [RegisterUserController::class, 'showForm'])
    ->name('auth.register');
Route::post('/auth/store', [RegisterUserController::class, 'store'])
    ->name('auth.store');;

// 3.1.2. Changement de son mot de passe
Route::get('/auth/password/edit', [AuthenticatedSessionController::class, 'edit'])->middleware('auth')
    ->name('auth.password.edit');
Route::put('/auth/password', [AuthenticatedSessionController::class, 'update'])->middleware('auth')
    ->name('auth.password.update');

// 3.1.3. Modification du nom/prénom
Route::get('/auth/infoPersoEdit', [AuthenticatedSessionController::class, 'infoPersoEdit'])->middleware('auth')
    ->name('auth.infoPersoEdit');
Route::put('/auth', [AuthenticatedSessionController::class, 'infoPersoUpdate'])->middleware('auth')
    ->name('auth.infoPersoUpdate');

// 4.1.2. Acceptation (ou refus) d’un utilisateur qui a été auto-crée
Route::get('/admin/acceptRefusUserForm', [UserController::class, 'acceptRefusUserForm'])->middleware('is_admin')
    ->name('admin.acceptRefusUserForm');
Route::put('/admin/acceptRefusUser', [UserController::class, 'acceptRefusUser'])->middleware('is_admin')
    ->name('admin.acceptRefusUser');


// 4.1.1.  Liste :
// 4.1.1.1.  Intégrale
Route::get('/admin/users', [UserController::class, 'index'])->middleware('is_admin')
    ->name('admin.index');


// 4.1.4. Création d’un utilisateur (Par l'Admin)
Route::get('/admin/register', [UserController::class, 'showForm'])->middleware('is_admin')
    ->name('admin.register');
Route::post('/admin/store', [UserController::class, 'store'])->middleware('is_admin')
    ->name('admin.store');

// 4.1.5. Modification d’un utilisateur (y compris le type)
Route::get('/admin/{id}/edit', [UserController::class, 'edit'])->middleware('is_admin')
    ->name('admin.edit');
Route::put('/admin/{id}', [UserController::class, 'update'])->middleware('is_admin')
    ->name('admin.update');

// 4.1.6.  Suppression d’un utilisateur
Route::get('/admin/{id}/delete', [UserController::class, 'delete'])->middleware('is_admin')
    ->name('admin.delete');
Route::delete('/admin/{id}', [UserController::class, 'destroy'])->middleware('is_admin')
    ->name('admin.destroy');

// 4.2.1. Liste (Cours).
Route::get('/admin/cours', [CoursController::class, 'index'])->middleware('is_admin')
    ->name('admin.cours.index');

// 4.2.2.  Recherche par intitulé
Route::get('/admin/cours/searchCourseForm', [CoursController::class, 'searchCourseForm'])->middleware('is_admin')
    ->name('admin.cours.searchCourseForm');
Route::post('/admin/cours/searchCourse', [CoursController::class, 'searchCourse'])->middleware('is_admin')
    ->name('admin.cours.searchCourse');

// 4.2.3. Création d’un cours
// 4.1.3. Association d’un enseignant à un cours 
Route::get('/admin/cours/create', [CoursController::class, 'create'])->middleware('is_admin')
    ->name('admin.cours.create');
Route::post('/admin/cours', [CoursController::class, 'store'])->middleware('is_admin')
    ->name('admin.cours.store');

// 4.2.4.  Modification d’un cours
Route::get('/admin/cours/{id}/edit', [CoursController::class, 'edit'])->middleware('is_admin')
    ->name('admin.cours.edit');
Route::put('/admin/cours/{id}', [CoursController::class, 'update'])->middleware('is_admin')
    ->name('admin.cours.update');

// 4.2.5.  Suppression d’un cours
Route::get('/admin/cours/{id}/delete', [CoursController::class, 'delete'])->middleware('is_admin')
    ->name('admin.cours.delete');
Route::delete('/admin/cours/{id}', [CoursController::class, 'destroy'])->middleware('is_admin')
    ->name('admin.cours.destroy');

// 4.3.1. Liste (Formations)
Route::get('/admin/formations', [FormationController::class, 'index'])->middleware('is_admin')
    ->name('admin.formations.index');

// 4.3.2. Ajout d’une formation
Route::get('/admin/formations/create', [FormationController::class, 'create'])->middleware('is_admin')
    ->name('admin.formations.create');
Route::post('/admin/formations', [FormationController::class, 'store'])->middleware('is_admin')
    ->name('admin.formations.store');

// 4.3.3.  Modification d’une formation
Route::get('/admin/formations/{id}/edit', [FormationController::class, 'edit'])->middleware('is_admin')
    ->name('admin.formations.edit');
Route::put('/admin/formations/{id}', [FormationController::class, 'update'])->middleware('is_admin')
    ->name('admin.formations.update');

// 4.3.4.  Suppression d’une formation
Route::get('/admin/formations/{id}/delete', [FormationController::class, 'delete'])->middleware('is_admin')
    ->name('admin.formations.delete');
Route::delete('/admin/formations/{id}', [FormationController::class, 'destroy'])->middleware('is_admin')
    ->name('admin.formations.destroy');
    


// 1.1. Voir la liste des cours de la formation (dans laquelle l’étudiant est inscrit)
Route::get('/etudiant/listeCours', [CoursController::class, 'etudIndex'])->middleware('is_student')
    ->name('etudiant.listeCours.etudIndex');

// 1.2.1. Inscription dans un cours
Route::get('/etudiant/inscription/create', [EtudiantController::class, 'create'])->middleware('is_student')
    ->name('etudiant.inscription.create');
Route::post('/etudiant/inscription/store', [EtudiantController::class, 'store'])->middleware('is_student')
    ->name('etudiant.inscription.store');

// 1.2.2. Désinscription d’un cours
Route::get('/etudiant/inscription/{id}/delete', [EtudiantController::class, 'delete'])->middleware('is_student')
    ->name('etudiant.inscription.delete');
Route::post('/etudiant/inscription/{id}', [EtudiantController::class, 'destroy'])->middleware('is_student')
    ->name('etudiant.inscription.destroy');

// 1.2.3. Liste des cours auxquels l’étudiant est inscrit
Route::get('/etudiant/inscription', [EtudiantController::class, 'index'])->middleware('is_student')
    ->name('etudiant.inscription.index');

//1.2.4. Rechercher un cours dans la liste des cours de la formation
Route::get('/etudiant/inscription/search', [EtudiantController::class, 'search'])->middleware('is_student')
    ->name('etudiant.inscription.search');
Route::post('/etudiant/inscription', [EtudiantController::class, 'result'])->middleware('is_student')
    ->name('etudiant.inscription.result');

Route::get('/etudiant/listeCours/{id}', [EtudiantController::class, 'show'])->middleware('is_student')
    ->name('listeCours.show');

// 2.1. Voir la liste des cours dont on est responsable
Route::get('/enseignant/listeCours', [EnseignantController::class, 'index'])->middleware('is_teacher')
    ->name('enseignant.listeCours.index');

// 2.3. Gestion du planning :

// 2.3.1. Création d’une nouvelle séance de cours

//2.2. Voir le planning personnalisé (les séances dont on est responsable)
//2.2.1. Intégral
Route::get('/enseignant/plannings/indexVue', [PlanningController::class, 'indexVue'])->middleware('is_teacher')
    ->name('enseignant.plannings.indexVue');


//2.2.1. Intégral (2v)
Route::get('/enseignant/plannings/vuesPlannings', [PlanningController::class, 'index'])->middleware('is_teacher')
    ->name('enseignant.plannings.vuesPlannings.index');

// 2.3.1. Création d’une nouvelle séance de cours
Route::get('/enseignant/plannings/create', [EnseignantController::class, 'create'])->middleware('is_teacher')
    ->name('enseignant.plannings.create');
Route::post('/enseignant/plannings', [EnseignantController::class, 'store'])->middleware('is_teacher')
    ->name('enseignant.plannings.store');

// 2.3.2. Mise à jour d’une séance de cours
Route::get('/enseignant/plannings/{id}/edit', [EnseignantController::class, 'edit'])->middleware('is_teacher')
    ->name('enseignant.plannings.edit');
Route::put('/enseignant/plannings/{id}', [EnseignantController::class, 'update'])->middleware('is_teacher')
    ->name('enseignant.plannings.update');

// 2.3.3. Suppression d’une séance de cours
Route::get('/enseignant/plannings/{id}/delete', [EnseignantController::class, 'delete'])->middleware('is_teacher')
    ->name('enseignant.plannings.delete');
Route::delete('/enseignant/plannings/{id}', [EnseignantController::class, 'destroy'])->middleware('is_teacher')
    ->name('enseignant.plannings.destroy');
