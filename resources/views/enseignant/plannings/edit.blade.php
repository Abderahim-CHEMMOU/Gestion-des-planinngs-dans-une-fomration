@extends('modele')

@section('title', 'Modifier le planning')

@section('contents')
<form action="{{route('enseignant.plannings.update', ['id'=>$id])}}" method="post">
    @method('put')
    <div class="form-group">
        <h3 class="display-3">Modifiez le planning</h3>
        <p class="p-3 mb-2 bg-secondary text-white w-25 p-3 position-relative fs-2">Cours actuel:
            <span class="fs-4">{{$coursActuel->intitule}}</span>
        </p>
    </div>

    <div class="form-group">
        <p class="p-3 mb-2 bg-dark text-white w-50 p-3">
            <span class="fs-4"><label for="pet-select">Choisissez un cours:</label></span>
            <select name="cours_id" id="pet-select" class="form-select" aria-label="Default select example">
                @foreach($listeCours as $cours)
                <option value="{{$cours->id}}">{{$cours->intitule}}</option>
                @endforeach
            </select>
        </p>
    </div>

    <div class="form-group">
        <label for="meeting-time"><strong>Date début :</strong></label>
        <input class="border border-primary" type="datetime-local" id="meeting-time" name="date_debut" value="{{$planning->date_debut}}">

        <label for="meeting-time"><strong>Date fin:</strong></label>
        <input class="border border-primary" type="datetime-local" id="meeting-time" name="date_fin" value="{{$planning->date_fin}}">
    </div>

    <div class="form-group">
        <p><button class="btn btn-primary btn-lg btn-block .btn-lg" type="submit">Modifiez</button></p>
    </div>
    @csrf
</form>
@endsection