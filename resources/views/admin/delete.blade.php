@extends('modele')

@section('title', 'Supprimer un utilisateur')

@section('contents')
<h2>Supprimer un utilisateur</h2>
<h5>{{$user->nom}} {{$user->prenom}} </h5> 
<form method="post" action="{{route('admin.destroy', ['id' => $id])}}">
    @method('delete')

    <input type="hidden" name="reponse" value="annuler">
    <input type="submit" value="Annuler">
    @csrf
</form>

<form method="post" action="{{route('admin.destroy',['id'=>$id])}}">
    @method('delete')

    <input type="hidden" name="reponse" value="supprimer">
    <input type="submit" value="Supprimer">
    @csrf
</form>



@endsection