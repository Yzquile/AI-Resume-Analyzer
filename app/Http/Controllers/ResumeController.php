<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use App\Services\AIAnalyzerService;
use App\Services\ResumeParserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ResumeController extends Controller
{
    public function __construct(
        private ResumeParserService $parser,
        private AIAnalyzerService $analyzer,
    ) {}

    public function create(): View
    {
        return view('resumes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resume' => ['required', 'file', 'mimes:pdf,docx', 'max:10240'],
        ]);

        $file = $request->file('resume');
        $path = $file->store('resumes', 'local');
        $fullPath = Storage::disk('local')->path($path);

        try {
            // Extract text
            $rawText = $this->parser->extractText($fullPath);

            if (empty(trim($rawText))) {
                Storage::delete($path);
                return back()->withErrors(['resume' => 'Could not extract text from this file. Try another.']);
            }

            // AI Analysis
            $analysis = $this->analyzer->analyzeResume($rawText);

            // Save to database
            $resume = Resume::create([
                'user_id' => Auth::id(),
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'candidate_name' => $analysis['full_name'] ?? null,
                'skills' => $analysis['skills'] ?? [],
                'years_experience' => $analysis['years_experience'] ?? null,
                'education' => $analysis['education'] ?? null,
                'suggested_role' => $analysis['suggested_role'] ?? null,
                'raw_text' => $rawText,
                'ai_response' => $analysis,
            ]);

            return redirect()
                ->route('resumes.show', $resume)
                ->with('success', 'Resume analyzed successfully!');

        } catch (\Exception $e) {
            Storage::delete($path);
            return back()->withErrors(['resume' => 'Analysis failed: ' . $e->getMessage()]);
        }
    }

    public function show(Resume $resume)
    {
        // Security: ensure user owns this resume
        if ($resume->user_id !== Auth::id()) {
            abort(403);
        }

        return view('resumes.show', compact('resume'));
    }
}