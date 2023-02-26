<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Formation;
use App\Models\User;
use App\Models\Cours;
use App\Models\Planning;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::All();
        return view('admin.formations.index', ['formations' => $formations]);
    }

    //
    public function create()
    {

        return view('admin.formations.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'intitule' => 'bail|required|string|min:2|max:50',
        ]);

        $formation = new Formation();
        $formation->intitule = $validated['intitule'];


        $formation->save();

        $request->session()->flash('etat', 'Ajout effectué !');
        // Redirection vers la page d'affichage des formations
        return redirect('/');
    }

    public function edit($id)
    {
        $formation = Formation::findOrFail($id);
        return view('admin.formations.edit', ['id' => $id, 'formation' => $formation]);
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'intitule' => 'bail|required|string|min:2|max:50',
        ]);

        $formation = Formation::findOrFail($id);
        $formation->intitule = $validated['intitule'];
        $formation->save();


        $request->session()->flash('etat', 'Modifcation effectué !');
        return redirect('/admin/formations');
    }

    public function delete($id)
    {
        $formation = Formation::findOrFail($id);
        return view('admin.formations.delete', ['id' => $id, 'formation' => $formation]);
    }

    public function destroy(Request $request, $id)
    {

        $request->validate([
            'reponse' => 'required|string',
        ]);

        if (!strcmp($request->reponse, 'non')) {
            session()->flash('etat', 'Suppression annulé');
            return redirect('/admin/formations');
        } else if (!strcmp($request->reponse, 'oui')) {

            $formation = Formation::findOrFail($id);

            $cours = $formation->cours()->get();


            /*
            //$plannings[$compt] = $c->plannings()->get();

            $compt = 0;
            foreach ($cours as $c) {

                if (!empty($c->plannings()->get())) {
                    $plannings[$compt] = $c->plannings()->get();
                    $compt++;
                }
            }

            if (isset($plannings) && !empty($plannings)) {

                foreach ($plannings as $pl) {

                    if (isset($pl) && !empty($pl)) {
                        
                        $pl->delete();
                    }
                }
            }
            */

            $users = $formation->users()->get();
            $cours->delete();
            $users->delete();
            $formation->delete();
            session()->flash('etat', 'Suppression effectué avec succès');
            return redirect('/admin/formations');
        }
    }
}
