@extends('layouts.admin')

@section('content')
<style>
    :root {
        --blue: #2f307f;
        --red: #dd3226;
        --yellow: #feec57;
        --light: #f8f9fc;
        --dark: #212529;
        --success: #4bb543;
        --warning: #ffc107;
        --danger: #dc3545;
    }

    body {
        background-color: #f9fafc;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        overflow-x: hidden;
    }

    /* Header Navbar */
    .admin-header {
        background: linear-gradient(135deg, var(--red), var(--blue));
        padding: 15px 25px;
        color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .admin-header h4 {
        margin: 0;
        font-weight: 700;
        display: flex;
        align-items: center;
    }

    .admin-header .nav-link {
        color: white !important;
        margin: 0 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        border-radius: 6px;
        padding: 8px 16px !important;
    }

    .admin-header .nav-link:hover {
        background: rgba(255,255,255,0.15);
        transform: translateY(-2px);
    }

    .admin-header .nav-link.active {
        background: rgba(255,255,255,0.25);
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Sidebar */
    .sidebar {
        background: white;
        border-right: 1px solid #eaeaea;
        min-height: calc(100vh - 70px);
        padding: 25px 20px;
        box-shadow: 2px 0 10px rgba(0,0,0,0.03);
    }

    .sidebar h6 {
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--blue);
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }

    .sidebar a {
        display: flex;
        align-items: center;
        color: #555;
        padding: 12px 15px;
        border-radius: 8px;
        text-decoration: none;
        margin-bottom: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .sidebar a:hover {
        background: linear-gradient(135deg, #fef6cc, #fff9e1);
        color: var(--red);
        transform: translateX(5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }

    .sidebar a i {
        width: 20px;
        margin-right: 10px;
        text-align: center;
    }

    /* Dashboard Cards */
    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        text-align: center;
        transition: all 0.3s ease;
        border-top: 4px solid var(--blue);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--red), var(--yellow));
    }

    .stat-card h3 {
        margin: 0;
        color: var(--blue);
        font-size: 2.2rem;
        font-weight: 700;
    }

    .stat-card p {
        margin: 0;
        color: #6c757d;
        font-weight: 500;
    }

    /* Management Cards */
    .management-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
        border-left: 4px solid var(--red);
    }

    .management-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .management-card h5 {
        color: var(--blue);
        font-weight: 700;
        margin-bottom: 15px;
    }

    .management-card p {
        color: #6c757d;
        margin-bottom: 20px;
    }

    /* Buttons */
    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--blue), var(--red));
        border: none;
    }

    .btn-success {
        background: linear-gradient(135deg, var(--yellow), var(--red));
        border: none;
        color: #212529;
    }

    .btn-warning {
        background: linear-gradient(135deg, var(--yellow), #f8d64e);
        border: none;
        color: #212529;
    }

    .btn-light {
        background: #fff;
        border: 1px solid #ddd;
        color: var(--blue);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    /* Welcome Section */
    .welcome-section {
        background: linear-gradient(135deg, #fff9e6, #fef6cc);
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        border-left: 4px solid var(--red);
    }

    .welcome-section h5 {
        color: var(--blue);
        font-weight: 700;
        margin-bottom: 10px;
    }

    /* Footer */
    footer {
        background: linear-gradient(135deg, var(--red), var(--blue));
        color: white;
        text-align: center;
        padding: 12px;
        margin-top: 40px;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    @media (max-width: 768px) {
        .sidebar {
            min-height: auto;
            border-right: none;
            border-bottom: 1px solid #eaeaea;
        }
        .admin-header .nav {
            display: none;
        }
    }
</style>


<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 sidebar">
            <h6><i class="fas fa-bolt me-2"></i>Quick Actions</h6>
            <a href="{{ route('admin.users.create') }}"><i class="fas fa-user-plus"></i>Add New User</a>
            <a href="{{ route('admin.notes.create') }}"><i class="fas fa-file-upload"></i>Create Note</a>
            <a href="{{ route('admin.reports') }}"><i class="fas fa-chart-bar"></i>View Reports</a>
        </div>

        <!-- MAIN DASHBOARD -->
        <div class="col-md-9 col-lg-10 p-4">
            <div class="welcome-section">
                <h5>Welcome Back, Administrator! 👋</h5>
                <p class="text-muted mb-0">Manage your Note-Nest platform with admin tools and analytics. Today is <span id="current-date"></span>.</p>
            </div>

            <!-- Stats Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <h3>{{ $stats['total_users'] }}</h3>
                        <p>Total Users</p>
                        <div class="mt-2 text-success small">
                            <i class="fas fa-arrow-up me-1"></i> {{ $stats['new_users_this_week'] }} new this week
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h3>{{ $stats['total_notes'] }}</h3>
                        <p>Notes Uploaded</p>
                        <div class="mt-2 text-success small">
                            <i class="fas fa-arrow-up me-1"></i> {{ $stats['new_notes_this_month'] }} new this month
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h3>{{ $stats['total_teachers'] }}</h3>
                        <p>Teachers</p>
                        <div class="mt-2 text-primary small">
                            <i class="fas fa-user-check me-1"></i> All active
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h3>{{ $stats['total_students'] }}</h3>
                        <p>Students</p>
                        <div class="mt-2 text-primary small">
                            <i class="fas fa-user-check me-1"></i> All active
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Cards -->
            <div class="row g-3">
                <!-- User Management -->
                <div class="col-md-4">
                    <div class="management-card">
                        <h5><i class="fas fa-users me-2"></i>User Management</h5>
                        <p>Manage students, teachers, and admin roles with detailed user profiles and permissions.</p>
                        <a href="{{ route('admin.users') }}" class="btn btn-primary btn-sm mt-2">
                            <i class="fas fa-cog me-1"></i> Manage Users
                        </a>
                    </div>
                </div>

                <!-- Notes Management -->
                <div class="col-md-4">
                    <div class="management-card">
                        <h5><i class="fas fa-file-alt me-2"></i>Notes Management</h5>
                        <p>View, edit, and manage all uploaded notes. Monitor content quality and organization.</p>
                        <a href="{{ route('admin.notes') }}" class="btn btn-success btn-sm mt-2">
                            <i class="fas fa-search me-1"></i> Manage Notes
                        </a>
                    </div>
                </div>

                <!-- Reports & Analytics -->
                <div class="col-md-4">
                    <div class="management-card">
                        <h5><i class="fas fa-chart-bar me-2"></i>Reports & Analytics</h5>
                        <p>Track platform activity, generate insights, and download comprehensive reports.</p>
                        <a href="#" class="btn btn-warning btn-sm mt-2">
                            <i class="fas fa-download me-1"></i> View Reports
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="management-card">
                        <h5><i class="fas fa-history me-2"></i>Recent Activity</h5>
                        <div class="list-group list-group-flush">
                            @foreach($recentActivity as $activity)
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                    <div>
                                        <i class="fas {{ $activity['icon'] }} {{ $activity['color'] }} me-2"></i>
                                        <span>{{ $activity['message'] }}</span>
                                    </div>
                                    <small class="text-muted">{{ $activity['time'] }}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>


<script>
    document.getElementById('current-date').textContent = new Date().toLocaleDateString('en-US', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
    });
</script>
@endsection
