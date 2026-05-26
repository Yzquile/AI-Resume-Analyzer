@extends('layouts.app')

@section('title', 'Upload Resume — ResumeAI')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Upload Resume</h2>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <div class="mb-8">
                <p class="text-gray-500">Upload a PDF or DOCX file to analyze with AI.</p>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <p class="text-sm text-emerald-800">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                    <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('resumes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="upload-form">
                @csrf
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Resume File</label>
                    
                    <div 
                        id="drop-zone"
                        class="relative border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-indigo-500 hover:bg-indigo-50/50 transition cursor-pointer"
                        onclick="document.getElementById('file-upload').click()"
                    >
                        <input 
                            id="file-upload" 
                            name="resume" 
                            type="file" 
                            class="hidden" 
                            accept=".pdf,.docx"
                            onchange="handleFileSelect(this)"
                        >
                        
                        <div id="upload-prompt">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium text-indigo-600">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs text-gray-400 mt-1">PDF or DOCX up to 10MB</p>
                        </div>

                        <div id="file-selected" class="hidden">
                            <div class="flex items-center justify-center gap-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p id="filename" class="text-sm font-medium text-gray-900"></p>
                                    <p id="filesize" class="text-xs text-gray-500"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @error('resume')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4 pt-2">
                    <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition shadow-md shadow-indigo-600/20 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Analyze with AI
                    </button>
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-xl font-medium text-gray-600 hover:text-gray-900 border border-gray-200 hover:border-gray-300 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('file-upload');

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-indigo-500', 'bg-indigo-50');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
            const files = e.dataTransfer.files;
            if (files.length) {
                fileInput.files = files;
                handleFileSelect(fileInput);
            }
        });

        function handleFileSelect(input) {
            const file = input.files[0];
            if (!file) return;

            document.getElementById('upload-prompt').classList.add('hidden');
            document.getElementById('file-selected').classList.remove('hidden');

            document.getElementById('filename').textContent = file.name;
            
            const size = file.size;
            if (size < 1024) document.getElementById('filesize').textContent = size + ' B';
            else if (size < 1024 * 1024) document.getElementById('filesize').textContent = (size / 1024).toFixed(1) + ' KB';
            else document.getElementById('filesize').textContent = (size / (1024 * 1024)).toFixed(1) + ' MB';

            dropZone.classList.remove('border-dashed', 'border-gray-300');
            dropZone.classList.add('border-solid', 'border-indigo-200', 'bg-indigo-50/30');
        }
    </script>
@endsection