@extends('modele')

@section('contents')
    <form method="post">
        Login: <input type="text" name="login" value="{{old('login')}}">
        MDP: <input type="password" name="mdp">
        <input type="submit" value="Envoyer">
        @csrf
    </form>
@endsection
