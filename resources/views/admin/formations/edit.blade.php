@extends('modele')

@section('title', 'Modification d\'une formation')

@section('contents')
<h2>Modifier une formation</h2>

<form method="post" action="{{route('admin.formations.update', [ 'id' => $id])}}">
    @method('put')
    <p>Intitule: <input type="text" name="intitule" value="{{$formation->intitule}}"></p>
    <input type="submit" value="Envoyer">
    @csrf
</form>


@endsection