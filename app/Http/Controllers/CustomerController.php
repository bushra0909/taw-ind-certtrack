<?php

namespace App\Http\Controllers;

// Request receives information submitted through the form.
use Illuminate\Http\Request;

// Customer connects this controller to the customers database table.
use App\Models\Customer;

class CustomerController extends Controller
{
    // Display all registered customers.
    public function index()
    {
        $customers = Customer::latest()->get();

        return view('customers.index', compact('customers'));
    }

    // Validate and save a new customer.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        Customer::create($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer registered successfully!');
    }
}