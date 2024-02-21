@extends('layouts.admin.app')

@section('content')

<div class="card">
    <div class="card-body table-responsive">

        @if (check_authorized("003U"))
        <a href="{{ route('app.point-of-sales.create') }}" class="btn btn-success btn-sm mb-3">Tambah</a>
        @endif

        @if (check_authorized("003U"))
        <table class="table table-bordered" id="table1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Product</th>
                    <th>Kuantitas</th>
                    <th>Capital Price Total</th>
                    <th>Sell Price Total</th>
                    <th>Laba</th>
                    <th>Tanggal Transaksi</th>
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
    CORE.dataTableServer("table1", "/app/point-of-sales/get");
</script>
@endpush
@endif
