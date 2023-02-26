@extends('modele')

@section('title', 'Ajouter un cours')

@section('contents')
<h3>Ajouter un cours</h3>
<form action="{{route('admin.cours.store')}}" method="post">

    <table class="table">
        <thead class="table-dark">
            <tr>
                <th scope="col">Cours</th>
                <th scope="col">Formation</th>
                <th scope="col">Enseignant</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input type="text" name="intitule" value="{{old('intitule')}}" placeholder="Le nom de cours" required>
                </td>
                <td>
                    <select class="form-select" aria-label="Default select example" name="formation_id" id="formation_id">
                        @foreach($formations as $f)
                        <option value="{{$f->id}}">{{$f->intitule}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="ens_id">
                        @foreach($enseignants as $ens)
                        <option value="{{$ens->id}}">{{$ens->nom}} {{$ens->prenom}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="text-center">
        <input type="submit" class="btn btn-primary btn-lg" value="Ajouter">
    </div>
    @csrf
</form>
@endsection