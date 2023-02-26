@extends('modele')

@section('title', 'Les cours de la formation')

@section('contents')
<ul class="list-group">
    @foreach($cours as $c)
    <li class="list-group-item list-group-item-dark">{{$c->intitule}}</li>
    @endforeach
</ul>
@endsection