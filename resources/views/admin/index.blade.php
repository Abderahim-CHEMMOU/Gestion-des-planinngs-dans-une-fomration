@extends('modele')

@section('title', 'Liste des utilisateurs')

@section('contents')
<table class="table" class="table-info">
    <thead>
        <tr>
            <th scope="col">Nom</th>
            <th scope="col">Prenom</th>
            <th scope="col">Login</th>
            <th scope="col">Formation</th>
            <th scope="col">Type</th>
            <th scope="col">Modification</th>
            <th scope="col">Suppression</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $index => $u)
        <tr class="table-info">
            <td class="table-info">{{$u->nom}}</td>
            <td class="table-info">{{$u->prenom}}</td>
            <td class="table-info">{{$u->login}}</td>
            <td class="table-info">{{$formations_intitule[$index]}}</td>
            <td class="table-info">@empty($u->type)Pas validé@endempty @isset($u->type) {{$u->type}} @endisset</td>
            <td class="table-info"><a class="lien1" href="{{route('admin.edit', ['id'=>$u->id])}}">Modifier</a></td>
            <td class="table-info"><a class="lien1" href="{{route('admin.delete', ['id'=>$u->id])}}">Supprimer</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection