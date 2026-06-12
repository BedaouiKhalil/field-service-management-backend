<div class="col-md-6">
    @if ($showLabel)
        <label for="customer_id" class="form-label">Customer</label>
    @endif

    <select name="customer_id"
            id="customer_id"
            class="tom-select-ajax @error('customer_id') is-invalid-custom @enderror"
            data-url="{{ route('admin.customers.search') }}"
            data-label="name"
            data-search="name">

        @if($selectedCustomer)
            <option value="{{ $selectedCustomer->id }}" selected>{{ $selectedCustomer->name }}</option>
        @else
            <option value="">Select customer</option>
        @endif
    </select>

    @error('customer_id')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
