@extends('layouts.app')

@section('title', 'Customers | CertTrack')
@section('page-heading', 'Customer Management')

@section('content')

<div class="page-actions">
    <div>
        <h2>Registered Customers</h2>
        <p>Manage your customers and their certificate records.</p>
        <p>Total records: {{ $customers->count() }}</p>
    </div>

    <a href="{{ route('customers.create') }}" class="add-button">
        + Register Customer
    </a>
</div>

<div class="card">

    <input
        type="search"
        id="tableSearch"
        placeholder="Search customers..."
        aria-label="Search customers"
    >

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->email ?? 'Not provided' }}</td>
                        <td>{{ $customer->address ?? 'Not provided' }}</td>

                        <td>
                            @if ($customer->is_active)
                                <span class="active">Active</span>
                            @else
                                <span class="archived">Archived</span>
                            @endif
                        </td>

                        <td>
                            <div class="actions">

                                <a
                                    href="{{ route('customers.edit', $customer) }}"
                                    class="edit-button"
                                >Edit</a>

                                @if ($customer->is_active)
                                    <form
                                        action="{{ route('customers.archive', $customer) }}"
                                        method="POST"
                                        data-confirm="Archive this customer? Their certificates will be preserved."
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button class="archive-button" type="submit">
                                            Archive
                                        </button>
                                    </form>
                                @else
                                    <form
                                        action="{{ route('customers.restore', $customer) }}"
                                        method="POST"
                                        data-confirm="Restore this customer?"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button class="edit-button" type="submit">
                                            Restore
                                        </button>
                                    </form>
                                @endif

                                @if ($customer->certificates_count === 0)
                                    <form
                                        action="{{ route('customers.destroy', $customer) }}"
                                        method="POST"
                                        data-confirm="Permanently delete this customer? This action cannot be undone."
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button class="delete-button" type="submit">Delete</button>
                                    </form>
                                @endif

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No customers registered yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection