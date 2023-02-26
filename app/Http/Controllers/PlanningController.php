<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cours;
use App\Models\Planning;

class PlanningController extends Controller
{
    //

    public function indexVue(Request $request)
    {
        $user = Auth::user();

        $plannings = Planning::All();
        $compt = 0;
        foreach ($plannings as $pl) {
            $cours[$compt] =  Cours::where('id', $pl->cours_id)->first();
            $compt++;
        }

        return view('enseignant.plannings.indexVue', ['cours' => $cours, 'plannings' => $plannings]);
    }

    public function index(Request $request)
    {

        // Récupérer l'enseignant
        $user = Auth::user();

        //$user = User::where('id', $user[0]->id)->first();
        // Récupérer les cours dont l'enseignant est le responsable
        $cours = $user->cours;

        $annneEnCours = date("Y");


        /*
        for($mois = 1; $mois <= 12; $mois++){
            $calendrier[$mois] = cal_days_in_month ( CAL_GREGORIAN , $mois , $annneEnCours );
        }
        */


        if ((!isset($request->suivant)) && (!isset($request->precedent))) {
            // Premier mois de l'annnée (Janvier)
            $semaineEnvoye['mois'] = 1;

            //La premiere semaine de l'année
            $premierJourSemaine = 1;
            for ($compt = 1; $compt <= 7; $compt++) {
                $semaineEnvoye['jour'][$compt] = $compt;
                $j =  strtotime($compt . "-" . $semaineEnvoye['mois'] . "-" .  $annneEnCours);
                $nomsJours[$compt] = date("D", $j);
            }
            $semaineEnvoye['Nomsjours'] = $nomsJours;
            return view('enseignant.plannings.vuesPlannings.index', ['cours' => $cours, 'annneEnCours' => $annneEnCours, 'semaineEnvoye' => $semaineEnvoye]);
        }

        if (isset($request->suivant)) {
            $semaineEnvoye = $request->semaineEnvoye;

            // Incrémenter le mois si c'est la fin de mois actuel
            //dump( ' Mois actuel' . cal_days_in_month ( CAL_GREGORIAN , $semaineEnvoye['mois'], $annneEnCours));
            //dd( 'jour7 = '. $semaineEnvoye['jour']['7']);

            // Quand on arrive au 28 eme jour du mois la semaine suivante contiendera 2 mois différents

            if (($semaineEnvoye['jour']['7'] == 28) && (cal_days_in_month(CAL_GREGORIAN, $semaineEnvoye['mois'], $annneEnCours) != 28)) {

                $ResteJourMoisActuel = cal_days_in_month(CAL_GREGORIAN, $semaineEnvoye['mois'], $annneEnCours) - 28;
                $limite = $ResteJourMoisActuel;
                if ($ResteJourMoisActuel != 0) {
                    // La semaine suivante le meme mois
                    for ($compt = 1; $compt <= $limite; $compt++) {
                        $semaineEnvoye['jour'][$compt] = $semaineEnvoye['jour'][$compt] + 7;
                        $j =  strtotime($semaineEnvoye['jour'][$compt] . "-" . $semaineEnvoye['mois'] . "-" .  $annneEnCours);
                        $nomsJours[$compt] = date("D", $j);
                    }
                }

                //le mois suivant
                $semaineEnvoye['mois']++;

                // La semaine suivante (Un autre mois)
                $continue = 7 - $ResteJourMoisActuel;

                $comptJour = 1;
                for ($compt = $continue; ($compt <= 7) && ($comptJour <= $continue); $compt++) {
                    $semaineEnvoye['jour'][$compt] = $comptJour;
                    $j =  strtotime($semaineEnvoye['jour'][$compt] . "-" . $semaineEnvoye['mois'] . "-" .  $annneEnCours);
                    $nomsJours[$compt] = date("D", $j);
                    $comptJour++;
                }
                $semaineEnvoye['Nomsjours'] = $nomsJours;
            } else if ($semaineEnvoye['jour']['1'] == 29) {


                // La debut de mois suivant  
                $jour = $semaineEnvoye['jour']['7'];
                for ($compt = 1; $compt <= 7; $compt++) {
                    $semaineEnvoye['jour'][$compt] = $jour + $compt;
                    $j =  strtotime($semaineEnvoye['jour'][$compt] . "-" . $semaineEnvoye['mois'] . "-" .  $annneEnCours);
                    $nomsJours[$compt] = date("D", $j);
                }
                $semaineEnvoye['Nomsjours'] = $nomsJours;
            } else if ((cal_days_in_month(CAL_GREGORIAN, $semaineEnvoye['mois'], $annneEnCours) == 28)) {

                $premierJourSemaine = 1;
                for ($compt = 1; $compt <= 7; $compt++) {
                    $semaineEnvoye['jour'][$compt] = $compt;
                    $j =  strtotime($compt . "-" . $semaineEnvoye['mois'] . "-" .  $annneEnCours);
                    $nomsJours[$compt] = date("D", $j);
                }
                $semaineEnvoye['Nomsjours'] = $nomsJours;
                //le mois suivant
                $semaineEnvoye['mois']++;
            } else {

                // La semaine suivante (le meme mois)    
                for ($compt = 1; $compt <= 7; $compt++) {
                    $semaineEnvoye['jour'][$compt] = $semaineEnvoye['jour'][$compt] + 7;
                    $j =  strtotime($semaineEnvoye['jour'][$compt] . "-" . $semaineEnvoye['mois'] . "-" .  $annneEnCours);
                    $nomsJours[$compt] = date("D", $j);
                }
                $semaineEnvoye['Nomsjours'] = $nomsJours;
            }


            // Supprimer la variable $suivant
            $request->request->remove('suivant');
            return view('enseignant.plannings.vuesPlannings.index', ['cours' => $cours, 'annneEnCours' => $annneEnCours, 'semaineEnvoye' => $semaineEnvoye, 'suivant' => $request->suivant]);
        }
        /*
        // pas de page précedente
        if(($jour < 8) && ($mois == 1) ){

        }
        
        // pas de page suivante
        if(($jour > 24) && ($mois == 12)  ){

        }

        */

        //Envoyer la semaine précendete
        if (isset($request->precedent)) {
            $semaineEnvoye = $request->semaineEnvoye;

            // Décrémenter le mois si c'est la debut de mois actuel
            if ($semaineEnvoye['jour']['1'] == 1) {
                $semaineEnvoye['mois']--;
            }

            // La semaine précedente
            for ($compt = 1; $compt <= 7; $compt++) {
                $semaineEnvoye['jour'][$compt] = $semaineEnvoye['jour'][$compt] - 7;
            }

            // Supprimer la variable $precedent
            $request->request->remove('precedent');
            return view('enseignant.plannings.vuesPlannings.index', ['cours' => $cours, 'annneEnCours' => $annneEnCours, 'semaineEnvoye' => $semaineEnvoye, 'suivant' => $request->suivant]);
        }

        //return view('enseignant.plannings.vuesPlannings.index', ['cours' => $cours, 'annneEnCours' => $annneEnCours, 'semaineEnvoye' => $semaineEnvoye]);
    }
}
