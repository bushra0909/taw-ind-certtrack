<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificates - CertTrack</title>
</head>
<body>

    <h1>Registered Certificates</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <p><a href="{{ route('certificates.create') }}">Register New Certificate</a></p>
    <p><a href="{{ route('customers.index') }}">View Customers</a></p>

    @if ($certificates->isEmpty())
        <p>No certificates registered yet.</p>
    @else
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Certificate Number</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Issue Date</th>
                    <th>Next Inspection</th>
                    <th>Booking Link</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($certificates as $certificate)
                    <tr>
                        <td>{{ $certificate->certificate_number }}</td>
                        <td>{{ $certificate->customer->name }}</td>
                        <td>{{ $certificate->customer->phone }}</td>
                        <td>{{ $certificate->issue_date->format('d M Y') }}</td>
                        <td>{{ $certificate->next_inspection_date->format('d M Y') }}</td>
                        <td>
                            @if ($certificate->booking_url)
                                <a href="{{ $certificate->booking_url }}" target="_blank" rel="noopener noreferrer">Book Inspection</a>
                            @else
                                Not provided
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>