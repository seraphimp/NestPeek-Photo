@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Add Team Member - {{ $studio->name }}</h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($availableCreators->isEmpty())
                    <div class="alert alert-info">
                        <h5>No available creators to add</h5>
                        <p>All creator profiles are already members of this studio.</p>
                        <a href="{{ route('studios.members.index', $studio) }}" class="btn btn-secondary mt-2">Back to Team</a>
                    </div>
                    @else
                    <form action="{{ route('studios.members.store', $studio) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="creator_id" class="form-label">Select Creator *</label>
                            <select class="form-select @error('creator_id') is-invalid @enderror"
                                id="creator_id" name="creator_id" required>
                                <option value="">Select a creator...</option>
                                @foreach($availableCreators as $creator)
                                <option value="{{ $creator->id }}" {{ old('creator_id') == $creator->id ? 'selected' : '' }}>
                                    {{ $creator->user->name ?? 'Creator #'.$creator->id }}
                                    @if($creator->brand_name)
                                    ({{ $creator->brand_name }})
                                    @endif
                                </option>
                                @endforeach
                            </select>
                            @error('creator_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select @error('role') is-invalid @enderror"
                                id="role" name="role">
                                <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member</option>
                                <option value="lead" {{ old('role') == 'lead' ? 'selected' : '' }}>Lead</option>
                                <option value="assistant" {{ old('role') == 'assistant' ? 'selected' : '' }}>Assistant</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Add Member</button>
                            <a href="{{ route('studios.members.index', $studio) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection