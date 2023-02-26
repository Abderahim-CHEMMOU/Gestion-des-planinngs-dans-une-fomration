@extends('modele')

@section('title', 'Cours recherché')

@section('contents')

    @isset($id)
        {{$id}}
    @endisset
    
    @empty($id)
        <p>Aucun cours ne correspond aux termes de recherche spécifiés (<em>{{$chaine_non_trouve}}</em>).
            <h4>Suggestions :</h4>
            <ul>
                <li>Vérifiez l’orthographe des termes de recherche</li>
                <li>Essayez d'autres mots.</li>
            </ul>
        </p>
    @endempty

    
@endsection