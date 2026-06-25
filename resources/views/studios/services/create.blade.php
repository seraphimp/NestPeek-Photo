@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Add New Service - {{ $studio->name }}</h1>

    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('studios.services.store', $studio) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Service Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Category *</label>
                    <select class="form-control @error('category') is-invalid @enderror"
                        id="category" name="category" required>
                        <option value="">Select a category...</option>
                        <option value="wedding_package" {{ old('category') == 'wedding_package' ? 'selected' : '' }}>Wedding Package</option>
                        <option value="portrait_session" {{ old('category') == 'portrait_session' ? 'selected' : '' }}>Portrait Session</option>
                        <option value="event_coverage" {{ old('category') == 'event_coverage' ? 'selected' : '' }}>Event Coverage</option>
                        <option value="video_production" {{ old('category') == 'video_production' ? 'selected' : '' }}>Video Production</option>
                        <option value="photo_editing" {{ old('category') == 'photo_editing' ? 'selected' : '' }}>Photo Editing</option>
                        <option value="studio_rental" {{ old('category') == 'studio_rental' ? 'selected' : '' }}>Studio Rental</option>
                        <option value="coordination" {{ old('category') == 'coordination' ? 'selected' : '' }}>Coordination</option>
                        <option value="add_on" {{ old('category') == 'add_on' ? 'selected' : '' }}>Add-on Service</option>
                        <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                        id="description" name="description" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Price (₱) *</label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                            id="price" name="price" value="{{ old('price') }}" placeholder="0.00" required>
                        @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="duration_hours" class="form-label">Duration (hours)</label>
                        <input type="number" class="form-control @error('duration_hours') is-invalid @enderror"
                            id="duration_hours" name="duration_hours" value="{{ old('duration_hours') }}" placeholder="2">
                        @error('duration_hours')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="requires_deposit" name="requires_deposit" value="1"
                            {{ old('requires_deposit') ? 'checked' : '' }}>
                        <label class="form-check-label" for="requires_deposit">Requires Deposit</label>
                    </div>
                </div>

                <div class="mb-3" id="deposit_amount_div" style="{{ old('requires_deposit') ? '' : 'display:none' }}">
                    <label for="deposit_amount" class="form-label">Deposit Amount (₱)</label>
                    <input type="number" step="0.01" class="form-control @error('deposit_amount') is-invalid @enderror"
                        id="deposit_amount" name="deposit_amount" value="{{ old('deposit_amount') }}" placeholder="0.00">
                    @error('deposit_amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Add Service</button>
                    <a href="{{ route('studios.services.index', $studio) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('requires_deposit').addEventListener('change', function() {
        const depositDiv = document.getElementById('deposit_amount_div');
        if (this.checked) {
            depositDiv.style.display = 'block';
        } else {
            depositDiv.style.display = 'none';
        }
    });
</script>
@endpush
@endsection