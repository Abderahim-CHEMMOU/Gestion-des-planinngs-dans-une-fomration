@extends('modele')

@section('title', 'Supprimmer le cours')

@section('contents')
    <form  action="{{route('etudiant.inscription.destroy',['id' => $id])}}" method="post">
    <button type="submit" class="btn btn-primary">Supprimer le cours</button>
    @csrf
    </form>
@endsection