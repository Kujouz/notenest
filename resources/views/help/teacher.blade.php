@extends('layouts.app')

@section('content')
<style>
:root {
  --blue: #2f307f;
  --red: #dd3226;
  --yellow: #feec57;
}

body {
  font-family: "Segoe UI", Tahoma, sans-serif;
  background: #f7f9fc;
  color: #212529;
}

/* Header */
.header {
  background: linear-gradient(135deg, var(--blue), var(--red));
  color: white;
  text-align: center;
  padding: 70px 20px;
  border-bottom-left-radius: 40px;
  border-bottom-right-radius: 40px;
}
.header h1 {
  font-weight: 800;
  font-size: 2.5rem;
}
.header p {
  font-size: 1.1rem;
  margin-top: 10px;
}

/* FAQ Section */
.faq-section {
  max-width: 900px;
  margin: 60px auto;
}
.accordion-button {
  font-weight: 600;
  color: var(--blue);
}
.accordion-button:not(.collapsed) {
  background-color: rgba(47,48,127,0.1);
}
.accordion-body {
  background: #fff;
}

/* Contact Us */
.contact-section {
  background: white;
  max-width: 850px;
  margin: 60px auto;
  border-radius: 16px;
  padding: 40px;
  box-shadow: 0 6px 24px rgba(0,0,0,0.05);
}
.contact-section h3 {
  font-weight: 700;
  color: var(--blue);
  margin-bottom: 20px;
}
.contact-section label {
  font-weight: 600;
}
.btn-send {
  background: linear-gradient(135deg, var(--blue), var(--red));
  color: white;
  border: none;
  font-weight: 600;
  padding: 10px 20px;
  border-radius: 10px;
}
.btn-send:hover {
  background: linear-gradient(135deg, var(--red), var(--blue));
}
</style>

<!-- Header -->
<section class="header">
  <h1><i class="fas fa-circle-question me-2"></i>Help Center</h1>
  <p>Need assistance? Browse FAQs, chat with AI, or contact us directly.</p>
</section>

<!-- FAQ Section -->
<div class="faq-section">
  <div class="accordion" id="faqAccordion">
    <div class="accordion-item">
      <h2 class="accordion-header" id="faq1">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
          How can I create a new quiz for students?
        </button>
      </h2>
      <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Go to the <strong>Quiz Management</strong> page, click on <em>“Create New Quiz”</em>, and add your questions. Click <strong>Publish</strong> to make it visible to students.
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="faq2">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
          How can I review student quiz results?
        </button>
      </h2>
      <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Go to <strong>Quiz History</strong> or <strong>Review Answers</strong> in your dashboard to view scores and answers.
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="faq3">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
          How to upload and share notes with students?
        </button>
      </h2>
      <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Go to <strong>Notes</strong>, create a folder, upload your materials, and publish them so students can access them immediately.
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="faq4">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
          What should I do if the upload fails?
        </button>
      </h2>
      <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Ensure your file size is under 10MB and your internet is stable. If issues persist, use the AI Chat Bot or contact our support team.
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Contact Us Section -->
<section class="contact-section">
  <h3><i class="fas fa-envelope me-2"></i>Contact Us</h3>
  <p class="text-muted mb-4">If your issue isn’t resolved, send us a message and our team will respond as soon as possible.</p>

  <form id="contactForm">
    @csrf
    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Email Address</label>
        <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required>
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Message</label>
      <textarea class="form-control" name="message" rows="4" required></textarea>
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-send">
        <i class="fas fa-paper-plane me-1"></i>Send Message
      </button>
    </div>
  </form>
</section>

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
document.getElementById("contactForm").addEventListener("submit", function(e) {
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
