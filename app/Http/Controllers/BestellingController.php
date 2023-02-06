<?php

namespace App\Http\Controllers;

use App\Models\Bestelling;
use App\Models\cart;
use App\Models\Item;
use App\Models\order;
use App\Models\Winkelwagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Foreach_;

class BestellingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'user_id' => 'required|max:255', //user_id moet perse ingevuld zijn
            'totaal' => 'required|max:255', // totaal ook

        ]);

        Bestelling::create($request->except('_token'));

        return redirect()->route('bestel.store'); // als die is aangemaakt moet die je sturen naar de store
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $userId = Auth::id(); //haalt het unieke ID van de huidige aangemelde gebruiker op
        $winkelwagen = Winkelwagen::where('user_id', $userId)->get(); //haalt de winkelwagen op die bij de user_id is gelinkt
        $bestelling = Bestelling::where('user_id', $userId)->get(); //haalt de bestelling op die bij de user_id is gelinkt
        Foreach($bestelling as $item){ 
            if ($item->status == 'ontvangen'){
                $existingOrderItems = Item::where('bestel_id', $item->id)->get();//wordt gecontroleerd of er al items bestaan voor die bestelling in de database

                if ($existingOrderItems->isEmpty()){ //controleerd of existingitems leeg is
                    foreach ($winkelwagen as $item2){ //
                        if (!is_null($item2)){ //
                            $pizza = $item2->pizza_id; //definieert de variabele $pizza en geeft deze de waarde van de "pizza_id" eigenschap van het object $item2.
                            $stuks = $item2->stuks; //definieert de variabele $stuks en geeft deze de waarde van de "stuks" eigenschap van het object $item2.
                            Item::create([ //nieuw item te maken en deze op te slaan in de database.
                                'bestel_id' => $item->id, //eigenschap van het object $item bevat en deze koppelt aan de sleutel "bestel_id".
                                'pizza_id' => $pizza,//de waarde van de variabele $pizza en koppelt deze aan de sleutel "pizza_id"
                                'stuks' => $stuks //de waarde van de variabele $stuks en koppelt deze aan de sleutel "stuks"
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->route('winkelwagen.destroy'); // leegt de winkelwagen
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bestelling  $bestelling
     * @return \Illuminate\Http\Response
     */
    public function show($bestelling)
    {
        $id = Auth::id(); //haalt het unieke ID van de huidige aangemelde gebruiker op
        $bestelling = Bestelling::where('user_id', $id)->get(); //een verzameling van "bestellingen" op te halen waarvan het "user_id" veld gelijk is aan de waarde van de variabele "$id"
        return view('site.status', ['status' => $bestelling]); // de "status" blade-view geretourneerd met de variabele "$bestelling" als data. De "site.status" zal de verzameling "bestellingen" kunnen weergeven en manipuleren.
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bestelling  $bestelling
     * @return \Illuminate\Http\Response
     */
    public function edit(Bestelling $bestelling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bestelling  $bestelling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bestelling $bestelling)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bestelling  $bestelling
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $userId = Auth::id(); //haalt het ID van de gebruiker op
        $winkelwagen = Winkelwagen::where('user_id', $userId)->get(); //alle items uit de winkelwagen van deze gebruiker op te halen

        foreach ($winkelwagen as $item){ //Als het item niet "null" is, dan wordt het item uit de winkelwagen verwijderd met "Winkelwagen::destroy($item->id)".
            if (!is_null($winkelwagen)){
                Winkelwagen::destroy($item->id);
            }
        }

        return redirect()->route('status.show',['bestelling' => $userId]); //de gebruiker doorverwezen naar een route genaamd "status.show" met een parameter "bestelling" gelijk aan het ID van de gebruiker.
    }
}
