<div class="col-md-6">
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    <select name="{{ $name }}"
            id="{{ $name }}"
            class="tom-select-ajax @error($name) is-invalid-custom @enderror"
            data-url="{{ route('admin.users.search') }}?role={{ $roleName }}"
            data-label="full_name"
            data-search="full_name">

        @if($selectedUser)
            <option value="{{ $selectedUser->id }}" selected>
                {{ $selectedUser->first_name }} {{ $selectedUser->last_name }}
            </option>
        @else
            <option value="">Select {{ $roleName ?? 'user' }}</option>
        @endif
    </select>

    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
