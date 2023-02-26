<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cours;
use App\Models\User;
use App\Models\Formation;

class EtudiantController extends Controller
{
    public function index(){
         // Récupérer l'utilisateur courant
         $user = Auth::user();
         
         $user = User::where('id',$user->id)->first();         
         // Récupérer les cours dont l'étudiant est inscrit
         $cours = $user->polyCours;         
        return view('etudiant.inscription.index',['cours' => $cours]);
    }
    
    public function show($id){
        return view('etudiant.inscription.index',['id' => $id]);
    }

    public function create(){
         // Récupérer l'utilisateur courant
        $user = Auth::user();
        $user = User::findOrFail($user->id);
        
        // Récupérer les cours de la formation dont l'étudiant est  inscrit
        $inscritCours = $user->polyCours;

        // Récupérer les cours de la formation de l'étudiant 
        $formation_id = $user->formation->id;
        
        // Créer un tableau des ID des cours dont l'étudiant est inscrit
        $compt = 0;
        foreach($inscritCours as $inc){
            $inscritCours_id[$compt] = $inc->id;
            $compt++;
        }

        // Récupérer les cours de la formation dont l'étudiant n'est pas inscrit 
        $cours = Cours::where('formation_id', $formation_id)->whereNotIn('id', $inscritCours_id)->get();
        return view('etudiant.inscription.create',['cours' => $cours]);
    }
    
    public function store(Request $request){
        $request->validate([
            'cours_id'=>'required',
        ]);
        
        $user = Auth::user();
        $cours_id = $request->cours_id;
        $e = User::where('id',$user->id)->first();
        $c = Cours::where('id',$cours_id)->first();
        $c->users()->attach($e);

        
        $request->session()->flash('etat','Inscription au cours effectué !');
        return redirect('/etudiant/inscription');
    }

    public function delete(Request $request, $id){
        return view('etudiant.inscription.delete',['id' => $id]);
    }

    public function destroy(Request $request, $id){
        $request->validate([
            
        ]);
        
        $user = Auth::user();
        $cours_id = $id;
        $e = User::where('id',$user->id)->first();
        $c = Cours::where('id',$cours_id)->first();
        $c->users()->detach($e);

        $request->session()->flash('etat','Désinscription au cours effectué !');
        return redirect('/etudiant/inscription');
    }

    public function search(){
       return view('etudiant.inscription.search');
    }
   
   public function result(Request $request){
       $request->validate([
           'cours_intitule'=>'required',
       ]);
       $cours_intitule = $request->cours_intitule;
       
       $user = Auth::user();
       //$e = User::where('id',$user->id)->first();
       
       // Récupérer les cours de la formation
       $inscritCours = $user->formation->cours;
       $user = Auth::user();
       $boolCours = Cours::where('intitule',$cours_intitule)->first();
       
       //Redirection vers le cours
        if($boolCours){
            $request->session()->flash('etat','Ce cours existe');
            return view('etudiant.listeCours.show',['id' => $boolCours->intitule]);
        }
        else{
            
            $request->session()->flash('etat','Ce cours n\'existe pas');
            return view('etudiant.listeCours.show',['id' => NULL, 'chaine_non_trouve'=>$cours_intitule]);
        }

       
   }
    
}
