@extends('layouts.app')

@section('title', ($resume->candidate_name ?? 'Resume Analysis') . ' — ResumeAI')

{{-- @section('header')
    <div class="flex items-center gap-3 sm:gap-4">
        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-600/20 flex-shrink-0">
            <span class="text-lg sm:text-xl font-bold text-white">{{ strtoupper(substr($resume->candidate_name ?? 'U', 0, 1)) }}</span>
        </div>
        <div class="min-w-0">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 truncate">{{ $resume->candidate_name ?? 'Unknown Candidate' }}</h2>
            <p class="text-sm text-gray-500 truncate">{{ $resume->suggested_role ?? 'No role detected' }}</p>
        </div>
    </div>
@endsection --}}

@section('content')
    <div class="max-w-2xl mx-auto space-y-4 sm:space-y-6">

        {{-- Candidate Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <span class="text-xl font-bold text-indigo-700">{{ strtoupper(substr($resume->candidate_name ?? 'U', 0, 1)) }}</span>
                </div>
                <div class="min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 truncate">{{ $resume->candidate_name ?? 'Unknown Candidate' }}</h1>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs sm:text-sm font-medium bg-blue-50 text-blue-700 border border-blue-100 mt-1">
                        {{ $resume->suggested_role ?? 'No role detected' }}
                    </span>
                </div>
            </div>

            {{-- Quick Stats Grid --}}
            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                <div class="bg-gray-50 rounded-xl p-3 sm:p-4 text-center">
                    <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $resume->years_experience ?? '—' }}</p>
                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Years Experience</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3 sm:p-4 text-center">
                    <p class="text-sm sm:text-base font-semibold text-gray-900 truncate">{{ $resume->education ?? 'Not specified' }}</p>
                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Education</p>
                </div>
            </div>
        </div>

        {{-- Skills --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6">
            <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-3 sm:mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                Skills
            </h3>
            @if(is_array($resume->skills) && count($resume->skills) > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($resume->skills as $skill)
                        <span class="inline-flex items-center px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-lg text-xs sm:text-sm font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                            {{ $skill }}
                        </span>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-400">No skills extracted</p>
            @endif
        </div>

        {{-- Education Detail --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sm:p-6">
            <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-2 flex items-center gap-2">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
                Education
            </h3>
            <p class="text-sm sm:text-base text-gray-700">{{ $resume->education ?? 'Not specified' }}</p>
        </div>

        {{-- File Info (Compact) --}}
        <div class="bg-gray-50 rounded-xl p-4 sm:p-5 border border-gray-100">
            <div class="flex items-center justify-between">
                <div class="min-w-0">
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">File</p>
                    <p class="text-sm text-gray-700 truncate">{{ $resume->file_name }}</p>
                </div>
                <p class="text-xs text-gray-400 flex-shrink-0 ml-3">{{ $resume->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3 pt-2">
            <a href="{{ route('resumes.create') }}" class="flex-1 flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-3 rounded-xl font-medium transition shadow-md shadow-indigo-600/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Analyze Another
            </a>
            <a href="{{ route('dashboard') }}" class="flex-1 flex items-center justify-center gap-2 text-gray-600 hover:text-gray-900 px-4 py-3 rounded-xl font-medium border border-gray-200 hover:border-gray-300 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Dashboard
            </a>
        </div>

    </div>
@endsection