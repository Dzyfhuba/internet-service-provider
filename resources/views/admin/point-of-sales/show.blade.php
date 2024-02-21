@extends('layouts.admin.app')

@section('content')

  <div class="card">
    <div class="card-body">

      <a href="{{ route('app.products.edit', $data->id) }}" class="btn btn-info btn-sm mb-3">Edit</a>
      <button class='btn btn-danger btn-sm mb-3' type='button' onclick="CORE.promptDeleteFetchRoute('{{$data->id}}', 'Yakin ingin menghapus data ini?')">Hapus</button>

      <div class="row">
        <div class="col-md-6">
          <table class="table">
            <tr>
              <th>Nama Produk</th>
              <td>: {{ $data->product_name }}</td>
            </tr>
            <tr>
              <th>Deskripsi Produk</th>
              <td>: {{ $data->product_description }}</td>
            </tr>
          </table>
        </div>
        <div class="col-md-6">
          <table class="table">
            <tr>
              <th>Harga Beli</th>
              <td>: @rupiah($data->product_price_capital)</td>
            </tr>
            <tr>
              <th>Harga Jual</th>
              <td>: @rupiah($data->product_price_sell)</td>
            </tr>
          </table>
        </div>
      </div>

    </div>
  </div>

@endsection
