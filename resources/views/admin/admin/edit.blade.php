@extends('layouts.app')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">General Form</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">General Form</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="app-content">
    <div class="container-fluid">
      <div class="row g-4">
        <div class="col-12  d-flex justify-content-end">
            <a class="btn btn-primary" href="{{ url('admin/admin/add') }}" >
                <i class="bi bi-plus"></i> Edit User
            </a>
        </div>
        <div class="col-md-12">
          <div class="card card-primary card-outline mb-4">
            <div class="card-header"><div class="card-title">Edit User</div></div>
            <form action="" method="POST">
              @csrf
              <div class="card-body">
                <div class="mb-3">
                    <label>Name</label>
                    <input
                      name="name"
                      type="text"
                      value="{{ old('name',$getRecord->name) }}"
                      class="form-control"
                    />
                  </div>
                <div class="mb-3">
                  <label>Email address</label>
                  <input
                  name="email"
                    type="email"
                    value="{{ old('email',$getRecord->email) }}"
                    class="form-control"
                    id="exampleInputEmail1"
                    aria-describedby="emailHelp"
                  />
                  <p style="color: red">{{ $errors->first('email') }}</p>
                </div>
                <div class="mb-3">
                  <label>Password</label>
                  <input type="text" class="form-control" name="password"/>
                  <p>If no changes leave blank</p>
                </div>
              </div>

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
