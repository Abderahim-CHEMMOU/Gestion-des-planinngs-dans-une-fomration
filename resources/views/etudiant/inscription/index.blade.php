@extends('modele')

@section('title', 'Mes cours')

@section('contents')

<table class="table">
  <thead>
    <tr>
      <th scope="col">Cours</th>
      <th scope="col">Désinscription</th>
    </tr>
  </thead>
  <tbody>
  @foreach($cours as $c)
    <tr>
      <td>{{$c->intitule}}</td>
      <td class="table-info"><a class="lien1" href="{{route('etudiant.inscription.delete', ['id'=>$c->id])}}">Désinscrit</a></td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection