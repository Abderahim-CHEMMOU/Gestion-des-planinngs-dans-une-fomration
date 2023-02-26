<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cours;
use App\Models\Planning;

class EnseignantController extends Controller
{
    public function index()
    {
        // Récupérer le responsable de cours
        $user = Auth::user();

        $user = User::where('id', $user->id)->first();
        // Récupérer les cours dont l'enseignant est le responsable
        $cours = $user->cours;
        return view('enseignant.listeCours.index', ['cours' => $cours]);
    }


    public function create()
    {

        // Récupérer le responsable des cours
        $user = Auth::user();
        $user = User::where('id', $user->id)->first();

        // Récupérer les cours dont l'enseignant est le responsable
        $cours = $user->cours;
        return view('enseignant.plannings.create', ['cours' => $cours]);
    }

    public function store(Request $request)
    {
        $validor = $request->validate([
            'cours_id' => 'required|numeric',
            'date_debut' => 'required|date_format:Y-m-d\TH:i',
            'date_fin' => '|bail|required|date_format:Y-m-d\TH:i|after_or_equal:date_debut',
        ]);

        $c = Cours::findOrFail($validor['cours_id']);
        $p = new Planning();
        $p->date_debut = $validor['date_debut'];
        $p->date_fin = $validor['date_fin'];

        $c->plannings()->save($p);

        $request->session()->flash('etat', 'Un nouveau Planning est crée !');
        return redirect('/');
    }

    public function edit($id)
    {
        // Récupérer le responsable de cours
        $user = Auth::user();
        $user = User::where('id', $user->id)->first();
        
        // Récupérer les cours dont l'enseignant est le responsable
        $listeCours = $user->cours;

        // Récupérer le planning
        $planning = Planning::find($id);

        // Récupérer le cours actuel
        $coursActuel = Cours::find($planning->cours_id);
        
        return view('enseignant.plannings.edit', ['id' => $id, 'planning' => $planning,  'listeCours' => $listeCours, 'coursActuel' => $coursActuel]);
    }

    public function update(Request $request, $id)
    {
        
        $validor = $request->validate([
            'cours_id' => 'required|numeric',
            'date_debut' => 'required|date_format:Y-m-d\TH:i',
            'date_fin' => '|bail|required|date_format:Y-m-d\TH:i|after_or_equal:date_debut',
        ]);

        $c = Cours::findOrFail($validor['cours_id']);
        $p = Planning::findOrFail($id);
        $p->date_debut = $validor['date_debut'];
        $p->date_fin = $validor['date_fin'];

        $c->plannings()->save($p);

        $request->session()->flash('etat', 'Votre Planning est modifié !');
        return redirect('/');
    }
    
    public function delete($id)
    {
        // Récupérer le responsable de cours
        $user = Auth::user();
        $user = User::where('id', $user->id)->first();

        // Récupérer le planning
        $planning = Planning::findOrFail($id);

        // Récupérer le cours actuel
        $coursActuel = Cours::findOrFail($planning->cours_id);
        
        return view('enseignant.plannings.delete', ['id' => $id, 'planning' => $planning, 'coursActuel' => $coursActuel->intitule]);
    }

    public function destroy(Request $request, $id)
    {
        $p = Planning::findOrFail($id);
        $p->delete();
        $request->session()->flash('etat', 'Le Planning est supprimeé !');
        return redirect('/');
    }
}
