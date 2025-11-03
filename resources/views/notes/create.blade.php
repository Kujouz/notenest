@extends('layouts.app')

@section('title', 'Upload Note')

@push('styles')
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #6f42c1;
            --accent-color: #36b9cc;
            --light-bg: #f8f9fc;
        }

        .note-upload-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, .15);
            padding: 2rem;
            margin-top: 2rem;
        }

        .page-header {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: .5rem;
            margin-bottom: 1.5rem;
        }

        .upload-area {
            border: 2px dashed #ccc;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            background: var(--light-bg);
            cursor: pointer;
            transition: .3s;
        }

        .upload-area:hover {
            border-color: var(--primary-color);
            background: #eef1ff;
        }

        .upload-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .btn-upload {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            padding: .75rem 2rem;
            font-weight: 600;
            border-radius: 8px;
            color: #fff;
        }

        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, .15);
        }

        .file-info {
            background: #e9f7fe;
            border-left: 4px solid var(--accent-color);
            padding: 1rem;
            border-radius: 4px;
            margin-top: 1rem;
            display: none;
        }

        .character-count {
            font-size: .85rem;
            text-align: right;
            color: #6c757d;
        }
    </style>
@endpush

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="note-upload-container">
                    <h2 class="page-header text-center">
                        <i class="fas fa-file-upload me-2"></i>Upload a New Note
                    </h2>

                    {{-- Laravel form: POST + file --}}
                    <form method="POST" action="{{ route('notes.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- 1. Title --}}
                        <div class="mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
                        </div>

                        {{-- 2. Course Code --}}
                        <div class="mb-3">
                            <label class="form-label">Course Code <span class="text-danger">*</span></label>
                            <input type="text" name="course_code" value="{{ old('course_code') }}" class="form-control"
                                required>
                        </div>

                        {{-- 3. Description --}}
                        <div class="mb-3">
                            <label class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" rows="3"
                                required>{{ old('description') }}</textarea>
                        </div>

                        {{-- 4. Category --}}
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select">
                                <option value="">Select a category</option>
                                <option value="Lecture Notes" {{ old('category') == 'Lecture Notes' ? 'selected' : '' }}>Lecture
                                    Notes</option>
                                <option value="Study Guide" {{ old('category') == 'Study Guide' ? 'selected' : '' }}>Study Guide
                                </option>
                                <option value="Assignment Solution" {{ old('category') == 'Assignment Solution' ? 'selected' : '' }}>Assignment Solution</option>
                                <option value="Exam Preparation" {{ old('category') == 'Exam Preparation' ? 'selected' : '' }}>Exam Preparation</option>
                                <option value="Summary" {{ old('category') == 'Summary' ? 'selected' : '' }}>Summary</option>
                            </select>
                        </div>

                        <!-- Folder selection -->
                        <div class="mb-3">
                            <label class="form-label">Subject Folder <span class="text-danger">*</span></label>
                            <select name="folder_id" class="form-select" required>
                                @foreach($folders as $f)
                                    <option value="{{ $f->id }}" @selected(old('folder_id') == $f->id)>
                                        {{ $f->name }} ({{ $f->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- File upload -->
                        <div class="mb-3">
                            <label class="form-label">Upload File <span class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control" required accept=".pdf,.doc,.docx,.ppt,.pptx,.txt">
                        </div>

                        {{-- 7. Submit --}}
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Upload Note
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const textarea = document.getElementById('description');
        const charCount = document.getElementById('charCount');
        textarea.addEventListener('input', () => charCount.textContent = textarea.value.length);

        const fileInput = document.getElementById('fileInput');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length) displayFileInfo(fileInput.files[0]);
        });

        function displayFileInfo(file) {
            fileName.textContent = file.name;
            fileSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
            fileInfo.style.display = 'block';
        }

        /* ---- drag & drop ---- */
        const dropZone = document.getElementById('dropZone');
        dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('bg-light'); });
        dropZone.addEventListener('dragleave', () => dropZone.classList.remove('bg-light'));
        dropZone.addEventListener('drop', e => {
            e.preventDefault();
            dropZone.classList.remove('bg-light');
            const files = e.dataTransfer.files;
            if (files.length) {
                fileInput.files = files;
                displayFileInfo(files[0]);
            }
        });
    </script>
@endpush
