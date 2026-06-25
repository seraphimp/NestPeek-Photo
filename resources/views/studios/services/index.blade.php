@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Services - {{ $studio->name }}</h1>
        <a href="{{ route('studios.services.create', $studio) }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Service
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($services->isEmpty())
    <div class="alert alert-info">
        <h5>No services added yet</h5>
        <p>Start by adding your first service.</p>
    </div>
    @else
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Deposit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                <tr>
                    <td><strong>{{ $service->name }}</strong></td>
                    <td><span class="badge bg-info">{{ str_replace('_', ' ', ucwords($service->category)) }}</span></td>
                    <td>{{ Str::limit($service->description, 40) }}</td>
                    <td>₱{{ number_format($service->price, 2) }}</td>
                    <td>{{ $service->duration_hours ? $service->duration_hours.' hrs' : '—' }}</td>
                    <td>
                        @if($service->requires_deposit)
                        ₱{{ number_format($service->deposit_amount, 2) }}
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('studios.services.edit', [$studio, $service]) }}" class="btn btn-sm btn-warning">
                            Edit
                        </a>
                        <form action="{{ route('studios.services.destroy', [$studio, $service]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this service?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('studios.show', $studio) }}" class="btn btn-secondary">Back to Studio Dashboard</a>
    </div>
</div>
@endsection