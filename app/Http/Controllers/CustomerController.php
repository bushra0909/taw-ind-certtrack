<?php
namespace App\Http\Controllers;

// Request handles information submitted through forms.
use Illuminate\Http\Request;

// Customer communicates with the customers database table.
use App\Models\Customer;

class CustomerController extends Controller
{
    // Display active and archived customers.
    public function index()
    {
        $customers = Customer::withCount('certificates')->latest()->get();

        return view('customers.index', compact('customers'));
    }

    // Save a new customer.
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

    // Display the customer edit form.
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    // Update an existing customer.
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        $customer->update($validated);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer updated successfully!');
    }

    // Archive a customer without deleting their certificates.
    public function archive(Customer $customer)
    {
        $customer->update(['is_active' => false]);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer archived successfully!');
    }

    // Restore an archived customer.
    public function restore(Customer $customer)
    {
        $customer->update(['is_active' => true]);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer restored successfully!');
    }

    // Delete only customers that have no certificates linked to them.
    public function destroy(Customer $customer)
    {
        if ($customer->certificates()->exists()) {
            return redirect()
                ->route('customers.index')
                ->with('error', 'This customer has certificates. Archive the customer instead to preserve certificate history.');
        }

        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer deleted successfully!');
    }
}
