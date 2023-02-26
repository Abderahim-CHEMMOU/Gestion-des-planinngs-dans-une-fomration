@extends('modele')

@section('title', 'Changement de mot de passe')

@section('contents')
<form action="{{route('auth.infoPersoUpdate')}}" method="post">
    @method('put')

    <p class="btn btn-dark"><label for="nom"> Nom :</label>
        <input type="text" id="nom" name="nom" value="{{$nom}}" required}>
    </p>
    <br>


    <p class="btn btn-dark"><label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="{{$prenom}}" required>
    </p>
    <br>

    <div class="text-center">
        <p><input class="btn btn-primary btn-lg" type="submit" value="Modifier"></p>
    </div>
    @csrf
</form>
@endsection