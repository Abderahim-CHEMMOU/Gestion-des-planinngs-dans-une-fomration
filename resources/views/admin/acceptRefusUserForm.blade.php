@extends('modele')

@section('title', 'Acceptation ou Refus d’un utilisateur')

@section('contents')

<form action="{{route('admin.acceptRefusUser')}}" method="post">
    @method('put')
        <table class="table">
            <thead class="table-dark">
            <tr>
            <th scope="col">Id</th>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Login</th>
            <th scope="col">formation_id</th>
            <th scope="col">Type</th>
            <th scope="col">Compte</th>
            </tr>
            </thead>
            <tbody>
        @foreach($users as $u)
            <tr>
            <th >{{$u->id}}</th>
            <td>{{$u->nom}}</td>
            <td>{{$u->prenom}}</td>
            <td>{{$u->login}}</td>
            <td>@if($u->formation_id) {{$u->formation_id}} @else NULL @endif</td>
            <td>NULL</td>
            
            <td>
                <input type="radio" name="choix" value="oui{{$u->id}}"/>Validé
                <input type="radio" name="choix" value="non{{$u->id}}"/>Supprimmé
                <input type="submit" value="OK"/>
            </td>
            </tr>
        @endforeach
        </tbody>
        </table>
    @csrf
    </form>
        

@endsection

