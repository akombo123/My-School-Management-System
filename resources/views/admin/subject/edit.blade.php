@extends('layouts.app')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Edit Class</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Class</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="app-content">
    <div class="container-fluid">
      <div class="row g-4">
        <div class="col-12  d-flex justify-content-end">
            <a class="btn btn-primary" href="{{ url('admin/class/list') }}" >
                Back
            </a>
        </div>
        <div class="col-md-12">
          <div class="card card-primary card-outline mb-4">
            <div class="card-header"><div class="card-title">Edit Class</div></div>
            <form action="" method="POST">
              @csrf
              <div class="card-body">
                <div class="mb-3">
                    <label>Name</label>
                    <input
                      name="name"
                      type="text"
                      value="{{$getRecord->name }}"
                      class="form-control"
                    />
                  </div>

                  <div class="mb-3">
                    <label>Status</label>
                   <select name="status"  class="form-control">
                    <option value="">--Select--</option>
                    <option {{ ($getRecord->status == 0) ? 'selected' :'' }} value="0">Active</option>
                    <option {{ ($getRecord->status == 1) ? 'selected' :'' }} value="1">Inactive</option>
                   </select>
                  </div>

                  <div class="mb-3">
                    <label>Type</label>
                   <select name="type"  class="form-control">
                    <option value="">--Select--</option>
                    <option {{ ($getRecord->type == 1) ? 'selected' :'' }} value="1">Practical</option>
                    <option {{ ($getRecord->type == 2) ? 'selected' :'' }} value="2">Theory</option>
                   </select>
                  </div>
              </div>

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
