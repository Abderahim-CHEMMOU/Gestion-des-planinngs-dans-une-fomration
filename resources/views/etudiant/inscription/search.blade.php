@extends('modele')

@section('title', 'Rechercher un cours')

@section('contents')
    <form  action="{{route('etudiant.inscription.result')}}" method="post">
        <p><label for="site-search">Search the site:</label>
        <input type="search" id="site-search" name="cours_intitule"
            aria-label="Search through site content">
        <button type="submit" class="btn btn-primary">Recherche</button>
    @csrf
    </form>
@endsection