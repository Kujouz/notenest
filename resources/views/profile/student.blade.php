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
.profile-card {
  max-width:650px;
  margin:80px auto;
  background:#fff;
  border:none;
  border-radius:15px;
  box-shadow:0 6px 30px rgba(0,0,0,0.08);
  overflow:hidden;
}
.profile-header {
  background:linear-gradient(135deg,var(--blue),var(--red));
  color:#fff;
  text-align:center;
  padding:40px 20px 30px;
  border-top-left-radius:15px;
  border-top-right-radius:15px;
  position:relative;
}
.profile-header img {
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
input[readonly] {
  background-color:#f8f9fa;
  border-color:#dee2e6;
  pointer-events:none;
}
</style>

<div class="profile-card">
  <div class="profile-header">
    <img src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=2f307f&color=fff' }}"
         alt="Profile Picture">
    <h3 class="mt-3 mb-0">{{ auth()->user()->name }}</h3>
    <small>Information Technology</small>
  </div>

  <div class="card-body">
    <div class="mb-3">
      <label class="form-label">Student ID</label>
      <input type="text" class="form-control" value="{{ auth()->user()->id_number ?? 'STU-' . auth()->id() }}" readonly>
    </div>
    <div class="mb-3">
      <label class="form-label">Full Name</label>
      <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
    </div>
    <div class="mb-3">
      <label class="form-label">Email Address</label>
      <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
    </div>
    <div class="mb-3">
      <label class="form-label">Program</label>
      <input type="text" class="form-control" value="Information Technology" readonly>
    </div>
  </div>
</div>

@endsection
