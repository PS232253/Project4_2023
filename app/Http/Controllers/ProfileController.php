<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [ //gebruikt om de "edit" pagina van het profiel weer te geven
            'user' => $request->user(), //die de gebruiker gegevens bevat die zijn opgehaald uit het "Request"
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated()); //Binnen de functie wordt het verzoek gebruikt om de gebruikersgegevens te updaten
        // door de gegevens te vervangen door de gevalideerde gegevens uit het verzoek.

        if ($request->user()->isDirty('email')) { //Er wordt gecontroleerd of het e-mailadres van de gebruiker is gewijzigd.
            $request->user()->email_verified_at = null; //dan wordt de "email_verified_at" waarde op "null" gezet.
        }

        $request->user()->save(); //de gebruiker opgeslagen en wordt er een redirect naar de pagina "profile.edit" teruggegeven met de boodschap "profile-updated"

        return Redirect::route('profile.edit')->with('status', 'profile-updated'); //De "with" methode wordt gebruikt om een boodschap mee te geven 
        //aan de volgende pagina, in dit geval "profile-updated".
        // Deze boodschap kan worden opgehaald en getoond aan de gebruiker op de volgende pagina.
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [ //Eerst worden de verzoekgegevens gevalideerd, 
            'password' => ['required', 'current-password'], //waarbij wordt gecontroleerd of het wachtwoord vereist is en of het het huidige wachtwoord is.
        ]);

        $user = $request->user(); //Vervolgens wordt de gebruiker opgehaald uit het verzoek

        Auth::logout(); //wordt de huidige aanmelding uitgelogd.

        $user->delete(); // Daarna wordt de gebruiker verwijderd.

        $request->session()->invalidate(); //verwijdert alle gegevens uit de huidige sessie. Hierdoor wordt de sessie "uitgelogd" en is de gebruiker niet langer aangemeld.
        $request->session()->regenerateToken(); //genereert een nieuwe unieke sessietoken voor de gebruiker. Dit is bedoeld om de beveiliging van de sessie te verbeteren

        return Redirect::to('/'); //redirect naar de homepagina
    }
}
