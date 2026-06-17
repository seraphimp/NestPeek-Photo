@extends('layouts.app')
@section('title', 'Edit Profile — NestPeek Photo')
@section('content')
<div style="max-width:900px;margin:0 auto;padding:40px 24px">
    <div class="page-header">
        <div class="eyebrow">Creator Settings</div>
        <h1 class="page-title">Edit Your Profile</h1>
        <p class="page-subtitle">Keep your profile updated to attract more bookings.</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success">✓ {{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('creators.update') }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        {{-- Section: Basic Info --}}
        <div class="card card-body" style="margin-bottom:24px">
            <h2 style="font-family:'Cormorant Garamond',serif;font-size:1.3rem;color:var(--text);margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border)">Basic Information</h2>

            {{-- Avatar & Cover --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px">
                <div class="form-group" style="margin:0">
                    <label class="form-label">Profile Photo</label>
                    <div style="display:flex;align-items:center;gap:14px;margin-top:8px">
                        <img src="{{ auth()->user()->avatar_url }}" class="avatar avatar-lg" id="avatar-preview">
                        <div>
                            <input type="file" name="avatar" id="avatar-input" accept="image/*" style="display:none" onchange="previewImage(this,'avatar-preview')">
                            <button type="button" onclick="document.getElementById('avatar-input').click()" class="btn btn-ghost btn-sm">Change Photo</button>
                            <div style="font-size:0.75rem;color:var(--text3);margin-top:4px">JPG, PNG — max 5MB</div>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="margin:0">
                    <label class="form-label">Cover Photo</label>
                    <div style="height:80px;border-radius:var(--radius-sm);overflow:hidden;background:var(--bg3);position:relative;margin-top:8px;cursor:pointer" onclick="document.getElementById('cover-input').click()">
                        @if($profile->cover_photo)
                        <img src="{{ Storage::url($profile->cover_photo) }}" id="cover-preview" style="width:100%;height:100%;object-fit:cover">
                        @else
                        <div id="cover-preview" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:0.8rem;color:var(--text3)">Click to upload cover</div>
                        @endif
                        <input type="file" name="cover_photo" id="cover-input" accept="image/*" style="display:none" onchange="previewImage(this,'cover-preview')">
                    </div>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div class="form-group">
                    <label class="form-label">Brand / Studio Name</label>
                    <input type="text" name="brand_name" class="form-input" placeholder="e.g. Luna Studios" value="{{ old('brand_name', $profile->brand_name) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Tagline</label>
                    <input type="text" name="tagline" class="form-input" placeholder="A short catchy description" value="{{ old('tagline', $profile->tagline) }}">
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div class="form-group">
                    <label class="form-label">Specialization <span style="color:var(--red)">*</span></label>
                    <select name="specialization" class="form-input" required>
                        @foreach(['wedding_photographer'=>'Wedding Photographer','wedding_videographer'=>'Wedding Videographer','portrait_photographer'=>'Portrait Photographer','event_photographer'=>'Event Photographer','event_videographer'=>'Event Videographer','wedding_coordinator'=>'Wedding Coordinator','photo_editor'=>'Photo Editor','video_editor'=>'Video Editor','drone_operator'=>'Drone Operator','photo_booth'=>'Photo Booth'] as $val=>$label)
                        <option value="{{ $val }}" {{ old('specialization',$profile->specialization) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-input" placeholder="City, Province" value="{{ old('location', auth()->user()->location) }}">
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div class="form-group">
                    <label class="form-label">Years of Experience</label>
                    <input type="number" name="years_experience" class="form-input" min="0" max="50" placeholder="0" value="{{ old('years_experience', $profile->years_experience) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Starting Price (₱)</label>
                    <input type="number" name="starting_price" class="form-input" min="0" step="100" placeholder="5000" value="{{ old('starting_price', $profile->starting_price) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Bio</label>
                <textarea name="bio" class="form-input" rows="5" placeholder="Tell clients about your style, experience, and what makes you unique...">{{ old('bio', auth()->user()->bio) }}</textarea>
            </div>

            <div class="form-group" style="margin:0">
                <label class="form-label">Availability Note</label>
                <input type="text" name="availability_note" class="form-input" placeholder="e.g. Available on weekends, 6 months advance booking" value="{{ old('availability_note', $profile->availability_note) }}">
            </div>
        </div>

        {{-- Section: Tags --}}
        <div class="card card-body" style="margin-bottom:24px" id="services">
            <h2 style="font-family:'Cormorant Garamond',serif;font-size:1.3rem;color:var(--text);margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border)">Skills, Equipment & Style</h2>

            <div class="form-group">
                <label class="form-label">Skills (comma separated)</label>
                <input type="text" name="skills_input" class="form-input" placeholder="e.g. Portrait, Candid, Editing, Drone" value="{{ old('skills_input', is_array($profile->skills) ? implode(', ', $profile->skills) : '') }}" oninput="updateArrayField(this, 'skills')">
                <input type="hidden" name="skills" id="skills-hidden" value="{{ old('skills_input', is_array($profile->skills) ? implode(',', $profile->skills) : '') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Equipment (comma separated)</label>
                <input type="text" name="equipment_input" class="form-input" placeholder="e.g. Sony A7IV, Canon RF, DJI Mini 3" value="{{ is_array($profile->equipment) ? implode(', ', $profile->equipment) : '' }}" oninput="updateArrayField(this, 'equipment')">
                <input type="hidden" name="equipment" id="equipment-hidden" value="{{ is_array($profile->equipment) ? implode(',', $profile->equipment) : '' }}">
            </div>

            <div class="form-group">
                <label class="form-label">Photography Styles</label>
                <input type="text" name="styles_input" class="form-input" placeholder="e.g. Documentary, Fine Art, Romantic" value="{{ is_array($profile->styles) ? implode(', ', $profile->styles) : '' }}" oninput="updateArrayField(this, 'styles')">
                <input type="hidden" name="styles" id="styles-hidden" value="{{ is_array($profile->styles) ? implode(',', $profile->styles) : '' }}">
            </div>

            <div class="form-group" style="margin:0">
                <label class="form-label">Service Areas</label>
                <input type="text" name="service_areas_input" class="form-input" placeholder="e.g. Iloilo City, Bacolod, Cebu" value="{{ is_array($profile->service_areas) ? implode(', ', $profile->service_areas) : '' }}" oninput="updateArrayField(this, 'service_areas')">
                <input type="hidden" name="service_areas" id="service_areas-hidden" value="{{ is_array($profile->service_areas) ? implode(',', $profile->service_areas) : '' }}">
            </div>
        </div>

        {{-- Social Links --}}
        <div class="card card-body" style="margin-bottom:24px">
            <h2 style="font-family:'Cormorant Garamond',serif;font-size:1.3rem;color:var(--text);margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border)">Social Links</h2>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px">
                <div class="form-group" style="margin:0">
                    <label class="form-label">Instagram</label>
                    <input type="text" name="instagram" class="form-input" placeholder="@username" value="{{ old('instagram', auth()->user()->instagram) }}">
                </div>
                <div class="form-group" style="margin:0">
                    <label class="form-label">Facebook</label>
                    <input type="text" name="facebook" class="form-input" placeholder="Page URL" value="{{ old('facebook', auth()->user()->facebook) }}">
                </div>
                <div class="form-group" style="margin:0">
                    <label class="form-label">Website</label>
                    <input type="text" name="website" class="form-input" placeholder="https://yoursite.com" value="{{ old('website', auth()->user()->website) }}">
                </div>
            </div>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:12px">
            <a href="{{ route('dashboard') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewImage(input, previewId) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const el = document.getElementById(previewId);
            if (el.tagName === 'IMG') {
                el.src = e.target.result;
            } else {
                el.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover">`;
            }
        };
        reader.readAsDataURL(file);
    }

    function updateArrayField(input, field) {
        const values = input.value.split(',').map(v => v.trim()).filter(Boolean);
        document.getElementById(field + '-hidden').value = values.join(',');
    }
</script>
@endpush
@endsection