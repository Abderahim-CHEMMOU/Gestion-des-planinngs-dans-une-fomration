@extends('modele')

@section('title', 'Rechercher un cours')

<h3>Rechercher un cours</h3>

@section('contents')

@empty($cours)
<form method="post" action="{{route('admin.cours.searchCourse')}}">

    <p><label for="intitule">Nom :</label>
        <input type="text" name="intitule" id="intitule" value="{{old('intitule')}}">
    </p>

    <input type="submit" value="Rechercher">
    @csrf
</form>
@endempty

@isset($cours)
<table class="table">
    <thead>
        <tr>
            <th scope="col">Intitule</th>
            <th scope="col">Enseignant</th>
            <th scope="col">Formation</th>
            <th scope="col">Date de création</th>
            <th scope="col">Date de mise à jour</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cours as $index => $c)
        <tr>
            <td>{{$c->intitule}}</td>
            <td>{{$enseignants[$index]->nom}} {{$enseignants[$index]->prenom}}</td>
            <td>{{$formations[$index]->intitule}}</td>
            <td>{{$c->created_at}}</td>
            <td>{{$c->updated_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endisset
@endsection