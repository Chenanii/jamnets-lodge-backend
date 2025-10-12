<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vacancy;
use App\Models\VacancyApplication;

class DashboardController extends Controller
{
    public function getStats()
    {
        $totalApplications = VacancyApplication::count();
        $activeVacancies = Vacancy::where('is_active', true)->count();
        $pendingReviews = VacancyApplication::where('status', 'pending')->count();
        $totalUsers = User::count();

        return response()->json([
            'totalApplications' => $totalApplications,
            'activeVacancies' => $activeVacancies,
            'pendingReviews' => $pendingReviews,
            'totalUsers' => $totalUsers,
        ]);
    }
}
