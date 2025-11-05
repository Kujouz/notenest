<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Note-Nest Admin | @yield('title')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #4361ee;
      --primary-dark: #3a0ca3;
      --secondary: #7209b7;
      --accent: #4cc9f0;
      --light: #f8f9fc;
      --dark: #212529;
      --success: #4bb543;
      --warning: #ffc107;
      --danger: #dc3545;
    }

    body {
      background-color: #f5f7ff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      overflow-x: hidden;
    }

    /* Header Navbar */
    .admin-header {
      background: linear-gradient(135deg, #dd3226, #2f307f);
      padding: 15px 25px;
      color: white;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
      background: rgba(255, 255, 255, 0.15);
      transform: translateY(-2px);
    }

    .admin-header .nav-link.active {
      background: rgba(255, 255, 255, 0.25);
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Sidebar */
    .sidebar {
      background: white;
      border-right: 1px solid #eaeaea;
      min-height: calc(100vh - 70px);
      padding: 25px 20px;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.03);
    }

    .sidebar h6 {
      font-weight: 700;
      margin-bottom: 20px;
      color: var(--primary);
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
      background: linear-gradient(135deg, #f0f4ff 0%, #e6eeff 100%);
      color: var(--primary);
      transform: translateX(5px);
      box-shadow: 0 4px 8px rgba(67, 97, 238, 0.15);
    }

    .sidebar a i {
      width: 20px;
      margin-right: 10px;
      text-align: center;
    }
  </style>
</head>
<body>

<!-- HEADER -->
<div class="admin-header d-flex justify-content-between align-items-center">
  <h4 class="d-flex align-items-center">
    <img src="{{ asset('images/notenest.png') }}" alt="Logo"
         style="height:40px; width:auto; border-radius:8px; margin-right:10px;">
    Note-Nest Admin
  </h4>
  <ul class="nav d-none d-md-flex">
    <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a></li>
    <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}"><i class="fas fa-users me-1"></i> Users</a></li>
    <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.notes') ? 'active' : '' }}" href="{{ route('admin.notes') }}"><i class="fas fa-file-alt me-1"></i> Notes</a></li>
    <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}" href="{{ route('admin.reports') }}"><i class="fas fa-chart-bar me-1"></i> Reports</a></li>
  </ul>
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-light btn-sm"><i class="fas fa-sign-out-alt me-1"></i> Logout</button>
  </form>
</div>

    <!-- MAIN CONTENT -->
    <div class="col-md-9 col-lg-10 p-4">
      @yield('content')
    </div>
  </div>
</div>

</body>
</html>
