<x-forms.select-grid col1="3" col2="6" type="number" label="Produk" name="product_id"
    options="{!!$products!!}"
    value="{{ $data->quantity ?? 0 }}" placeholder="Masukan Kuantitas..." />
<x-forms.input-grid col1="3" col2="6" type="number" label="Kuantitas" name="quantity" value="{{ $data->quantity ?? 1 }}" min="1"
    placeholder="Masukan Kuantitas..."></x-forms.input-grid>

@push('script')
<script src="{{ asset('assets/js/apps/user.js?v=' . random_string(6)) }}"></script>
@endpush
