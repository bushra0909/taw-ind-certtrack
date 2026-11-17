
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Customer - CertTrack</title>
</head>
<body>

    <h1>Register New Customer</h1>

    <!-- Display validation errors if the form contains incorrect information. -->
    @if ($errors->any())
        <div>
            <strong>Please correct these errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Display success message when a customer is registered. -->
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <!-- Send customer information to the Laravel controller. -->
    <form action="{{ route('customers.store') }}" method="POST">
        @csrf

        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name"
               value="{{ old('name') }}" required>
        <br><br>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone"
               value="{{ old('phone') }}" required>
        <br><br>

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email"
               value="{{ old('email') }}">
        <br><br>

        <label for="address">Address:</label>
        <textarea id="address" name="address">{{ old('address') }}</textarea>
        <br><br>

        <button type="submit">Register Customer</button>
    </form>

</body>
</html>
