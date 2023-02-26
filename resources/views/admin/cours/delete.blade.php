@extends('modele')

@section('title', 'Supprimer un cours')

@section('contents')
<h2>Supprimer un cours</h2>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Intitule</th>
            <th scope="col">Enseignant</th>
            <th scope="col">Formation</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$cours->intitule}}</td>
            <td>{{$enseignant->nom}}  {{$enseignant->prenom}}</td>
            <td>{{$formation->intitule}}</td>
        </tr>
    </tbody>
</table>

<form method="post" action="{{route('admin.cours.destroy', ['id' => $id])}}">
    @method('delete')

    <input type="hidden" name="reponse" value="oui">
    <input type="submit" value="Annuler">
    @csrf
</form>

<form method="post" action="{{route('admin.cours.destroy',['id'=>$id])}}">
    @method('delete')

    <input type="hidden" name="reponse" value="non">
    <input type="submit" value="Supprimer">
    @csrf
</form>



@endsection