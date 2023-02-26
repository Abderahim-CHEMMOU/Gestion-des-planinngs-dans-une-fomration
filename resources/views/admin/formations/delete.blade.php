@extends('modele')

@section('title', 'Supprimer une formation')

@section('contents')
<h2>Supprimer une formation</h2>
<h5>{{$formation->intitule}} </h5>
<form method="post" action="{{route('admin.formations.destroy', ['id' => $id])}}">
    @method('delete')
    <input type="hidden" name="reponse" value="non">
    <input type="submit" value="Annuler">
    @csrf
</form>

<form method="post" action="{{route('admin.formations.destroy',['id'=>$id])}}">
    @method('delete')
    <input type="hidden" name="reponse" value="oui">
    <input type="submit" value="Supprimer">
    @csrf
</form>



@endsection