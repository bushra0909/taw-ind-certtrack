{{-- Use the shared CertTrack dashboard layout. --}}
@extends('layouts.app')

{{-- Browser tab title. --}}
@section('title', 'Certificate Reminders | CertTrack')

{{-- Dashboard heading and description. --}}
@section('page-heading', 'Certificate Reminders')
@section('page-subtitle', 'Track upcoming certificate inspections and reminder records.')

@section('content')

    <div class="card">

        {{-- Show confirmation after reminder records are prepared. --}}
        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        {{-- Page heading and available actions. --}}
        <div class="page-actions">
            <div>
                <h2>Reminder Records</h2>
                <p>Review the reminders prepared for your registered certificates.</p>
            </div>

            {{-- Send a POST request to prepare reminder records. --}}
            <form action="{{ route('reminders.prepare') }}" method="POST">
                @csrf

                <button type="submit" class="add-button">
                    Prepare Reminders
                </button>
            </form>

            {{-- Navigate to certificate management. --}}
            <a href="{{ route('certificates.index') }}" class="add-button">
                View Certificates
            </a>
        </div>

        {{-- Explain the current reminder functionality honestly. --}}
        <p>
            <strong>Reminder information:</strong>
            The system prepares 30-day and 7-day reminder records.
            SMS delivery is not yet connected.
        </p>

        <div class="table-wrapper">

            <table>
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Certificate Number</th>
                        <th>Reminder Type</th>
                        <th>Inspection Date</th>
                        <th>Status</th>
                        <th>Sent At</th>
                    </tr>
                </thead>

                <tbody>

                    {{-- Display every reminder supplied by ReminderController. --}}
                    @forelse ($reminders as $reminder)

                        <tr>
                            {{-- Customer associated with the certificate. --}}
                            <td>
                                {{ $reminder->certificate?->customer?->name ?? 'Unknown Customer' }}
                            </td>

                            {{-- Certificate identification number. --}}
                            <td>
                                {{ $reminder->certificate?->certificate_number ?? 'Unavailable' }}
                            </td>

                            {{-- Convert 30_day into 30 Day, for example. --}}
                            <td>
                                {{ ucfirst(str_replace('_', ' ', $reminder->reminder_type)) }}
                            </td>

                            {{-- Date when the certificate needs inspection. --}}
                            <td>
                                {{ $reminder->inspection_date?->format('d M Y') ?? 'Not available' }}
                            </td>

                            {{-- Current reminder status. --}}
                            <td>
                                <span class="status-badge status-{{ strtolower($reminder->status) }}">
                                    {{ ucfirst($reminder->status) }}
                                </span>
                            </td>

                            {{-- Display SMS delivery time if available. --}}
                            <td>
                                {{ $reminder->sent_at?->format('d M Y, h:i A') ?? 'Not sent' }}
                            </td>
                        </tr>

                        {{-- Show any recorded delivery error. --}}
                        @if ($reminder->error_message)
                            <tr>
                                <td colspan="6">
                                    <strong>Delivery error:</strong>
                                    {{ $reminder->error_message }}
                                </td>
                            </tr>
                        @endif

                    @empty

                        <tr>
                            <td colspan="6">
                                No reminder records are available yet.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>

    </div>

@endsection
