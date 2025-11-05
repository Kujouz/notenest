@extends('layouts.admin')

@section('content')
<div class="container my-4" id="reportContent">
  <div class="page-header d-flex justify-content-between align-items-center">
    <h2><i class="fas fa-chart-bar me-2"></i>Reports & Analytics</h2>
    <div class="d-flex flex-wrap align-items-center gap-2">
      <button class="btn btn-success btn-export btn-sm" onclick="exportPDF()"><i class="fas fa-file-pdf me-1"></i> PDF</button>
      <button class="btn btn-warning btn-export btn-sm" onclick="exportExcel()"><i class="fas fa-file-excel me-1"></i> Excel</button>
    </div>
  </div>

  <!-- Stats -->
  <div class="row g-3 mb-4">
    <div class="col-md-3"><div class="stat-card"><h3>{{ $totalUsers }}</h3><p>Total Users</p></div></div>
    <div class="col-md-3"><div class="stat-card"><h3>{{ $teacherCount }}</h3><p>Teachers</p></div></div>
    <div class="col-md-3"><div class="stat-card"><h3>{{ $studentCount }}</h3><p>Students</p></div></div>
    <div class="col-md-3"><div class="stat-card"><h3>{{ $totalNotes }}</h3><p>Notes Uploaded</p></div></div>
  </div>

  <!-- Charts -->
  <div class="chart-container mb-4">
    <h5><i class="fas fa-layer-group me-2"></i>Notes by Folder</h5>
    <canvas id="folderChart" height="120"></canvas>
  </div>

  <div class="chart-container mb-4">
    <h5><i class="fas fa-users me-2"></i>Uploads by Role</h5>
    <canvas id="roleChart" height="120"></canvas>
  </div>

  <div class="chart-container mb-4">
    <h5><i class="fas fa-calendar-week me-2"></i>Upload Activity</h5>
    <canvas id="activityChart" height="120"></canvas>
  </div>

  <div class="chart-container mb-5">
    <h5><i class="fas fa-trophy me-2"></i>Top Uploaders</h5>
    <canvas id="topUserChart" height="120"></canvas>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
const folderLabels = @json($notesByFolder->pluck('folder.name'));
const folderCounts = @json($notesByFolder->pluck('count'));

const roleLabels = @json($uploadsByRole->pluck('role'));
const roleCounts = @json($uploadsByRole->pluck('uploads'));

const activityLabels = @json($activity->pluck('date'));
const activityCounts = @json($activity->pluck('uploads'));

const topUserLabels = @json($topUploaders->pluck('name'));
const topUserCounts = @json($topUploaders->pluck('uploads'));

// Render charts
new Chart(document.getElementById('folderChart'), {
  type: 'bar',
  data: { labels: folderLabels, datasets: [{ data: folderCounts, backgroundColor: '#2f307f' }] },
  options: { plugins: { legend: { display: false } } }
});

new Chart(document.getElementById('roleChart'), {
  type: 'doughnut',
  data: { labels: roleLabels, datasets: [{ data: roleCounts, backgroundColor: ['#dd3226','#feec57','#2f307f'] }] }
});

new Chart(document.getElementById('activityChart'), {
  type: 'line',
  data: { labels: activityLabels, datasets: [{ data: activityCounts, borderColor: '#2f307f', backgroundColor: 'rgba(47,48,127,0.2)', fill: true }] }
});

new Chart(document.getElementById('topUserChart'), {
  type: 'bar',
  data: { labels: topUserLabels, datasets: [{ data: topUserCounts, backgroundColor: '#feec57' }] },
  options: { plugins: { legend: { display: false } } }
});

// Export PDF
function exportPDF() {
  const { jsPDF } = window.jspdf;
  html2canvas(document.getElementById("reportContent")).then(canvas => {
    const imgData = canvas.toDataURL("image/png");
    const pdf = new jsPDF("p", "mm", "a4");
    const width = pdf.internal.pageSize.getWidth();
    const height = canvas.height * width / canvas.width;
    pdf.addImage(imgData, "PNG", 0, 0, width, height);
    pdf.save("NoteNest_Report.pdf");
  });
}

// Export Excel
function exportExcel() {
  let csv = "Date,Uploads\n";
  activityLabels.forEach((date, i) => {
    csv += `${date},${activityCounts[i]}\n`;
  });
  const blob = new Blob([csv], { type: "text/csv" });
  const link = document.createElement("a");
  link.href = URL.createObjectURL(blob);
  link.download = "NoteNest_Report.csv";
  link.click();
}
</script>
@endsection
