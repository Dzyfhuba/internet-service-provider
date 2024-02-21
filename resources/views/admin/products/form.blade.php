<x-forms.input-grid col1="3" col2="6" label="Produk" name="product_name" type="product_name" value="{{ $data->product_name ?? '' }}" placeholder="Masukan nama produk..."></x-forms.input-grid>
<x-forms.textarea-grid col1="3" col2="6" label="Deskripsi" name="product_description" type="product_description" value="{{ $data->product_description ?? '' }}" placeholder="Masukan deskripsi produk..."></x-forms.input-grid>
<x-forms.input-grid col1="3" col2="6" type="number" label="Harga Beli (Rp)" name="product_price_capital" value="{{ $data->product_price_capital ?? '' }}" placeholder="Masukan harga beli..."></x-forms.input-grid>
<x-forms.input-grid col1="3" col2="6" type="number" label="Harga Jual (Rp)" name="product_price_sell" value="{{ $data->product_price_sell ?? '' }}" placeholder="Masukan harga jual..."></x-forms.input-grid>

@push('script')
<script src="{{ asset('assets/js/apps/user.js?v=' . random_string(6)) }}"></script>
@endpush
