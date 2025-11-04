@extends('layouts.app')

@section('content')
    <style>
        :root {
            /* colors you provided */
            --blue: #2f307f;
            /* Blue */
            --red: #dd3226;
            /* Red */
            --yellow: #feec57;
            /* Yellow */

            --primary: var(--blue);
            --secondary: var(--red);
            --accent: var(--yellow);

            --light: #f8f9fa;
            --dark: #212529;
            --success: #4bb543;
            --warning: #ff9505;
            --danger: #e63946;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --hover-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .page-header .center-logo {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.08);
        }

        .search-container {
            position: relative;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 50px;
            overflow: hidden;
        }

        .search-container input {
            border: none;
            padding-left: 20px;
            height: 50px;
        }

        .search-container input:focus {
            box-shadow: none;
        }

        .search-container button {
            position: absolute;
            right: 5px;
            top: 5px;
            height: 40px;
            width: 40px;
            border-radius: 50%;
            background: var(--primary);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        /* Enhanced Folder Styles */
        .folder-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .folder-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .folder-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }

        .folder-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .folder-icon {
            font-size: 1.5rem;
            margin-right: 10px;
        }

        .folder-title {
            font-weight: 600;
            font-size: 1.1rem;
            flex-grow: 1;
            margin: 0;
        }

        .folder-actions {
            display: flex;
            gap: 8px;
        }

        .folder-body {
            padding: 20px;
            min-height: 150px;
            display: flex;
            flex-direction: column;
        }

        .empty-folder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
            color: #6c757d;
        }

        .empty-folder i {
            font-size: 2.5rem;
            margin-bottom: 10px;
            opacity: 0.5;
        }

        .notes-count {
            background: rgba(47, 48, 127, 0.08);
            color: var(--primary);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 10px;
            display: inline-block;
        }

        /* Enhanced Note Styles */
        .notes-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .note-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            padding: 18px;
            transition: all 0.3s ease;
            border-left: 4px solid var(--primary);
            position: relative;
            overflow: hidden;
        }

        .note-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--hover-shadow);
        }

        .note-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .note-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--dark);
            margin: 0;
            line-height: 1.3;
        }

        .note-category {
            background: rgba(76, 201, 240, 0.15);
            color: var(--accent);
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .note-details {
            margin-bottom: 15px;
        }

        .note-detail-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .note-detail-item i {
            width: 16px;
            margin-right: 8px;
            color: var(--primary);
        }

        .note-description {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.4;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .note-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding-top: 12px;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
        }

        .note-uploader {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .note-actions {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 0.8rem;
        }

        #noResultsMessage {
            display: none;
        }

        @media (max-width: 768px) {
            .folder-container {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }

            .notes-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .welcome-title {
                font-size: 1.4rem;
            }

            .folder-container {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="container main-container mt-4">
        <div class="page-header">
            <h3 class="welcome-title m-0">Welcome to Note-Nest 🎓</h3>
            <div class="center-logo">
                <img src="{{ asset('images/GMMS_LOGO.png') }}" alt="GIATMARA Logo" class="header-logo"
                    style="height: 120px;">
            </div>
            <div>
                @can('access-teacher-features')
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createFolderModal">
                        <i class="fas fa-folder-plus me-2"></i>Create Folder
                    </button>

                @endcan
            </div>
        </div>

        <!-- Search -->
        <div class="search-container mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Search notes by title...">
            <button class="btn btn-primary" id="searchBtn"><i class="fas fa-search"></i></button>
        </div>
        <p id="noResultsMessage" class="text-muted ms-2">No notes found.</p>

        <!-- Folders Grid -->
        @if($folders->count() > 0)
            <div class="folder-container">
                @foreach($folders as $folder)
                    <div class="folder-card" id="folderItem-{{ $folder->id }}">
                        <div class="folder-header">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-folder folder-icon"></i>
                                <h5 class="folder-title">{{ $folder->name }}</h5>
                            </div>
                            <div class="folder-actions">
                                @if(auth()->user()->role === 'teacher')
                                    <button class="btn btn-sm btn-light add-note-btn" data-folder-id="{{ $folder->id }}"
                                        title="Upload Note">
                                        <i class="fas fa-upload"></i>
                                    </button>
                                    <form method="POST" action="{{ route('folders.destroy', $folder) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light"
                                            onclick="return confirm('Are you sure you want to delete this folder and all its notes?')"
                                            title="Delete Folder">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <div class="folder-body">
                            @if($notes->where('folder_id', $folder->id)->count() === 0)
                                <div class="empty-folder">
                                    <i class="fas fa-file-alt"></i>
                                    <p>No notes yet</p>
                                    @if(auth()->user()->role === 'teacher')
                                        <button class="btn btn-sm btn-outline-primary add-note-btn" data-folder-id="{{ $folder->id }}">
                                            <i class="fas fa-plus me-1"></i>Add Note
                                        </button>
                                    @endif
                                </div>
                            @else
                                <div class="notes-container" id="notes-{{ $folder->id }}">
                                    @foreach($notes->where('folder_id', $folder->id) as $note)
                                        <div class="note-card" id="note-{{ $note->id }}" data-title="{{ strtolower($note->title) }}">
                                            <div class="note-header">
                                                <div class="d-flex align-items-center">
                                                    @if(Str::endsWith($note->file_name, '.pdf'))
                                                        <i class="fas fa-file-pdf text-danger me-2"></i>
                                                    @elseif(Str::endsWith($note->file_name, ['.doc', '.docx']))
                                                        <i class="fas fa-file-word text-primary me-2"></i>
                                                    @elseif(Str::endsWith($note->file_name, ['.ppt', '.pptx']))
                                                        <i class="fas fa-file-powerpoint text-warning me-2"></i>
                                                    @elseif(Str::endsWith($note->file_name, ['.png', '.jpg', '.jpeg', '.gif']))
                                                        <i class="fas fa-image text-info me-2"></i>
                                                    @elseif(Str::endsWith($note->file_name, '.txt'))
                                                        <i class="fas fa-file-alt text-secondary me-2"></i>
                                                    @else
                                                        <i class="fas fa-file me-2"></i>
                                                    @endif
                                                    <h6 class="note-title">{{ $note->title }}</h6>
                                                </div>
                                                <span class="note-category">{{ $note->category }}</span>
                                            </div>
                                            <div class="note-details">
                                                <div class="note-detail-item">
                                                    <i class="fas fa-book"></i>
                                                    <span>{{ $note->course_code }}</span>
                                                </div>
                                                <div class="note-detail-item">
                                                    <i class="fas fa-user"></i>
                                                    <span>{{ $note->teacher->name }} (Teacher)</span>
                                                </div>
                                                <div class="note-detail-item">
                                                    <i class="fas fa-calendar"></i>
                                                    <span>{{ $note->created_at->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                            <div class="note-description">{{ $note->description }}</div>
                                            <div class="note-footer">
                                                <div class="note-actions">
                                                    <!-- Preview Button (NEW) -->
                                                    <button type="button" class="btn btn-sm btn-outline-info"
                                                        onclick="previewNote('{{ asset('storage/' . $note->file_path) }}', '{{ $note->file_type }}')">
                                                        <i class="fas fa-eye me-1"></i>Preview
                                                    </button>

                                                    <!-- Download Button -->
                                                    <a href="{{ route('notes.download', $note) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-download me-1"></i>Download
                                                    </a>
                                                    <!-- Assignment Button (for students) -->
                                                    @if(auth()->user()->role === 'student')
                                                        <a href="{{ route('assignments.create', $note) }}"
                                                            class="btn btn-sm btn-outline-success">
                                                            <i class="fas fa-file-upload me-1"></i>Submit Assignment
                                                        </a>
                                                    @endif
                                                    <!-- Delete Button (for teachers) -->
                                                    @if(auth()->user()->role === 'teacher')
                                                        <form method="POST" action="{{ route('notes.destroy', $note) }}"
                                                            style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Are you sure you want to delete this note?')">
                                                                <i class="fas fa-trash me-1"></i>Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-auto pt-2">
                                    <span class="notes-count">{{ $notes->where('folder_id', $folder->id)->count() }}
                                        {{ $notes->where('folder_id', $folder->id)->count() === 1 ? 'note' : 'notes' }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else


            <!-- Empty state -->
            <div class="col-12 text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No folders yet</h4>
                    <p class="text-muted">Create your first folder to start organizing notes</p>
                    @if(auth()->user()->role === 'teacher')
                        <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#createFolderModal">
                            <i class="fas fa-folder-plus me-2"></i>Create Folder
                        </button>
                    @endif
                </div>
            </div>
        @endif
        <!-- Create Folder Modal -->
        @if(auth()->user()->role === 'teacher')
            <div class="modal fade" id="createFolderModal" tabindex="-1">
                <form method="POST" action="{{ route('folders.store') }}">
                    @csrf
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">New Subject Folder</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input class="form-control mb-2" name="name" placeholder="Subject name" required>
                                <input class="form-control" name="code" placeholder="Code e.g. DAP1002" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Create</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        <!-- Upload Note Modal (Teacher Only) -->
        @if(auth()->user()->role === 'teacher')
            <div class="modal fade" id="uploadNoteModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('notes.store') }}" id="uploadNoteForm"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="folder_id" id="currentFolderId" value="">
                            <div class="modal-header">
                                <h5 class="modal-title">Upload Note</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Note Title</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Course Code</label>
                                    <input type="text" name="course_code" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Category</label>
                                    <select name="category" class="form-select" required>
                                        <option value="">Select Category</option>
                                        <option value="Lecture Notes">Lecture Notes</option>
                                        <option value="Exam Preparation">Exam Preparation</option>
                                        <option value="Assignment">Assignment</option>
                                        <option value="Tutorial">Tutorial</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description</label>
                                    <textarea name="description" class="form-control" rows="2"
                                        placeholder="Add a brief description..."></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Upload File</label>
                                    <input type="file" name="file" class="form-control"
                                        accept=".pdf,.doc,.docx,.ppt,.pptx,.png,.jpg,.jpeg,.gif,.zip,.rar,.txt" required>
                                    <div class="form-text">Supported formats: PDF, DOC/DOCX, PPT/PPTX, PNG, JPG, ZIP, RAR, TXT
                                        (Max 10MB)</div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-paper-plane me-2"></i>Upload
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!-- Preview Modal -->
        <div class="modal fade" id="previewModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Preview Note</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="previewContent">
                        <!-- Preview content will be loaded here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

@endsection

    @push('scripts')
        <script>
            function openUploadModal(folderId) {
                console.log('Modal opened for folder:', folderId);
                document.getElementById('currentFolderId').value = folderId;
                var myModal = new bootstrap.Modal(document.getElementById('uploadNoteModal'), {
                    keyboard: false
                });
                myModal.show();
            }

            function openUploadModal(folderId) {
                document.getElementById('currentFolderId').value = folderId;
                var modal = new bootstrap.Modal(document.getElementById('uploadNoteModal'));
                modal.show();
            }

            // Add this event listener to handle all "Add Note" buttons
            document.addEventListener('DOMContentLoaded', function () {
                // Handle Add Note button clicks using event delegation
                document.addEventListener('click', function (e) {
                    if (e.target.classList.contains('add-note-btn')) {
                        const folderId = e.target.getAttribute('data-folder-id');
                        console.log('Opening modal for folder:', folderId);

                        document.getElementById('currentFolderId').value = folderId;
                        var modal = new bootstrap.Modal(document.getElementById('uploadNoteModal'));
                        modal.show();
                    }
                });
            });

            /* ======= Search ======= */
            document.getElementById('searchInput').addEventListener('input', function () {
                const q = this.value.trim().toLowerCase();
                const folders = document.querySelectorAll('.folder-card');
                let anyMatch = false;

                folders.forEach(folder => {
                    const notes = folder.querySelectorAll('.note-card');
                    let folderHasMatch = false;

                    notes.forEach(note => {
                        const title = note.dataset.title || '';
                        if (!q || title.includes(q)) {
                            note.style.display = '';
                            folderHasMatch = true;
                        } else {
                            note.style.display = 'none';
                        }
                    });

                    folder.style.display = folderHasMatch || !q ? '' : 'none';
                    if (folderHasMatch) anyMatch = true;
                });

                document.getElementById('noResultsMessage').style.display = (!anyMatch && q) ? 'block' : 'none';
            });

            // Preview Note Function
            function previewNote(fileUrl, fileType) {
                const previewContent = document.getElementById('previewContent');
                const modal = new bootstrap.Modal(document.getElementById('previewModal'));

                // Show loading state
                previewContent.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;

                // Show modal
                modal.show();

                try {
                    if (!fileUrl || !fileType) {
                        throw new Error('File URL or type is missing');
                    }

                    // Handle different file types
                    if (fileType.includes('pdf')) {
                        previewContent.innerHTML = `<iframe src="${fileUrl}" width="100%" height="500px" style="border: none;"></iframe>`;
                    }
                    else if (fileType.includes('image')) {
                        previewContent.innerHTML = `<img src="${fileUrl}" class="img-fluid" alt="Note Preview">`;
                    }
                    else if (fileType.includes('text') || fileType.includes('plain')) {
                        fetch(fileUrl)
                            .then(response => response.text())
                            .then(text => {
                                previewContent.innerHTML = `<pre style="white-space: pre-wrap; font-family: monospace;">${text}</pre>`;
                            })
                            .catch(error => {
                                previewContent.innerHTML = '<div class="alert alert-danger">Unable to load text file.</div>';
                            });
                    }
                    else {
                        previewContent.innerHTML = `
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Preview Not Available</h6>
                            <p>This file type (${fileType}) cannot be previewed directly.</p>
                            <a href="${fileUrl}" class="btn btn-primary" download>
                                <i class="fas fa-download me-1"></i>Download to View
                            </a>
                        </div>
                    `;
                    }
                } catch (error) {
                    console.error('Preview Error:', error);
                    previewContent.innerHTML = `
                    <div class="alert alert-danger">
                        <h6><i class="fas fa-exclamation-triangle"></i> Preview Error</h6>
                        <p>There was an error previewing this file. Please try downloading it instead.</p>
                        <a href="${fileUrl}" class="btn btn-primary" download>
                            <i class="fas fa-download me-1"></i>Download
                        </a>
                    </div>
                `;
                }
            }
        </script>
    @endpush
