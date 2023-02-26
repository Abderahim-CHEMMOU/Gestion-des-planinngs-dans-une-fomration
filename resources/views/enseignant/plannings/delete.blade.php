@extends('modele')

@section('title', 'Créez un planning')

@section('contents')
    <form action="{{route('enseignant.plannings.destroy', ['id'=>$id])}}" method="post">
        @method('delete')
    
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Cours</th>
      <th scope="col">Date debut</th>
      <th scope="col">Date fin</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{$coursActuel}}</td>
      <td>{{$planning->date_debut}}</td>
      <td>{{$planning->date_fin}}</td>
    </tr>
  </tbody>
</table>

            <p><button type="submit" class="btn btn-danger">Suprimmer</button></p>
    @csrf
</form>
@endsection