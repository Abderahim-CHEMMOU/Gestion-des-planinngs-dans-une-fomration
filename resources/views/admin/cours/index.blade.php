@extends('modele')

@section('title', 'Liste de cours')

@section('contents')
<table class="table" class="table-info">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Intitule</th>
      <th scope="col">Enseignant</th>
      <th scope="col">Formation</th>
      <th scope="col">Date de création</th>
      <th scope="col">Date de mise à jour</th>
      <th scope="col">Modification</th>
      <th scope="col">Suppression</th>
    </tr>
  </thead>
  <tbody>
    @foreach($cours as $index => $c)
    <tr class="table-info">
      <th class="table-info" scope="row">{{$c->id}}</th>
      <td class="table-info">{{$c->intitule}}</td>
      <td class="table-info">@if(!strcmp($c->user_id, "1"))Aucun enseignant @else {{$enseignants[$index]}} @endif</td>
      <td class="table-info">{{$formations[$index]}}</td>
      <td class="table-info">{{$c->created_at}}</td>
      <td class="table-info">{{$c->updated_at}}</td>
      <td class="table-info"><a class="lien1" href="{{route('admin.cours.edit', ['id'=>$c->id])}}">Modifier</a></td>
      <td class="table-info"><a class="lien1" href="{{route('admin.cours.delete', ['id'=>$c->id])}}">Supprimer</a></td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection