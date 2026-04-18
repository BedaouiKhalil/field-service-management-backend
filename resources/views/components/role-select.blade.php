<div class="col-md-6">
    <label for="role" class="form-label">Role</label>

    <select name="role" id="role"
        class="form-control @error('role') is-invalid @enderror">

        <option value="">Select role</option>

        @foreach ($roles as $role)
            <option value="{{ $role->name }}"
                {{ old('role', $selected ?? null) == $role->name ? 'selected' : '' }}>
                {{ \App\Constants\Roles::label($role->name) }}
            </option>
        @endforeach
    </select>

    @error('role')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
