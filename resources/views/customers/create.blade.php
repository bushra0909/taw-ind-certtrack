
{{-- Use the shared CertTrack dashboard layout. --}}
@extends('layouts.app')

{{-- Browser tab title. --}}
@section('title', 'Register Customer | CertTrack')

{{-- Dashboard heading and description. --}}
@section('page-heading', 'Register Customer')
@section('page-subtitle', 'Add a new customer to your certificate management system.')

{{-- Main page content. --}}
@section('content')

    <div class="card">

        <h2>Customer Information</h2>

        <p>Enter the customer's details below to create a new record.</p>

        {{-- Send customer information to CustomerController. --}}
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf

            {{-- Customer full name. --}}
            <div class="form-group">
                <label for="name">Full Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Enter customer's full name"
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
                    value="{{ old('phone') }}"
                    placeholder="Enter phone number"
                    autocomplete="tel"
                    required
                >
            </div>

            {{-- Customer email address (optional). --}}
            <div class="form-group">
                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter email address"
                    autocomplete="email"
                >
            </div>

            {{-- Customer postal address (optional). --}}
            <div class="form-group">
                <label for="address">Address</label>
                <textarea
                    id="address"
                    name="address"
                    placeholder="Enter customer's address"
                >{{ old('address') }}</textarea>
            </div>

            {{-- Form actions. --}}
            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    Register Customer
                </button>

                <a href="{{ route('customers.index') }}" class="edit-button">
                    Cancel
                </a>
            </div>

        </form>

    </div>

@endsection