{{-- Reuse the shared CertTrack dashboard layout. --}}
@extends('layouts.app')

@section('title', 'Register Certificate | CertTrack')
@section('page-heading', 'Register Certificate')
@section('page-subtitle', 'Add an inspection certificate and connect it to a customer.')

@section('content')
<div class="card">
    <h2>Certificate Information</h2>

    @if ($customers->isEmpty())
        <p>No customers are registered yet. Register a customer before adding a certificate.</p>
        <a href="{{ route('customers.create') }}" class="btn-primary">Register Customer</a>
    @else
        <form action="{{ route('certificates.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="customer_id">Customer</label>
                <select name="customer_id" id="customer_id" required>
                    <option value="">Choose a customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }} - {{ $customer->phone }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="certificate_number">Certificate Number</label>
                <input type="text" id="certificate_number" name="certificate_number" value="{{ old('certificate_number') }}" required>
            </div>

            <div class="form-group">
                <label for="issue_date">Issue Date</label>
                <input type="date" id="issue_date" name="issue_date" value="{{ old('issue_date') }}" required>
            </div>

            <div class="form-group">
                <label for="next_inspection_date">Next Inspection Date</label>
                <input type="date" id="next_inspection_date" name="next_inspection_date" value="{{ old('next_inspection_date') }}" required>
            </div>

            <div class="form-group">
                <label for="booking_url">External Booking URL (optional)</label>
                <input type="url" id="booking_url" name="booking_url" value="{{ old('booking_url') }}" placeholder="https://example.com">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Register Certificate</button>
                <a href="{{ route('certificates.index') }}" class="edit-button">Cancel</a>
            </div>
        </form>
    @endif
</div>
@endsection
