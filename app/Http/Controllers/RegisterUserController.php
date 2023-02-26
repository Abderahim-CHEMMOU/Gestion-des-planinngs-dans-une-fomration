<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Formation;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class RegisterUserController extends Controller
{
    public function showForm(Request $request)
    {
        $formations = Formation::All();
        
        // Apres le choix (etudiant, enseignant, admin)
        if (isset($request->type)) {

            $request->validate([
                'type' => 'required'
            ]);

            if ((!strcmp($request->type,  'etudiant')) ||  (!strcmp($request->type,  'admin')) || (!strcmp($request->type,  'enseignant'))) {

                return view('auth.register', ['formations' => $formations, 'type' => $request->type]);
            } else {
                abort(404);
            }
        }

        // Avant le choix (etudiant, enseignant, admin)
        return view('auth.register', ['formations' => $formations]);
    }
    
    public function store(Request $request){
        
        $request->validate([
            'type' => 'required|string'
        ]);

        if ((!strcmp($request->type,  'etudiant'))) {
            $request->validate([
                'nom' => 'bail|required|string|min:4|max:40',
                'prenom' => 'bail|required|string|min:4|max:40',
                'login' => 'bail|required|string|max:30|unique:users',
                'mdp' => 'bail|required|string|min:8|max:60|confirmed',
                'formation_id' => '|required|numeric',
            ]);
        } else if ((!strcmp($request->type,  'admin')) || (!strcmp($request->type,  'enseignant'))) {
            $request->validate([
                'nom' => 'bail|required|string|min:4|max:40',
                'prenom' => 'bail|required|string|min:4|max:40',
                'login' => 'bail|required|string|max:30|unique:users',
                'mdp' => 'bail|required|string|min:8|max:60|confirmed',
            ]);
        } else{
            abort(404);
        }

        $user = new User();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->login = $request->login;
        $user->mdp = Hash::make($request->mdp);

        // Si l'utilisateur est un étudiant   
        if ($request->type == 'etudiant')
            $user->formation_id = $request->formation_id;
        // Si l'utilisateur est un ense ignant ou  Admin 
        else
            $user->formation_id = NULL;
        
            $user->save();
        session()->flash('etat', 'Compte créer veulliez attendre la validation par l\'admin');

        return redirect('/');
    }
}
