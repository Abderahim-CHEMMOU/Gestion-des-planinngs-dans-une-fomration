@extends('modele')

@section('title', 'Créez un planning')

@section('contents')

<!--<form action="{{route('enseignant.plannings.vuesPlannings.index')}}" method="post"> -->
<form action="enseignant.plannings.vuesPlannings.index" method="get">
    <table id="calendar">
        <caption>August 2014</caption>
        <tr class="weekdays">
            @foreach($semaineEnvoye['Nomsjours'] as $Nomjour )
            <th scope="col">{{$Nomjour}}</th>
            @endforeach
        </tr>



        <tr class="days">
            @foreach($semaineEnvoye['jour'] as $jour)
            <td class="day">
                <div class="date">{{$jour}}</div>
            </td>
            @endforeach
        </tr>



        <p> <a class="lien1" href="{{route('enseignant.plannings.vuesPlannings.index', ['suivant'=> 'avancer', 'semaineEnvoye' => $semaineEnvoye])}}">Semaine suivante</a></p>
        <p> <a class="lien1" href="{{route('enseignant.plannings.vuesPlannings.index', ['precedent'=> 'reculer'])}}">Semaine précendete</a></p>
        @isset($suivant)
        dahi
        {{$suivant}}
        @endisset

        @empty($suivant)
        Rien de rien
        @endempty


    </table>
    @csrf
</form>
<!--
<input id="prodId" name="prodId" type="hidden" value="xm234jq">
    <button type="submit" value="" class="btn btn-primary">Primary</button>
@csrf
</form>
-->
@endsection