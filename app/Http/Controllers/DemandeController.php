<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DemandeController extends Controller
{
    public function store(Request $request, $offre_id)
    {
        
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after:startDate',
            'cv' => 'required|file|mimes:pdf|max:2048', 
            'internshipdemand' => 'required|file|mimes:pdf|max:2048', 
            'firstName' => 'required',
            'lastName' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'academicLevel' => 'required',
            'establishment' => 'required',
        ]);

        
        $user = Auth::user();

        
        $demande = new Demande();
        $demande->offer_id = $offre_id;
        $demande->user_id = $user->id;
        $demande->startDate = $request->startDate;
        $demande->endDate = $request->endDate;
        $demande->save();

        
        $profile = $user->profile;
        $profile->firstName = $request->firstName;
        $profile->lastName = $request->lastName;
        $profile->phone = $request->phone;
        $profile->email = $request->email;
        $profile->save();

        
        $cv = $request->file('cv');
        $cvUrl = $cv->store('files');
        $cvFile = new File();
        $cvFile->name = $cv->getClientOriginalName();
        $cvFile->url = $cvUrl;
        $cvFile->type = 'cv';
        $demande->files()->save($cvFile);

        $internshipDemand = $request->file('internshipdemand');
        $internshipDemandUrl = $internshipDemand->store('files');
        $internshipDemandFile = new File();
        $internshipDemandFile->name = $internshipDemand->getClientOriginalName();
        $internshipDemandFile->url = $internshipDemandUrl;
        $internshipDemandFile->type = 'internship_demand';
        $demande->files()->save($internshipDemandFile);

        return response()->json(['message' => 'Demande créée avec succès'], 201);
    }
}
