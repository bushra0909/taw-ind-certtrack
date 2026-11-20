
{{-- Reuse the shared CertTrack dashboard layout. --}}
@extends('layouts.app')

{{-- Browser tab title. --}}
@section('title', 'Edit Customer | CertTrack')

{{-- Dashboard heading and description. --}}
@section('page-heading', 'Edit Customer')
@section('page-subtitle', 'Update the customer's contact and registration details.')

@section('content')

    <div class="card">

        <h2>Customer Information</h2>

        <p>Update the information below and save your changes.</p>

        {{-- Send updated customer information to CustomerController. --}}
        <form action="{{ route('customers.update', $customer) }}" method="POST">

            @csrf
            @method('PUT')

            {{-- Customer name. --}}
            <div class="form-group">
                <label for="name">Customer Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $customer->name) }}"
                    autocomplete="name"
                    required
                >
            </div>

            {{-- Customer phone number. --}}
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="{{ old('phone', $customer->phone) }}"
                    autocomplete="tel"
                    required
                >
            </div>

            {{-- Customer email address. --}}
            <div class="form-group">
                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $customer->email) }}"
                    autocomplete="email"
                >
            </div>

            {{-- Customer address. --}}
            <div class="form-group">
                <label for="address">Address</label>
                <textarea
                    id="address"
                    name="address"
                    rows="4"
                >{{ old('address', $customer->address) }}</textarea>
            </div>

            {{-- Save or cancel the changes. --}}
            <div class="form-actions">

                <button type="submit" class="btn-primary">
                    Update Customer
                </button>

                <a href="{{ route('customers.index') }}" class="edit-button">
                    Cancel
                </a>

            </div>

        </form>

    </div>

@endsection
