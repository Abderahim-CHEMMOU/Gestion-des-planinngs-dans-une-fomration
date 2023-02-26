@extends('modele')

@section('title', 'Planinning')

@section('contents')
<table class="table" class="table-info">
    <thead>
        <tr>
            <th scope="col">Cours</th>
            <th scope="col">Date début</th>
            <th scope="col">Date fin</th>
            <th scope="col">Modifaction</th>
            <th scope="col">Suppression</th>
        </tr>
    </thead>
    <tbody>
        @foreach($plannings as $index => $pl)
        <tr class="table-info">
            <td class="table-info">{{$cours[$index]->intitule}}</td>
            <td class="table-info">{{$pl->date_debut}}</td>
            <td class="table-info">{{$pl->date_fin}}</td>
            <td class="table-info"><a class="lien1" href="{{route('enseignant.plannings.edit', ['id'=>$pl->id])}}">Modifier</a></td>
            <td class="table-info"><a class="lien1" href="{{route('enseignant.plannings.delete', ['id'=>$pl->id])}}">Supprimer</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection