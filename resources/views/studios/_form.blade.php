{{-- resources/views/studios/_form.blade.php --}}
{{-- Shared fields for both create and edit. Expects $studio to be set
     (an empty new Studio() on create, the existing model on edit). --}}

<div class="form-section">
    <p class="form-section-title">Basic Info</p>

    <div class="form-grid">
        <div class="form-field span-2">
            <label class="form-label">Studio Name <span class="req">*</span></label>
            <input type="text" name="name" class="form-input" value="{{ old('name', $studio->name ?? '') }}" required maxlength="255">
            @error('name')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-field span-2">
            <label class="form-label">Tagline</label>
            <input type="text" name="tagline" class="form-input" value="{{ old('tagline', $studio->tagline ?? '') }}" maxlength="120" placeholder="A short catchy line about your studio">
            @error('tagline')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-field span-2">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-input form-textarea" maxlength="2000" placeholder="Tell clients about your studio, your space, and what makes it special.">{{ old('description', $studio->description ?? '') }}</textarea>
            @error('description')<p class="form-error">{{ $message }}</p>@enderror
        </div>
    </div>
</div>

<div class="form-section">
    <p class="form-section-title">Location</p>

    <div class="form-grid">
        <div class="form-field span-2">
            <label class="form-label">Address <span class="req">*</span></label>
            <input type="text" name="address" class="form-input" value="{{ old('address', $studio->address ?? '') }}" required maxlength="500">
            @error('address')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-field">
            <label class="form-label">City <span class="req">*</span></label>
            <input type="text" name="city" class="form-input" value="{{ old('city', $studio->city ?? '') }}" required maxlength="100">
            @error('city')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-field">
            <label class="form-label">Province</label>
            <input type="text" name="province" class="form-input" value="{{ old('province', $studio->province ?? '') }}" maxlength="100">
            @error('province')<p class="form-error">{{ $message }}</p>@enderror
        </div>
    </div>
</div>

<div class="form-section">
    <p class="form-section-title">Contact</p>

    <div class="form-grid">
        <div class="form-field">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-input" value="{{ old('phone', $studio->phone ?? '') }}" maxlength="20">
            @error('phone')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-field">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-input" value="{{ old('email', $studio->email ?? '') }}" maxlength="255">
            @error('email')<p class="form-error">{{ $message }}</p>@enderror
        </div>
    </div>
</div>

<div class="form-section" id="rates">
    <p class="form-section-title">Rates (₱)</p>

    <div class="form-grid">
        <div class="form-field">
            <label class="form-label">Hourly Rate</label>
            <input type="number" step="0.01" min="0" name="hourly_rate" class="form-input" value="{{ old('hourly_rate', $studio->hourly_rate ?? '') }}">
            @error('hourly_rate')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-field">
            <label class="form-label">Half Day Rate (4 hrs)</label>
            <input type="number" step="0.01" min="0" name="half_day_rate" class="form-input" value="{{ old('half_day_rate', $studio->half_day_rate ?? '') }}">
            @error('half_day_rate')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-field">
            <label class="form-label">Full Day Rate (8 hrs)</label>
            <input type="number" step="0.01" min="0" name="full_day_rate" class="form-input" value="{{ old('full_day_rate', $studio->full_day_rate ?? '') }}">
            @error('full_day_rate')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-field">
            <label class="form-label">Max Capacity</label>
            <input type="number" min="1" name="max_capacity" class="form-input" value="{{ old('max_capacity', $studio->max_capacity ?? '') }}" placeholder="e.g. 20">
            @error('max_capacity')<p class="form-error">{{ $message }}</p>@enderror
        </div>
    </div>
</div>

<div class="form-section" id="specs">
    <p class="form-section-title">Specializations</p>

    @php
        $selectedSpecs = old('specializations', $studio->specializations ?? []);
    @endphp

    <div class="check-grid">
        @foreach([
            ['photography', '📷 Photography'],
            ['videography', '🎬 Videography'],
            ['coordination', '📋 Coordination'],
            ['makeup_hair', '💄 Makeup & Hair'],
            ['hosting_mc', '🎤 Host / MC'],
            ['music_dj', '🎵 Music / DJ'],
            ['lighting_sound', '💡 Lights & Sound'],
            ['drone', '🚁 Drone'],
        ] as [$val, $lbl])
        <label class="check-item">
            <input type="checkbox" name="specializations[]" value="{{ $val }}" {{ in_array($val, $selectedSpecs) ? 'checked' : '' }}>
            {{ $lbl }}
        </label>
        @endforeach
    </div>
</div>

<div class="form-section">
    <p class="form-section-title">Amenities</p>

    @php
        $selectedAmenities = old('amenities', $studio->amenities ?? []);
    @endphp

    <div class="check-grid">
        @foreach([
            ['parking', '🚗 Parking'],
            ['wifi', '📶 WiFi'],
            ['aircon', '❄️ Air Conditioning'],
            ['changing_room', '🚪 Changing Room'],
            ['backdrop', '🖼 Backdrops'],
            ['lighting_equipment', '💡 Lighting Equipment'],
            ['restroom', '🚻 Restroom'],
            ['waiting_area', '🛋 Waiting Area'],
        ] as [$val, $lbl])
        <label class="check-item">
            <input type="checkbox" name="amenities[]" value="{{ $val }}" {{ in_array($val, $selectedAmenities) ? 'checked' : '' }}>
            {{ $lbl }}
        </label>
        @endforeach
    </div>
</div>

<div class="form-section">
    <p class="form-section-title">Photos</p>

    <div class="form-grid">
        <div class="form-field">
            <label class="form-label">Cover Photo</label>
            <input type="file" name="cover_photo" class="form-input" accept="image/*">
            @if(!empty($studio->cover_photo))
            <p class="form-hint">Current cover photo is set. Uploading a new one will replace it.</p>
            @endif
            @error('cover_photo')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-field">
            <label class="form-label">Logo</label>
            <input type="file" name="logo" class="form-input" accept="image/*">
            @if(!empty($studio->logo))
            <p class="form-hint">Current logo is set. Uploading a new one will replace it.</p>
            @endif
            @error('logo')<p class="form-error">{{ $message }}</p>@enderror
        </div>
    </div>
</div>
