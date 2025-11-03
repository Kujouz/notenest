@extends('layouts.app')

@section('content')
<style>
:root {
  --blue:#2f307f;
  --red:#dd3226;
  --yellow:#feec57;
}
body {
  font-family:'Segoe UI',sans-serif;
  background:#f5f7fb;
  color:#212529;
}
.settings-card {
  max-width:700px;
  margin:80px auto;
  background:#fff;
  border:none;
  border-radius:15px;
  box-shadow:0 8px 32px rgba(0,0,0,0.08);
  overflow:hidden;
}
.settings-header {
  background:linear-gradient(135deg,var(--blue),var(--red));
  color:#fff;
  text-align:center;
  padding:40px 20px 30px;
  border-top-left-radius:15px;
  border-top-right-radius:15px;
  position:relative;
}
.settings-header img {
  width:120px;
  height:120px;
  border-radius:50%;
  border:4px solid #fff;
  object-fit:cover;
  margin-bottom:15px;
}
.card-body {
  padding:30px;
}
.form-label {
  font-weight:600;
  color:#444;
}
.btn-save {
  background:linear-gradient(135deg,var(--blue),var(--red));
  border:none;
  font-weight:600;
  color:#fff;
  padding: 10px 20px;
  border-radius: 8px;
}
</style>

<!-- Settings Card -->
<div class="settings-card">
  <div class="settings-header">
    <img src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=2f307f&color=fff' }}" alt="Profile Picture">
    <h3 class="mt-3 mb-0">{{ auth()->user()->name }}</h3>
  </div>

  <div class="card-body">
    @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Profile Picture Section -->
        <div class="mb-3">
            <label class="form-label">Profile Picture</label>
            <input type="file" class="form-control" name="profile_picture" accept="image/*" id="profilePictureInput">

            <!-- Live Preview -->
            <div class="mt-2" id="previewContainer" style="display: none;">
                <strong>Preview:</strong>
                <div class="mt-2">
                    <img id="previewImage" src=""
                         alt="Preview"
                         style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd;">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required>
        </div>

        <!-- Student ID - Only for students -->
    @if(auth()->user()->role === 'student')
        <div class="mb-3">
            <label class="form-label">Student ID</label>
            <input type="text" class="form-control" name="id_number" value="{{ auth()->user()->id_number }}" required>
        </div>
    @endif

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current password">
                <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fas fa-eye"></i></button>
            </div>
            <div class="form-text">Leave blank if you don't want to change your password.</div>
        </div>

        <button type="submit" class="btn btn-save w-100 mt-3">
            <i class="fas fa-save me-2"></i>Save Changes
        </button>
    </form>
</div>

@endsection
@push('scripts')
<script>
// Live preview for profile picture
document.getElementById('profilePictureInput').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) {
        document.getElementById('previewContainer').style.display = 'none';
        return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
        document.getElementById('previewImage').src = e.target.result;
        document.getElementById('previewContainer').style.display = 'block';
    };
    reader.readAsDataURL(file);
});

// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', () => {
    const input = document.querySelector('input[name="password"]');
    const icon = document.querySelector('#togglePassword i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});
</script>
@endpush
