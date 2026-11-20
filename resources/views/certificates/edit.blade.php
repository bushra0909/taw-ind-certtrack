{{-- Reuse the shared CertTrack dashboard layout. --}}
@extends('layouts.app')

@section('title', 'Edit Certificate | CertTrack')
@section('page-heading', 'Edit Certificate')
@section('page-subtitle', 'Update the customer, certificate number or inspection dates.')

@section('content')
<div class="card">
    <h2>Certificate Information</h2>

    <form action="{{ route('certificates.update', $certificate) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="customer_id">Customer</label>
            <select name="customer_id" id="customer_id" required>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id', $certificate->customer_id) == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }} - {{ $customer->phone }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="certificate_number">Certificate Number</label>
            <input type="text" id="certificate_number" name="certificate_number" value="{{ old('certificate_number', $certificate->certificate_number) }}" required>
        </div>

        <div class="form-group">
            <label for="issue_date">Issue Date</label>
            <input type="date" id="issue_date" name="issue_date" value="{{ old('issue_date', $certificate->issue_date->format('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label for="next_inspection_date">Next Inspection Date</label>
            <input type="date" id="next_inspection_date" name="next_inspection_date" value="{{ old('next_inspection_date', $certificate->next_inspection_date->format('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label for="booking_url">External Booking URL (optional)</label>
            <input type="url" id="booking_url" name="booking_url" value="{{ old('booking_url', $certificate->booking_url) }}">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Update Certificate</button>
            <a href="{{ route('certificates.index') }}" class="edit-button">Cancel</a>
        </div>
    </form>
</div>
@endsection
