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
.ai-btn {
  background:var(--yellow);
  color:#000;
  font-weight:600;
  border:none;
  border-radius:8px;
  padding:6px 14px;
}
.header {
  background:linear-gradient(135deg,var(--blue),var(--red));
  color:#fff;
  text-align:center;
  padding:60px 20px;
  border-bottom-left-radius:40px;
  border-bottom-right-radius:40px;
}
.header h1 {
  font-weight:800;
  font-size:2.4rem;
}
.section-title {
  color:var(--blue);
  font-weight:700;
  margin-bottom:1rem;
  border-left:5px solid var(--red);
  padding-left:10px;
}
.accordion-button {
  background-color:#fff;
  font-weight:600;
}
.accordion-button:not(.collapsed){
  background-color:rgba(47,48,127,0.1);
  color:var(--blue);
}
.contact-card {
  background:#fff;
  border-radius:15px;
  box-shadow:0 8px 24px rgba(0,0,0,0.08);
  padding:30px;
}
.btn-submit {
  background:linear-gradient(135deg,var(--blue),var(--red));
  color:#fff;
  border:none;
  font-weight:600;
}
.btn-submit:hover {
  background:linear-gradient(135deg,var(--red),var(--blue));
}
</style>

<!-- Header -->
<section class="header">
  <h1><i class="fas fa-circle-question me-2"></i>Help Center</h1>
  <p class="lead">Find answers to common questions or chat with our AI assistant.</p>
</section>

<!-- Main Content -->
<div class="container py-5">
  <!-- FAQs -->
  <h3 class="section-title"><i class="fas fa-user-graduate me-2"></i>For Students</h3>
  <div class="accordion mb-5" id="studentFaq">
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq1">
          How do I submit my assignments?
        </button>
      </h2>
      <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#studentFaq">
        <div class="accordion-body">
          Students can submit their assignments into existing folders created by teachers. Click the <b>Submit Assignment</b> button within a folder, fill in details, and select your file.
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq2">
          How do I take a quiz?
        </button>
      </h2>
      <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#studentFaq">
        <div class="accordion-body">
          Go to the <b>Take Quiz</b> page from your dashboard. Select a quiz from the list and click “Start” to begin.
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq3">
          Can I edit my profile?
        </button>
      </h2>
      <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#studentFaq">
        <div class="accordion-body">
          Yes! Navigate to <b>Profile</b> or <b>Settings</b> from your dropdown menu to update your name, email, program, or profile picture.
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Contact Section -->
<div class="contact-card">
  <h3 class="section-title"><i class="fas fa-envelope me-2"></i>Contact Support</h3>
  <form id="contactForm">
    @csrf
    <div class="mb-3">
      <label class="form-label">Your Name</label>
      <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Your Email</label>
      <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Message</label>
      <textarea class="form-control" name="message" rows="4" required></textarea>
    </div>
    <button type="submit" class="btn btn-submit w-100">
      <i class="fas fa-paper-plane me-2"></i>Send Message
    </button>
  </form>
</div>

<!-- AI Chat Bot (Jotform) -->
@if(auth()->check())
<div class="offcanvas offcanvas-end" tabindex="-1" id="chatBotSidebar">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title"><i class="fas fa-robot me-2"></i>Note-Nest AI Assistant</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body p-0">
    @php
        $username = urlencode(Auth::user()->name ?? 'Guest');
    @endphp
    <iframe id="JotFormIFrame-AI" title="Note-Nest AI Assistant" allowtransparency="true"
        allow="geolocation; microphone; camera; fullscreen"
        src="https://agent.jotform.com/0199c71f56fa7ad0b73300d27f16df668ffb?embedMode=iframe&background=1&shadow=1&user_name={{ $username }}"
        frameborder="0" style="max-width:100%; height:650px; border:none; width:100%;"></iframe>
  </div>
</div>
@endif

@endsection

@push('scripts')
<script>
// Contact Form Submission
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("{{ route('help.contact') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            this.reset();
        }
    })
    .catch(error => {
        alert("An error occurred. Please try again.");
    });
});

// AI Chat Bot Button
document.addEventListener('DOMContentLoaded', function() {
    const chatButton = document.querySelector('[data-bs-toggle="offcanvas"][data-bs-target="#chatBotSidebar"]');
    if (chatButton) {
        chatButton.addEventListener('click', function() {
            const iframe = document.getElementById('JotFormIFrame-AI');
            if (iframe) {
                iframe.contentWindow.postMessage('refresh', '*');
            }
        });
    }
});
</script>
@endpush
