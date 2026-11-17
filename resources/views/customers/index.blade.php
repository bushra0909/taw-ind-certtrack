<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - CertTrack</title>
</head>
<body>

    <h1>Registered Customers</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('customers.create') }}">Register New Customer</a>

    @if ($customers->isEmpty())
        <p>No customers registered yet.</p>
    @else
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->address }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>