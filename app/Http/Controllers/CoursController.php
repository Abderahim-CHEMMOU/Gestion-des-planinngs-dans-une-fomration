<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cours;
use App\Models\Formation;
use App\Models\User;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Cours::All();

        $compt = 0;
        foreach ($cours as $c) {
            $formation = Formation::findOrFail($c->formation_id);
            $formations[$compt] = $formation->intitule;
            $enseignant = User::findOrFail($c->user_id);
            $enseignants[$compt] = $enseignant->nom . " " .  $enseignant->prenom;
            $compt++;
        }
        return view('admin.cours.index', ['cours' => $cours, 'formations' => $formations, 'enseignants' => $enseignants]);
    }

    public function etudIndex()
    {
        // Récupérer l'utilisateur courant
        $user = Auth::user();

        // Récupérer la liste des cours de l'étudiant
        $cours = $user->formation->cours;

        return view('etudiant.listeCours.etudIndex', ['cours' => $cours]);
    }
    //
    public function create()
    {
        $formations = Formation::All();

        $enseignants = User::where('type', 'enseignant')->get();

        return view('admin.cours.create', ['formations' => $formations, 'enseignants' => $enseignants]);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'intitule' => 'bail|required|string|min:2|max:50',
            'formation_id' => 'required|numeric',
            'ens_id' => 'required|numeric'
        ]);

        $cours = new Cours();
        $cours->intitule = $validated['intitule'];


        $formation = Formation::findOrFail($validated['formation_id']);
        $user = User::findOrFail($validated['ens_id']);

        $cours->formation()->associate($formation);
        $cours->user()->associate($user);

        $cours->save();

        $request->session()->flash('etat', 'Ajout effectué !');
        // Redirection vers la page d'affichage des cours
        return redirect('/admin/cours');
    }

    public function searchCourseForm()
    {

        return view('admin.cours.searchCourseForm');
    }

    public function searchCourse(Request $request)
    {
        $validated = $request->validate([
            'intitule' => 'bail|required|string|min:2|max:50',
        ]);

        $cours = Cours::where('intitule', $request->intitule)->get();

        if ($cours == NULL) {
            $request->session()->flash('etat', 'Ce cours n\'existe pas');
            // Redirection vers la page d'affichage des cours
            return redirect('/admin/cours');
        } else {
            $compt = 0;
            foreach ($cours as $c) {
                $formations[$compt] = $c->formation;
                $compt++;
            }

            $compt = 0;
            foreach ($cours as $c) {

                $enseignants[$compt] = User::where('id', $c->user_id)->first();
                $compt++;
            }


            $request->session()->flash('etat', 'Cours trouvé');
            // Redirection vers la page d'affichage des cours
            return view('admin.cours.searchCourseForm', ['cours' => $cours, 'enseignants' => $enseignants, 'formations' => $formations]);
        }
    }

    public function edit($id)
    {

        $cours = Cours::findOrFail($id);
        $enseignants = User::where('type', 'enseignant')->get();

        $formations = Formation::All();
        return view('admin.cours.edit', ['id' => $id, 'cours' => $cours, 'enseignants' => $enseignants, 'formations' => $formations]);
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'intitule' => 'bail|required|string|min:2|max:50',
            'Enseignant' => 'required|numeric',
            'formation' => 'required|numeric'
        ]);

        $c = Cours::findOrFail($id);
        $c->intitule = $validated['intitule'];
        // $cours->formation_id = $validated['formation'];
        // $cours->user_id = $validated['Enseignant'];

        $f = Formation::findOrFail($validated['formation']);
        $u = User::findOrFail($validated['Enseignant']);



        $c->formation()->associate($f);
        $c->user()->associate($u);
        $c->save();

        $request->session()->flash('etat', 'Modification effectué !');
        // Redirection vers la page d'affichage des cours
        return redirect('/admin/cours');
    }

    public function delete($id)
    {

        $cours = Cours::findOrFail($id);
        $enseignant = $cours->user;


        $formation = $cours->formation;

        return view('admin.cours.delete', ['id' => $id, 'cours' => $cours, 'enseignant' => $enseignant, 'formation' => $formation]);
    }

    public function destroy(Request $request, $id)
    {
        $validated = $request->validate([
            'reponse' => 'required|string',
        ]);
        if (strcmp($validated['reponse'], 'oui')) {
            $c = Cours::findOrFail($id);
            
            $c->delete();
            $request->session()->flash('etat', 'Suppression effectué avec succès !');
            return redirect('/admin/cours');
        } else if (strcmp($validated['reponse'], 'non')) {
            $request->session()->flash('etat', 'Annulation de la suppression !');
            return redirect('/admin/cours');
        } else {
            return abort(404);
        }
    }
}
