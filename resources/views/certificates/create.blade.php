<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Certificate - CertTrack</title>
</head>
<body>

    <h1>Register Inspection Certificate</h1>

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

    @if ($customers->isEmpty())
        <p>Please register a customer before adding a certificate.</p>
        <a href="{{ route('customers.create') }}">Register Customer</a>
    @else

        <form action="{{ route('certificates.store') }}" method="POST">
            @csrf

            <label for="customer_id">Select Customer:</label>
            <select name="customer_id" id="customer_id" required>
                <option value="">Choose a customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}"
                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }} - {{ $customer->phone }}
                    </option>
                @endforeach
            </select>
            <br><br>

            <label for="certificate_number">Certificate Number:</label>
            <input type="text" id="certificate_number"
                   name="certificate_number"
                   value="{{ old('certificate_number') }}" required>
            <br><br>

            <label for="issue_date">Issue Date:</label>
            <input type="date" id="issue_date"
                   name="issue_date"
                   value="{{ old('issue_date') }}" required>
            <br><br>

            <label for="next_inspection_date">Next Inspection Date:</label>
            <input type="date" id="next_inspection_date"
                   name="next_inspection_date"
                   value="{{ old('next_inspection_date') }}" required>
            <br><br>

            <label for="booking_url">External Booking URL (optional):</label>
            <input type="url" id="booking_url"
                   name="booking_url"
                   value="{{ old('booking_url') }}">
            <br><br>

            <button type="submit">Register Certificate</button>
        </form>

    @endif

    <p><a href="{{ route('certificates.index') }}">View Certificates</a></p>

</body>
</html>