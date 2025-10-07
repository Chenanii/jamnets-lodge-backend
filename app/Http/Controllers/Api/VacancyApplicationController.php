<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VacancyApplication;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\VacancyApplicationController;
use Illuminate\Support\Facades\Validator;


class VacancyApplicationController extends Controller
{   
    public function store(Request $request)
    {   
        // Validate request
        $request->validate([
            'vacancy_id' => 'required|exists:vacancies,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'cover_letter' => 'required|string',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        
        $cvPath = $request->file('cv')->store('cvs', 'public');

        $application = VacancyApplication::create([
            'vacancy_id' => $request->vacancy_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'cover_letter' => $request->cover_letter,
            'cv' => $cvPath,
            'user_id' => optional($request->user())->id, 

        ]);

        return response()->json([
            'message' => 'Application submitted successfully!',
            'application' => $application,
        ], 201);
    }

    public function index()
    {
        $applications = VacancyApplication::with('vacancy')
            ->latest()
            ->get();

        return response()->json($applications);
    }

}
