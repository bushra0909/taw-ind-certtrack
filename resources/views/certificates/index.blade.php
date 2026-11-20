{{-- Reuse the shared CertTrack dashboard layout. --}}
@extends('layouts.app')

@section('title', 'Certificates | CertTrack')
@section('page-heading', 'Certificate Management')
@section('page-subtitle', 'Manage inspection certificates and monitor upcoming renewals.')

@section('content')
<div class="page-actions">
    <div>
        <h2>Registered Certificates</h2>
        <p>Total records: {{ $certificates->count() }}</p>
    </div>
    <a href="{{ route('certificates.create') }}" class="add-button">+ Register Certificate</a>
</div>

<div class="card">
    <input type="search" id="tableSearch" placeholder="Search certificates..." aria-label="Search certificates">

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Certificate Number</th>
                    <th>Customer</th>
                    <th>Issue Date</th>
                    <th>Next Inspection</th>
                    <th>Renewal Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($certificates as $certificate)
                    @php($renewalStatus = $certificate->renewalStatus())
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $certificate->certificate_number }}</td>
                        <td>{{ $certificate->customer?->name ?? 'Customer unavailable' }}</td>
                        <td>{{ $certificate->issue_date->format('d M Y') }}</td>
                        <td>{{ $certificate->next_inspection_date->format('d M Y') }}</td>
                        <td>
                            @if ($renewalStatus === 'Overdue')
                                <span class="status status-danger">Overdue</span>
                            @elseif ($renewalStatus === 'Due Soon')
                                <span class="status status-warning">Due Soon</span>
                            @else
                                <span class="status status-success">Up to Date</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('certificates.edit', $certificate) }}" class="edit-button">Edit</a>
                                <form action="{{ route('certificates.destroy', $certificate) }}" method="POST" data-confirm="Delete this certificate and its reminder records? This cannot be undone.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7">No certificates registered yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
