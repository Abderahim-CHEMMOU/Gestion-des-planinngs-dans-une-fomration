@extends('modele')

@section('title', 'Création d\'un utilisateur')

@section('contents')
<h2>Créer un compte</h2>


@empty($type)
<form method="get" action="{{route('admin.register')}}">

    <div class=" form-check">
        <input class="form-check-input" type="radio" name="type" value="etudiant" id="type">
        <label class="form-check-label" for="type">
            Etudiant
        </label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="radio" name="type" value="enseignant" id="type">
        <label class="form-check-label" for="type">
            Enseignant
        </label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="radio" name="type" value="admin" id="type">
        <label class="form-check-label" for="type">
            Admin
        </label>
    </div>

    <input type="submit" value="Envoyer">
    @csrf
</form>
@endempty

@isset($type)
@if(!strcmp ($type , 'etudiant') )
<form method="post" action="{{route('admin.store')}}">

    <input name="type" type="hidden" value="{{$type}}">

    <p><label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="{{old('nom')}}">
    </p>

    <p><label for="prenom">Prenom :</label>
        <input type="text" name="prenom" id="prenom" value="{{old('prenom')}}">
    </p>

    <p><label for="login">Login :</label>
        <input type="text" name="login" id="login" value="{{old('login')}}">
    </p>

    <p><label for="mdp">Mot de passe :</label>
        <input type="password" id="mdp" name="mdp">
    </p>

    <p><label for="mdp_confirmation">Confirmation de mot de passe :</label>
        <input type="password" id="mdp_confirmation" name="mdp_confirmation">
    </p>

    <label for="formation_id">Formation :</label>
    <select class="form-select" aria-label="Default select example" name="formation_id" id="formation_id">
        @foreach($formations as $f)
        <option value="{{$f->id}}">{{$f->intitule}}</option>
        @endforeach
    </select>

    <input type="submit" value="Envoyer">
    @csrf
</form>
@endif

@if( (!strcmp($type, 'enseignant')) || (!strcmp($type, 'admin')) )
<form method="post" action="{{route('admin.store')}}">

    <input name="type" type="hidden" value="{{$type}}">

    <p><label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="{{old('nom')}}">
    </p>

    <p><label for="prenom">Prenom :</label>
        <input type="text" name="prenom" id="prenom" value="{{old('prenom')}}">
    </p>

    <p><label for="login">Login :</label>
        <input type="text" name="login" id="login" value="{{old('login')}}">
    </p>

    <p><label for="mdp">Mot de passe :</label>
        <input type="password" id="mdp" name="mdp">
    </p>

    <p><label for="mdp_confirmation">Confirmation de mot de passe :</label>
        <input type="password" id="mdp_confirmation" name="mdp_confirmation">
    </p>
    <input type="submit" value="Envoyer">
    @csrf
</form>
@endif
@endisset

@endsection