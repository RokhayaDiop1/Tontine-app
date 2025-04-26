<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Tontine;
use App\Models\User;

class GerantController extends Controller
{
    public function index()
{
    return view('pages.gerant.dashboard');
}


public function dashboard()
    {
        $tontines = Tontine::where('gerant_id', Auth::id())->get();

        return view('pages.gerant.dashboard', compact('tontines'));
    }


   

    public function tontinesDuGerant()
{
    $tontines = Tontine::withCount('participants')
                ->where('user_id', Auth::id())
                ->get();

    return view('pages.gerant.tontines', compact('tontines'));
}
    
    public function participantsDuGerant() {
        // À adapter selon ta relation
        return view('pages.gerant.participants');
    }
    
    public function cotisationsDuGerant() {
        return view('pages.gerant.cotisations');
    }
    
    public function tiragesDuGerant() {
        return view('pages.gerant.tirage');
    }

    
}