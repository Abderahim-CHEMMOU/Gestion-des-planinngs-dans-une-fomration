@extends('modele')

@section('title', 'Mes cours')

@section('contents')
<ul class="list-group">
    @foreach($cours as $c)
    <li class="list-group-item list-group-item-dark">{{$c->intitule}}</li>
    @endforeach
</ul>
@endsection