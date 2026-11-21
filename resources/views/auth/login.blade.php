<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | CertTrack</title>

    @vite(['resources/css/style.css', 'resources/js/app.js'])
</head>

<body class="app-body">

    <main class="login-container">

        <section class="login-card">

            <div class="login-brand">
                <div class="brand-icon">C</div>
                <h1>CertTrack</h1>
                <p>Certificate Management System</p>
            </div>

            <div class="login-heading">
                <h2>Administrator Login</h2>
                <p>Sign in to manage your certificates and customers.</p>
            </div>

            @if ($errors->any())
                <div class="error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">

                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter your email"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <div class="remember-option">
                    <label>
                        <input type="checkbox" name="remember" value="1">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="btn-primary login-button">
                    Sign In
                </button>

            </form>

            <p class="login-footer">
                Authorized administrators only.
            </p>

        </section>

    </main>

</body>
</html>
