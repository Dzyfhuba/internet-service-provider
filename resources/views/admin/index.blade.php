@extends('layouts.admin.app')

@push('style')
    <style>
        .x-scroll-snap {
            overflow-x: scroll;
            scroll-snap-type: x mandatory;
        }
        .x-scroll-snap > * {
            scroll-snap-align: start;
        }
        .min-w-sm {
            min-width: 300px !important;
            width: 100% !important;
        }
    </style>
@endpush
@section('content')

<div class="d-flex md gap-3 x-scroll-snap">
    <div class="card min-w-sm">
        <div class="card-header">
            <h5>Admin Aktif</h5>
        </div>
        <div class="card-body">
            <ul>
                @forelse ($admin_online as $item)
                <li>
                    <a href="{{ route('app.users.show', $item->id) }}">{{ "$item->name $item->last_active" }}</a>
                </li>
                @empty

                @endforelse
            </ul>
        </div>
    </div>

    <div class="card min-w-sm">
        <div class="card-header">
            <h5>Jumlah Produk</h5>
        </div>
        <div class="card-body">
            <span>{{$total_products}}</span>
        </div>
    </div>

    <div class="card min-w-sm">
        <div class="card-header">
            <h5>Jumlah Transaksi</h5>
        </div>
        <div class="card-body">
            <span>{{$total_transactions}}</span>
        </div>
    </div>
</div>

@endsection
