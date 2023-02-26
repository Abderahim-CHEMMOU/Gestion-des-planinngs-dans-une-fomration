@extends('modele')

@section('title', 'Modification du cours')

@section('contents')
<h2>Modifier un cours</h2>

<form method="post" action="{{route('admin.cours.update', [ 'id' => $id])}}">
    @method('delete')
    <p><label for="intitule">Nom :</label>
        <input type="text" name="intitule" id="intitule" value="{{$cours->intitule}}">
    </p>

    <label for="Enseignant">Enseignant:</label>
    <select class="form-select" aria-label="Default select example" name="Enseignant" id="Enseignant">
        @foreach($enseignants as $ens)
        <option value="{{$ens->id}}">{{$ens->nom}} {{$ens->prenom}}</option>
        @endforeach
    </select>

    <label for="formation">Formation:</label>
    <select class="form-select" aria-label="Default select example" name="formation" id="formation">
        @foreach($formations as $f)
        <option value="{{$f->id}}">{{$f->intitule}}</option>
        @endforeach
    </select>

    <input type="submit" value="Modifier">
    @csrf
</form>

@endsection