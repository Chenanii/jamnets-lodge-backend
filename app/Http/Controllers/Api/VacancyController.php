<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function index()
    {
        return response()->json(Vacancy::latest()->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'nullable|string',
            'description' => 'required',
            'requirements' => 'nullable|string',
            'deadline' => 'required|date',
            'location' => 'nullable|string',
        ]);

        $vacancy = Vacancy::create(array_merge($validated, [
            'user_id' => 1, // temporary until auth added
        ]));

        return response()->json($vacancy, 201);
    }

    public function show(Vacancy $vacancy)
    {
        return response()->json($vacancy);
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        $vacancy->update($request->all());
        return response()->json($vacancy);
    }

    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();
        return response()->json(['message' => 'Vacancy deleted']);
    }
}
