<?php
namespace App\Http\Controllers;

// Request handles information submitted through forms.
use Illuminate\Http\Request;

// Rule allows us to validate a unique certificate number during updates.
use Illuminate\Validation\Rule;

// Certificate connects this controller to the certificates table.
use App\Models\Certificate;

// Customer provides the customer list for certificate forms.
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

    // Display the edit form for an existing certificate.
    public function edit(Certificate $certificate)
    {
        $customers = Customer::orderBy('name')->get();

        return view('certificates.edit', compact('certificate', 'customers'));
    }

    // Validate and update an existing certificate.
    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',

            // Ignore this certificate's own number when checking uniqueness.
            'certificate_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('certificates', 'certificate_number')
                    ->ignore($certificate->id),
            ],

            'issue_date' => 'required|date',
            'next_inspection_date' => 'required|date|after_or_equal:issue_date',
            'booking_url' => 'nullable|url|max:2048',
        ]);

        $certificate->update($validated);

        return redirect()
            ->route('certificates.index')
            ->with('success', 'Certificate updated successfully!');
    }

    // Delete a certificate and its associated reminder records.
    public function destroy(Certificate $certificate)
    {
        $certificate->delete();

        return redirect()
            ->route('certificates.index')
            ->with('success', 'Certificate deleted successfully!');
    }
}
