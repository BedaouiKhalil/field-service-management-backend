@props(['wilayas', 'selectedWilaya' => null, 'selectedCommune' => null])

<div class="col-md-6">
    <label class="form-label">Wilaya</label>
    <select name="wilaya_id" class="form-select location-wilaya @error('wilaya_id') is-invalid @enderror">
        <option value="">Select Wilaya</option>
        @foreach ($wilayas as $wilaya)
            <option value="{{ $wilaya->id }}" {{ $selectedWilaya == $wilaya->id ? 'selected' : '' }}>
                {{ $wilaya->id }} - {{ $wilaya->name }}
            </option>
        @endforeach
    </select>

    @error('wilaya_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="col-md-6">
    <label class="form-label">Commune</label>
    <select name="commune_id" class="form-select location-commune @error('commune_id') is-invalid @enderror" {{ !$selectedWilaya ? 'disabled' : '' }}>
        <option value="">Select Commune</option>
        @if($selectedWilaya && $selectedCommune)
            @foreach(App\Models\Commune::where('wilaya_id', $selectedWilaya)->get() as $commune)
                <option value="{{ $commune->id }}" {{ $commune->id == $selectedCommune ? 'selected' : '' }}>
                    {{ $commune->name }}
                </option>
            @endforeach
        @endif
    </select>

    @error('commune_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@once
    <script>
        document.addEventListener('change', function(e) {

            if (!e.target.classList.contains('location-wilaya')) return;

            const form = e.target.closest('form');
            const communeSelect = form.querySelector('.location-commune');
            const wilayaId = e.target.value;

            if (!wilayaId) {
                communeSelect.disabled = true;
                communeSelect.innerHTML = '<option value="">Select Commune</option>';
                return;
            }

            fetch(`/api/v1/wilayas/${wilayaId}/communes`)
                .then(res => res.json())
                .then(data => {

                    communeSelect.disabled = false;

                    let options = '<option value="">Select Commune</option>';
                    data.forEach(commune => {
                        options += `<option value="${commune.id}">${commune.name}</option>`;
                    });

                    communeSelect.innerHTML = options;
                });
        });
    </script>
@endonce
