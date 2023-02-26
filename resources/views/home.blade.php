@extends('modele')

@section('contents')

    <p>Page d' accueil.</p>

    @auth

@if( (Auth::user()->type) == 'admin')

<div class="list-group">
    <a href="#" class="list-group-item list-group-item-action active">Gestion des utilisateurs</a>
    <a href="{{route('admin.index')}}" class="list-group-item list-group-item-action">Liste des utilisateurs</a>
    <a href="{{route('admin.acceptRefusUserForm')}}" class="list-group-item list-group-item-action">Acceptation (ou refus) d’un utilisateur qui a été auto-crée</a>
    <a href="{{route('admin.register')}}" class="list-group-item list-group-item-action">Création d’un utilisateur</a>
    <a href="{{route('admin.index')}}" class="list-group-item list-group-item-action">Modification d’un utilisateur</a>
    <a href="{{route('admin.index')}}" class="list-group-item list-group-item-action">Suppression d’un utilisateur</a>
</div>

<div class="list-group">
    <a href="#" class="list-group-item list-group-item-action active">Gestion des cours</a>
    <a href="{{route('admin.cours.index')}}" class="list-group-item list-group-item-action">Voir la liste des cours</a>
    <a href="{{route('admin.cours.searchCourseForm')}}" class="list-group-item list-group-item-action">Recherche un cours par intitulé</a>
    <a href="{{route('admin.cours.create')}}" class="list-group-item list-group-item-action">Création d’un cours</a>
    <a href="{{route('admin.cours.index')}}" class="list-group-item list-group-item-action">  Modification </a>
    <a href="{{route('admin.cours.index')}}" class="list-group-item list-group-item-action">  Suppression </a>
</div>

<div class="list-group">
    <a href="#" class="list-group-item list-group-item-action active">Gestion des formations</a>
    <a href="{{route('admin.formations.index')}}" class="list-group-item list-group-item-action">Liste des formations</a>
    <a href="{{route('admin.formations.create')}}" class="list-group-item list-group-item-action">Création d'une formation</a>
    <a href="{{route('admin.cours.create')}}" class="list-group-item list-group-item-action">Création d’un cours</a>
    <a href="{{route('admin.formations.index')}}" class="list-group-item list-group-item-action">  Modification </a>
    <a href="{{route('admin.formations.index')}}" class="list-group-item list-group-item-action">  Suppression </a>
</div>
@endif

@if( (Auth::user()->type) == 'etudiant')
<div class="list-group">
    <a href="#" class="list-group-item list-group-item-action active">Etudiants</a>
    <a href="{{route('etudiant.listeCours.etudIndex')}}" class="list-group-item list-group-item-action">Liste des cours de la formation (dans laquelle l’étudiant est inscrit)</a>
    <a href="{{route('etudiant.inscription.create')}}" class="list-group-item list-group-item-action">Inscription dans un cours</a>
    <a href="{{route('etudiant.inscription.index')}}" class="list-group-item list-group-item-action">Désinscription d’un cours</a>
    <a href="{{route('etudiant.inscription.index')}}" class="list-group-item list-group-item-action">Liste des cours auxquels l’étudiant est inscrit</a>
    <a href="{{route('etudiant.inscription.search')}}" class="list-group-item list-group-item-action">Rechercher un cours dans la liste des cours de la formation</a>
</div>

@endif


@if( (Auth::user()->type) == 'enseignant')
<div class="list-group">
    <a href="#" class="list-group-item list-group-item-action active">Gestion du planning</a>
    <a href="{{route('enseignant.plannings.indexVue')}}" class="list-group-item list-group-item-action">le planning personnalisé </a>
    <a href="{{route('enseignant.plannings.create')}}" class="list-group-item list-group-item-action">Création d’une nouvelle séance de cours</a>
    <a href="{{route('enseignant.plannings.indexVue')}}" class="list-group-item list-group-item-action">Mise à jour d’une séance de cours</a>
    <a href="{{route('enseignant.plannings.indexVue')}}" class="list-group-item list-group-item-action">Suppression d’une séance de cours</a>
</div>

@endif

@endauth
@endsection
