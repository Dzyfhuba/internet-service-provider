@extends('layouts.admin.app')

@section('content')

  <div class="card">
    <div class="card-body">

      <form action="{{ route('app.products.update', $data->id) }}" method="POST" with-submit-crud>
        @csrf
        @method("PUT")

        @include('admin.products.form')

        <button class="btn btn-success btn-sm mt-3">Update Produk</button>

      </form>

    </div>
  </div>

@endsection
