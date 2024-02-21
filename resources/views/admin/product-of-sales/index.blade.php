@extends('layouts.admin.app')

@section('content')

<div class="card">
    <div class="card-body table-responsive">

        @if (check_authorized("003U"))
        <a href="{{ route('app.product-of-sales.create') }}" class="btn btn-success btn-sm mb-3">Tambah</a>
        @endif

        @if (check_authorized("003U"))
        <table class="table table-bordered" id="table1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Capital Price</th>
                    <th>Sell Price</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        @endif

    </div>
</div>

@endsection

@if (check_authorized("003U"))
@push('script')
<script>
    CORE.dataTableServer("table1", "/app/product-of-sales/get");
</script>
@endpush
@endif
