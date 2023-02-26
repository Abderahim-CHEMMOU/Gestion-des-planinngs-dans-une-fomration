@extends('modele')

@section('title', 'Créez un planning')

@section('contents')
<h2>Créez un planning</h2>

<form action="{{route('enseignant.plannings.store')}}" method="post">
  <p>
    <label for="pet-select">choisissez un cours:</label>
    <select name="cours_id" id="pet-select" class="form-select" aria-label="Default select example">

      @foreach($cours as $c)
      <option value="{{$c->id}}">{{$c->intitule}}</option>
      @endforeach
    </select>
  </p>

  <label for="meeting-time">Date début :</label>
  <input type="datetime-local" id="meeting-time" name="date_debut" value="2018-06-12T19:30">

  <label for="meeting-time">Date fin:</label>
  <input type="datetime-local" id="meeting-time" name="date_fin" value="2018-06-12T19:30">
  <p><button class="btn btn-primary btn-lg btn-block" type="submit">Créer</button></p>
  @csrf
</form>

@endsection