<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        
        $resumes = Resume::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $totalResumes = Resume::where('user_id', $user->id)->count();
        
        $monthlyResumes = Resume::where('user_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $latestResume = Resume::where('user_id', $user->id)
            ->latest()
            ->first();

        return view('dashboard', compact(
            'resumes',
            'totalResumes',
            'monthlyResumes',
            'latestResume'
        ));
    }
}