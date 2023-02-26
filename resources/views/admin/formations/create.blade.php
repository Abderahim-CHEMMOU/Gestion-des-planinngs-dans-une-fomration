@extends('modele')

@section('title', 'Ajouter une formation')

@section('contents')
    <h3>Ajouté une formations</h3>
    <form  action="{{route('admin.formations.store')}}" method="post">
        Intitule: <input type="text" name="intitule" value="{{old('intitule')}}">
        <input type="submit" value="Envoyer">
        @csrf
    </form>
@endsection
