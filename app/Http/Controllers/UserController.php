<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cours;
use App\Models\Formation;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function acceptRefusUserForm(Request $request)
    {
        $users = User::where('type', NULL)->get();
        return view('admin.acceptRefusUserForm', ['users' => $users]);
    }

    public function acceptRefusUser(Request $request)
    {

        $validated = $request->validate([]);
        $choix = $request->choix;
        // Récupérer la reponse ( "oui" pour activer le compte , "non" pour supprimmer le compte)
        $reponse = substr($choix, 0, 3);

        // Récupérer le user_id avec l'expression rationnelle
        $user_id = preg_replace('/[^0-9]/', '', $choix);

        // Récupérer l'utilisateur
        $user = User::findOrFail($user_id);

        $formation_id = $user->formation_id;

        // Activé le compte 
        if (!strcmp($reponse, "oui")) {
            // Activé le compte etudiant
            if ($formation_id) {
                $user->type = "etudiant";
                $request->session()->flash('etat', 'Compte etudiant activé !');
            }
            // Activé le compte enseignant
            else {
                $user->type = "enseignant";
                $request->session()->flash('etat', 'Compte enseignant activé !');
            }
            $user->save();
        }
        // Supprimmé le compte
        else {
            $user->delete();
            $request->session()->flash('etat', 'Compte supprimmé !');
        }

        // Redirection vers la liste des compte activé
        return redirect('/');
    }

    public function index()
    {
        $admin = Auth::user();
        $users = User::where('id', '<>', $admin->id)->get();
        $compt = 0;
        foreach ($users as $u) {
            $formation = $u->formation;
            if ($u->formation_id != NULL) {
                $formations_intitule[$compt] = $formation['intitule'];
            } else {
                $formations_intitule[$compt] = 'Pas de formation';
            }

            $compt++;
        }
        return view('admin.index', ['users' => $users, 'formations_intitule' => $formations_intitule]);
    }

    public function showForm(Request $request)
    {

        $formations = Formation::All();

        // Apres le choix (etudiant, enseignant, admin)
        if (isset($request->type)) {

            $request->validate([
                'type' => 'required'
            ]);

            if ((!strcmp($request->type,  'etudiant')) ||  (!strcmp($request->type,  'admin')) || (!strcmp($request->type,  'enseignant'))) {

                return view('admin.register', ['formations' => $formations, 'type' => $request->type]);
            } else {
                abort(404);
            }
        }
        // Avant le choix (etudiant, enseignant, admin)
        return view('admin.register', ['formations' => $formations]);
    }

    public function store(Request $request)
    {
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
        } else {
            abort(404);
        }

        $user = new User();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->login = $request->login;
        $user->mdp = Hash::make($request->mdp);
        $user->type = $request->type;

        // Si l'utilisateur est un étudiant   
        if ($request->type == 'etudiant')
            $user->formation_id = $request->formation_id;
        // Si l'utilisateur est un ense ignant ou  Admin 
        else
            $user->formation_id = NULL;
        $user->save();
        session()->flash('etat', 'Compte créer avec succès');

        return redirect('/');
    }

    public function edit(Request $request, $id)
    {

        $formations = Formation::All();
        $user = User::findOrFail($id);

        // Apres le choix (etudiant, enseignant, admin)
        if (isset($request->type)) {

            $request->validate([
                'type' => 'required'
            ]);

            if ((!strcmp($request->type,  'etudiant')) ||  (!strcmp($request->type,  'admin')) || (!strcmp($request->type,  'enseignant'))) {

                return view('admin.edit', ['id' => $id, 'formations' => $formations, 'type' => $request->type, 'user' => $user]);
            } else {
                abort(404);
            }
        }
        // Avant le choix (etudiant, enseignant, admin)
        return view('admin.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string'
        ]);

        if ((!strcmp($request->type,  'etudiant'))) {
            $request->validate([
                'nom' => 'bail|required|string|min:4|max:40',
                'prenom' => 'bail|required|string|min:4|max:40',
                'login' => 'bail|required|string|max:30|unique:users',
                'formation_id' => '|required|numeric',
            ]);
        } else if ((!strcmp($request->type,  'admin')) || (!strcmp($request->type,  'enseignant'))) {
            $request->validate([
                'nom' => 'bail|required|string|min:4|max:40',
                'prenom' => 'bail|required|string|min:4|max:40',
                'login' => 'bail|required|string|max:30|unique:users',
            ]);
        } else {
            abort(404);
        }

        $user = User::findOrFail($id);
        
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->login = $request->login;
        $user->type = $request->type;

        // Si l'utilisateur est un étudiant   
        if ($request->type == 'etudiant')
            $user->formation_id = $request->formation_id;
        // Si l'utilisateur est un enseignant ou  Admin 
        else
            $user->formation_id = NULL;

        $user->save();
        session()->flash('etat', 'Compte modifié avec succès');

        return redirect('/admin/users');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        return view('admin.delete', ['id' => $id, 'user' => $user]);
    }

    public function destroy(Request $request, $id)
    {

        $request->validate([
            'reponse' => 'required|string',
        ]);
        

        if (!strcmp($request->reponse, 'annuler')) {

            session()->flash('etat', 'Suppression annulé');
            return redirect('/admin/users');
        } else if (!strcmp($request->reponse, 'supprimer')) {
            $user = User::findOrFail($id);
            $user->delete();

            session()->flash('etat', 'Suppression effectué avec succès');
            return redirect('/admin/users');
        }
    }
}
