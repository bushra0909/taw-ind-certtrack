<?php

namespace App\Http\Controllers;

// Request receives information submitted through the certificate form.
use Illuminate\Http\Request;

// Certificate connects this controller to the certificates table.
use App\Models\Certificate;

// Customer lets us retrieve customers for the dropdown.
use App\Models\Customer;

class CertificateController extends Controller
{
    // Display all certificates with their customer information.
    public function index()
    {
        $certificates = Certificate::with('customer')->latest()->get();

        return view('certificates.index', compact('certificates'));
    }

    // Display the certificate registration form.
    public function create()
    {
        $customers = Customer::orderBy('name')->get();

        return view('certificates.create', compact('customers'));
    }

    // Validate and save a new certificate.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'certificate_number' => 'required|string|max:255|unique:certificates,certificate_number',
            'issue_date' => 'required|date',
            'next_inspection_date' => 'required|date|after_or_equal:issue_date',
            'booking_url' => 'nullable|url|max:2048',
        ]);

        Certificate::create($validated);

        return redirect()
            ->route('certificates.index')
            ->with('success', 'Certificate registered successfully!');
    }
}