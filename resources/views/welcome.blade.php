<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI Resume Analyzer — Extract Structured Data from Resumes Instantly</title>
    <meta name="description" content="Upload resumes and let AI instantly extract skills, experience, education, and suggested job roles.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-grid {
            background-image: radial-gradient(circle at 1px 1px, rgba(99, 102, 241, 0.12) 1px, transparent 0);
            background-size: 28px 28px;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-white">

    {{-- Simple Top Bar --}}
    <header class="fixed w-full top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                {{-- Logo --}}
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="font-bold text-lg tracking-tight text-gray-900">ResumeAI</span>
                </div>

                {{-- Auth Links --}}
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex text-sm font-medium text-gray-600 hover:text-gray-900 transition">Log in</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition shadow-sm shadow-indigo-600/20">
                        Get Started Free
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 hero-grid overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="max-w-3xl mx-auto text-center">
                
                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 bg-indigo-50 border border-indigo-100 rounded-full px-4 py-1.5 mb-8">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
                    </span>
                    <span class="text-sm font-semibold text-indigo-700">AI-Powered Resume Parsing</span>
                </div>

                {{-- Headline --}}
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.1] mb-6">
                    Upload Resumes &<br>
                    <span class="gradient-text">Extract Data Instantly</span>
                </h1>

                {{-- Subheadline --}}
                <p class="text-lg sm:text-xl text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Stop manually copying resume data. Our AI reads PDF and DOCX files and instantly extracts structured candidate information.
                </p>

                {{-- Extracted Data Preview --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-xl shadow-gray-200/50 p-6 sm:p-8 mb-10 max-w-lg mx-auto text-left animate-float">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-2 h-2 rounded-full bg-red-400"></div>
                        <div class="w-2 h-2 rounded-full bg-amber-400"></div>
                        <div class="w-2 h-2 rounded-full bg-green-400"></div>
                        <span class="text-xs text-gray-400 ml-2 font-mono">AI Analysis Result</span>
                    </div>
                    
                    <div class="space-y-3 font-mono text-sm">
                        <div class="flex gap-3">
                            <span class="text-purple-600 font-semibold w-28 flex-shrink-0">full_name</span>
                            <span class="text-gray-700">"Sarah Chen"</span>
                        </div>
                        <div class="flex gap-3">
                            <span class="text-purple-600 font-semibold w-28 flex-shrink-0">skills</span>
                            <span class="text-gray-700">["Laravel", "React", "MySQL", "AWS"]</span>
                        </div>
                        <div class="flex gap-3">
                            <span class="text-purple-600 font-semibold w-28 flex-shrink-0">experience</span>
                            <span class="text-gray-700">5</span>
                        </div>
                        <div class="flex gap-3">
                            <span class="text-purple-600 font-semibold w-28 flex-shrink-0">education</span>
                            <span class="text-gray-700">"BS Computer Science"</span>
                        </div>
                        <div class="flex gap-3">
                            <span class="text-purple-600 font-semibold w-28 flex-shrink-0">suggested_role</span>
                            <span class="text-emerald-600">"Senior Full Stack Developer"</span>
                        </div>
                    </div>
                </div>

                {{-- CTA Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('register') }}" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-xl font-semibold text-lg transition shadow-xl shadow-indigo-600/25 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Start Analyzing Free
                    </a>
                    <a href="#how-it-works" class="w-full sm:w-auto text-gray-700 hover:text-gray-900 px-8 py-4 rounded-xl font-semibold text-lg border border-gray-200 hover:border-gray-300 transition flex items-center justify-center gap-2">
                        How It Works
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Decorative blobs --}}
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-100 rounded-full mix-blend-multiply filter blur-3xl opacity-40 pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-100 rounded-full mix-blend-multiply filter blur-3xl opacity-40 pointer-events-none"></div>
    </section>

    {{-- How It Works --}}
    <section id="how-it-works" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">How It Works</h2>
                <p class="text-lg text-gray-600">Three simple steps from upload to structured data.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
                {{-- Step 1 --}}
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm h-full">
                        <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-indigo-600/20">
                            <span class="text-xl font-bold text-white">1</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Upload Resume</h3>
                        <p class="text-gray-600 leading-relaxed">Drop your PDF or DOCX file into the upload area. We handle both formats natively — no conversion needed.</p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm h-full">
                        <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-indigo-600/20">
                            <span class="text-xl font-bold text-white">2</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">AI Analyzes</h3>
                        <p class="text-gray-600 leading-relaxed">Our AI reads the entire document and intelligently identifies names, skills, experience, education, and optimal job roles.</p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm h-full">
                        <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-indigo-600/20">
                            <span class="text-xl font-bold text-white">3</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Get Structured Data</h3>
                        <p class="text-gray-600 leading-relaxed">View clean, structured candidate profiles in your dashboard. Export-ready JSON with all key fields extracted.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">What Gets Extracted</h2>
                <p class="text-lg text-gray-600">Every resume is analyzed for these key data points.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Feature: Skills --}}
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 hover:border-indigo-200 hover:shadow-md transition group">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Skills</h3>
                    <p class="text-sm text-gray-600">Programming languages, frameworks, tools, and soft skills automatically identified.</p>
                </div>

                {{-- Feature: Experience --}}
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 hover:border-indigo-200 hover:shadow-md transition group">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Experience</h3>
                    <p class="text-sm text-gray-600">Total years of professional experience calculated from work history.</p>
                </div>

                {{-- Feature: Education --}}
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 hover:border-indigo-200 hover:shadow-md transition group">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Education</h3>
                    <p class="text-sm text-gray-600">Degrees, institutions, and graduation details extracted cleanly.</p>
                </div>

                {{-- Feature: Suggested Role --}}
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 hover:border-indigo-200 hover:shadow-md transition group">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Suggested Role</h3>
                    <p class="text-sm text-gray-600">AI recommends the best-fitting job title based on skills and experience.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 bg-indigo-900 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">Ready to Parse Your First Resume?</h2>
            <p class="text-indigo-200 text-lg sm:text-xl mb-10 max-w-2xl mx-auto">
                Join and start transforming unstructured resumes into structured candidate profiles in seconds. No credit card required.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 bg-white text-indigo-900 px-8 py-4 rounded-xl font-bold text-lg hover:bg-indigo-50 transition shadow-xl w-full sm:w-auto">
                    Create Free Account
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 bg-indigo-800 text-indigo-100 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-indigo-700 transition border border-indigo-700 w-full sm:w-auto">
                    Already have an account? Log in
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 bg-indigo-600 rounded flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="font-bold text-white">ResumeAI</span>
                </div>
                <p class="text-sm">All Rights Reserved 2026</p>
            </div>
        </div>
    </footer>

</body>
</html>