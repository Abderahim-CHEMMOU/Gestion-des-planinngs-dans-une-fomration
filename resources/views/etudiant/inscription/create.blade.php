@extends('modele')

@section('title', 'Mes cours')

@section('contents')
    <form  action="{{route('etudiant.inscription.store')}}" method="post">
    <div class="form-group">
        <label for="exampleFormControlSelect2"> choisissez un cours</label>
        <select multiple class="form-control" name="cours_id" id="exampleFormControlSelect2">
        @foreach($cours as $c)
        <option value="{{$c->id}}">{{$c->intitule}}</option>
        @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Ajoutez</button>
    @csrf
    </form>
@endsection
