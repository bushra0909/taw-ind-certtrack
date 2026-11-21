
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'CertTrack | Certificate Management')</title>

    @vite(['resources/css/style.css', 'resources/js/app.js'])
</head>

<body class="app-body">

<div class="app-layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <!-- BRAND LOGO -->
        <a href="{{ route('customers.index') }}" class="brand">
            <div class="brand-icon">C</div>

            <div class="brand-text">
                <strong>CertTrack</strong>
                <span>Certificate Management</span>
            </div>
        </a>

        <!-- NAVIGATION -->
        <div class="sidebar-label">MAIN MENU</div>

        <nav class="sidebar-nav">

            <a href="{{ route('customers.index') }}"
               class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">
                <span class="nav-icon">👥</span>
                <span>Customers</span>
            </a>

            <a href="{{ route('certificates.index') }}"
               class="{{ request()->routeIs('certificates.*') ? 'active' : '' }}">
                <span class="nav-icon">📄</span>
                <span>Certificates</span>
            </a>

            <a href="{{ route('reminders.index') }}"
               class="{{ request()->routeIs('reminders.*') ? 'active' : '' }}">
                <span class="nav-icon">🔔</span>
                <span>Reminders</span>
            </a>

        </nav>

        <!-- SIDEBAR FOOTER -->
        <div class="sidebar-bottom">

            <div class="sidebar-bottom-icon">✓</div>

            <div class="sidebar-bottom-text">
                <strong>Stay Organized</strong>
                <span>Manage. Track. Renew.</span>
            </div>

        </div>

    </aside>


    <!-- MAIN CONTENT AREA -->
    <div class="main-area">

        <!-- TOP HEADER -->
        <header class="topbar">

            <div class="topbar-heading">

                <span class="topbar-label">
                    CERTIFICATE MANAGEMENT SYSTEM
                </span>

                <h1>@yield('page-heading', 'Dashboard')</h1>

                <p>
                    @yield('page-subtitle', 'Manage your certificate operations in one place.')
                </p>

            </div>

            <!-- ADMINISTRATOR ACCOUNT -->
            <div class="topbar-account">

                <div class="admin-info">
                    <strong>{{ auth()->user()->name }}</strong>
                    <span>Administrator</span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="logout-button">
                        Sign Out
                    </button>
                </form>

            </div>

        </header>


        <!-- PAGE CONTENT -->
        <main class="page-content">

            @if (session('success'))
                <div class="success">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="error">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="error">

                    <strong>Please correct the following errors:</strong>

                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach

                </div>
            @endif

            @yield('content')

        </main>


        <!-- FOOTER -->
        <footer class="app-footer">

            <span>© {{ date('Y') }} CertTrack</span>

            <span>Certificate Management System</span>

        </footer>

    </div>

</div>

</body>
</html>
