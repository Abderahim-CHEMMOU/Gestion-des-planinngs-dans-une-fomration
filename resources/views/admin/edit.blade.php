@extends('modele')

@section('title', 'Modification utilisateur')

@section('contents')
<h2>Modifier un compte</h2>

@empty($type)
<form method="get" action="{{route('admin.edit', [ 'id' => $id])}}">

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
<form method="post" action="{{route('admin.update', [ 'id' => $id])}}">
@method('put')
    <input name="type" type="hidden" value="{{$type}}">

    <p><label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="{{$user->nom}}">
    </p>

    <p><label for="prenom">Prenom :</label>
        <input type="text" name="prenom" id="prenom" value="{{$user->prenom}}">
    </p>

    <p><label for="login">Login :</label>
        <input type="text" name="login" id="login" value="{{$user->login}}">
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
<form method="post" action="{{route('admin.update', [ 'id' => $id])}}">
@method('put')
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

    <input type="submit" value="Envoyer">
    @csrf
</form>
@endif
@endisset

@endsection