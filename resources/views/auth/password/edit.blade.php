@extends('modele')

@section('title', 'Changement de mot de passe')

@section('contents')
<form action="{{route('auth.password.update')}}" method="post">
    @method('put')

    <p class="btn btn-dark"><label for="old_password"> Mot de passe actuel :</label>
        <input type="password" id="old_password" name="old_password">
    </p>
    <br>


    <p class="btn btn-dark"><label for="new_password">Nouveau Mot de passe :</label>
        <input type="password" id="new_password" name="new_password">
    </p>
    <br>

    <p class="btn btn-dark"><label for="new_password_confirmation">Confirmation de mot de passe :</label>
        <input type="password" id="new_password_confirmation" name="new_password_confirmation">
    </p>
    <br>
    <div class="text-center">
        <p><input class="btn btn-primary btn-lg" type="submit" value="Modifier"></p>
    </div>
    @csrf
</form>
@endsection