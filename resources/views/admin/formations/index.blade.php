@extends('modele')

@section('title', 'Liste de formations')

@section('contents')
<table class="table" class="table-info">
  <thead>
    <tr>
      <th scope="col">Intitule</th>
      <th scope="col">Date de création</th>
      <th scope="col">Date de mise à jour</th>
      <th scope="col">Modification</th>
      <th scope="col">Suppression</th>
    </tr>
  </thead>
  <tbody>
  @foreach($formations as $f)
    <tr class="table-info">
      <td class="table-info">{{$f->intitule}}</td>
      <td class="table-info">{{$f->created_at}}</td>
      <td class="table-info">{{$f->updated_at}}</td>
      <td class="table-info"><a class="lien1" href="{{route('admin.formations.edit', ['id'=>$f->id])}}">Modifier</a></td>
      <td class="table-info"><a class="lien1" href="{{route('admin.formations.delete', ['id'=>$f->id])}}">Supprimer</a></td>
    </tr>
  @endforeach
  </tbody>
</table>
@endsection