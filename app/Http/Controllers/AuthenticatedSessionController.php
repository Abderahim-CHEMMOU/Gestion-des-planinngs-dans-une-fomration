<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    public function showForm()
    {
        return view('auth.login');
    }

    // login action
    public function login(Request $request)
    {

        $request->validate([
            'login' => 'required|string',
            'mdp' => 'required|string'
        ]);

        $credentials = ['login' => $request->input('login'), 'password' => $request->input('mdp')];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $request->session()->flash('etat', 'Login successful');

            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ]);
    }

    // logout action
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function edit(Request $request)
    {

        return view('auth.password.edit');
    }
    

    public function update(Request $request)
    {

        $validated = $request->validate([
            'old_password' => 'required',
            'new_password' => 'bail|required|string|alpha_dash|min:8|max:60|confirmed',
        ]);


        // Récupérer le mot de passe actuel haché qui disponible sur la BD   
        $hashedPassword = Auth::user()->mdp;

        // Vérifier si l'acteul mot de passe entrez par l'utilisateur correspond au mot de passe actuel qui est dans la BD
        if (Hash::check($request->old_password, $hashedPassword)) {

            // Vérifier si le nouveau mot de passe entrez par l'utilisateur est différent de mot de passe actuel
            if (!Hash::check($request->new_password, $hashedPassword)) {

                // Récupérer l'Id de l'utilisateur authentifié
                $current_user_id = Auth::id();

                // Récupérer l'utilisateur authentifié
                $current_user = User::find($current_user_id);

                // Hacher le nouveau mot de passe
                $current_user->mdp = Hash::make($request->new_password);

                // Sauvegarder le nouveau mot de passe 
                $current_user->save();


                $request->session()->flash('etat', 'Modification effectué');
                return redirect()->intended('/');
            } else {
                session()->flash('etat', 'le nouveau mot de passe ne peut pas être le mot de passe actuel !');
                return redirect()->back();
            }
        } else {
            $request->session()->flash('etat', 'Mot de passe actuel érroné, modification non effectué ! Veulliez saisir le bon mot de passe.');
            return redirect()->back();
        }
    }

    public function infoPersoEdit(Request $request)
    {
        
        // Récupérer l'utilisateur courant
        $user = Auth::user();
        $nom = $user->nom;
        $prenom = $user->prenom;
        return view('auth.infoPersoEdit', ['nom' => $nom, 'prenom' => $prenom]);
    }

    
    public function infoPersoUpdate(Request $request)
    {

        $validated = $request->validate([
            'nom' => 'bail|required|string|min:4|max:40',
            'prenom' => 'bail|required|string|min:4|max:40',
        ]);
        
        // Récupérer l'utilisateur courant
        $user = Auth::user();
        $user = User::findOrFail($user->id);

        $user->nom =  $validated['nom'];
        $user->prenom =  $validated['prenom'];
        $user->save();

        $request->session()->flash('etat', 'Modification effectué');
        return redirect('/');
    }

}
