<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\Pizza;
use App\Models\Winkelwagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WinkelwagenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id(); //haalt het unieke ID van de huidige aangemelde gebruiker op
        $winkelwagen = Winkelwagen::where('user_id', $userId)->get(); //alle winkelwagens opgehaald die behoren tot deze gebruiker
        //naar de "Winkelwagen" tabel waarbij wordt gezocht op het "user_id" veld.
        $pizza = Pizza::all(); //alle pizza's uit de "Pizza" tabel opgehaald.
        return view('site.menu', compact('winkelwagen','pizza')); //de "menu" view geretourneerd en worden de opgehaalde "winkelwagen"
        // en "pizza" gegevens meegegeven
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([ //
            'user_id' => 'required|max:255', //de gegevens die zijn verzonden met de HTTP-request gevalideerd.
            'pizza_id' => 'required|max:255', //in dit geval moeten de velden "user_id", "pizza_id" en "stuks" worden ingevuld
            'stuks' => 'required|max:255', //moeten ze elk minder dan of gelijk zijn aan 255 karakters lang.
        ]);

        Winkelwagen::create($request->except('_token')); //Als de gegevens geldig zijn, wordt er een nieuwe rij aan de "Winkelwagen" 
        //tabel toegevoegd met de gegevens die zijn verzonden met de request
        return redirect()->route('menu'); //wordt er een redirect naar de "menu"-route geretourneerd
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Winkelwagen  $winkelwagen
     * @return \Illuminate\Http\Response
     */
    public function show(Winkelwagen $winkelwagen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Winkelwagen  $winkelwagen
     * @return \Illuminate\Http\Response
     */
    public function edit(Winkelwagen $winkelwagen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Winkelwagen  $winkelwagen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Winkelwagen $winkelwagen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Winkelwagen  $winkelwagen
     * @return \Illuminate\Http\Response
     */
    public function destroy( $winkelwagen)
    {
        Winkelwagen::destroy($winkelwagen);//Binnen de functie wordt de "Winkelwagen" tabel verwijderd 
        //waarvan het ID gelijk is aan de meegegeven "$winkelwagen" variabele.
        return redirect()->route('menu'); //wordt er een redirect naar de "menu"-route geretourneerd
    }
}
