@extends('layouts.admin.app')

@section('content')

  <div class="card">
    <div class="card-body">

      <a href="{{ route('app.users.edit', $data->id) }}" class="btn btn-info btn-sm mb-3">Edit</a>

      <div class="row">
        <div class="col-md-6">
          <table class="table">
            <tr>
              <th>Nama</th>
              <td>: {{ $data->name }}</td>
            </tr>
            <tr>
              <th>Email</th>
              <td>: {{ $data->email }}</td>
            </tr>
          </table>
        </div>
        <div class="col-md-6">
          <table class="table">
            <tr>
              <th>Username</th>
              <td>: {{ $data->username }}</td>
            </tr>
            <tr>
              <th>Jabatan</th>
              <td>: {{ $data->role->role_name }}</td>
            </tr>
          </table>
        </div>
      </div>

    </div>
  </div>

@endsection
