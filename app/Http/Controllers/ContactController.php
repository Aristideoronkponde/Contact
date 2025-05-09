<?php

namespace App\Http\Controllers;

use App\Events\ContactDeletedEvent;
use App\Events\ContactEvent;
use App\Events\ContactUpdatedEvent;
use App\Models\Contact;
use App\Notifications\ContactCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{


    
    
    public function getCountries()
    {
        return Cache::remember('countries', now()->addHours(24), function () {
            $response = Http::get('https://restcountries.com/v3.1/all');
            if ($response->successful()) {
                $countries = $response->json();
                return collect($countries)->map(function ($country) {
                    return [
                        'name' => $country['name']['common'],
                        'flag' => $country['flags']['png'],
                    ];
                })->sortBy('name')->values()->all();
            }
           
        });
    }

    // Afficher tous les contacts
    public function index()
    {
        // recuperer en fonction de la creation le plus ressent reste devant 
        $contacts = Contact::orderBy('created_at', 'desc')->get();        return Inertia::render('Dashboard', [
            'contacts' => $contacts,
        ]);
    }

   

    public function create()
{
    $countries = $this->getCountries();
    return Inertia::render('Contacts/Create', [
        'countries' => $countries,
    ]);
}

    // Enregistrer un nouveau contact

    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:contacts,email',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $country = $request->input('country');
        $response = Http::get("https://restcountries.com/v3.1/name/{$country}?fullText=true");

        if ($response->successful()) {
            $countryData = $response->json()[0];
            $validated['country_flag'] = $countryData['flags']['png'];
        } else {
            $validated['country_flag'] = null;
        }

        $contact = Contact::create($validated);

        event(new ContactEvent($contact));

        return redirect()->route('dashboard')->with('success', 'Contact créé avec succès !');
    } catch (\Throwable $th) {
        return redirect()->route('dashboard')->with('error', 'Erreur lors de la création du contact.');
    }
}
    // Afficher un contact spécifique
    public function show(Contact $contact)
    {
        return Inertia::render('Contacts/Show', [
            'contact' => $contact,
        ]);
    }

    // Afficher le formulaire d'édition
    public function edit(Contact $contact)
    {
        $countries = $this->getCountries();
        return Inertia::render('Contacts/Edit', [
            'countries' => $countries,
            'contact' => $contact,
        ]);
    }

    // Mettre à jour un contact
    public function update(Request $request, Contact $contact)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:contacts,email,' . $contact->id,
                'phone' => 'nullable|string|max:20',
                'company' => 'nullable|string|max:255',
                'country' => 'required|string|max:255',
            ]);

            $country = $request->input('country');
            $response = Http::get("https://restcountries.com/v3.1/name/{$country}?fullText=true");

            if ($response->successful()) {
                $countryData = $response->json()[0];
                $validated['country_flag'] = $countryData['flags']['png'];
            } else {
                $validated['country_flag'] = null;
            }

            $contact->update($validated);

            event(new ContactUpdatedEvent($contact));

            return redirect()->route('dashboard');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => $th->getMessage()]);
        }
    }

    // Supprimer un contact
    public function destroy(Contact $contact)
    {
        event(new ContactDeletedEvent($contact));
        $contact->delete();
    
        return redirect()->route('dashboard');
    }
}
