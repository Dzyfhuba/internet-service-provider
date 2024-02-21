@extends('layouts.admin.app')

@section('content')

  <div class="card">
    <div class="card-body">

      <form action="{{ route('app.point-of-sales.store') }}" method="POST" with-submit-crud>
        @csrf

        @include('admin.point-of-sales.form')

        <button class="btn btn-success btn-sm mt-3">Tambah Penjualan Produk</button>

      </form>

    </div>
  </div>

@endsection
