<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VacancyApplication;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Mail\ApplicationAcceptedMail;
use Illuminate\Support\Facades\Mail;



class VacancyApplicationController extends Controller
{
    // Store a new application
    public function store(Request $request)
    {
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

    // List all applications
    public function index()
    {
        $applications = VacancyApplication::with('vacancy')
            ->latest()
            ->get();

        return response()->json($applications);
    }

    // List applications for a specific vacancy
    public function showByVacancy($vacancyId)
    {
        $applications = VacancyApplication::where('vacancy_id', $vacancyId)
            ->with('vacancy')
            ->latest()
            ->get();

        if ($applications->isEmpty()) {
            return response()->json([
                'message' => 'No applications found for this vacancy.'
            ], 404);
        }

        return response()->json($applications);
    }

    // Download CV
    public function downloadCv($applicationId)
    {
        $application = VacancyApplication::findOrFail($applicationId);

        if (!Storage::disk('public')->exists($application->cv)) {
            return response()->json([
                'message' => 'CV file not found.'
            ], 404);
        }

        return Storage::disk('public')->download($application->cv);
    }

    public function viewCv($applicationId)
    {
        $application = VacancyApplication::findOrFail($applicationId);

        if (!Storage::disk('public')->exists($application->cv)) {
            return response()->json([
                'message' => 'CV file not found.'
            ], 404);
        }

        $path = Storage::disk('public')->path($application->cv);
        $mimeType = Storage::disk('public')->mimeType($application->cv);

        return response()->file($path, [
            'Content-Type' => $mimeType,
        ]);
    }

    // Evaluate an application (admin)

public function evaluate(Request $request, $applicationId)
{
    $application = VacancyApplication::findOrFail($applicationId);

    $request->validate([
        'status' => 'required|in:pending,shortlisted,accepted,rejected',
        'comments' => 'required|string|max:1000',
        'score' => 'nullable|numeric|min:0|max:5',
    ]);

    $application->update([
        'status' => $request->status,
        'comments' => $request->comments,
        'score' => $request->score,
    ]);

    // 📨 Send email based on status
    switch ($request->status) {
        case 'accepted':
            Mail::to($application->email)->send(new ApplicationAcceptedMail($application));
            break;
        case 'shortlisted':
            Mail::to($application->email)->send(new ApplicationShortlistedMail($application));
            break;
        case 'rejected':
            Mail::to($application->email)->send(new ApplicationRejectedMail($application));
            break;
    }

    return response()->json([
        'message' => 'Application evaluated successfully and notification sent.',
        'application' => $application,
    ]);
}

    
    // Show a single application
    public function show($id)
    {
        $application = VacancyApplication::with('vacancy')->find($id);

        if (!$application) {
            return response()->json(['message' => 'Application not found'], 404);
        }

        return response()->json($application);
    }

}
