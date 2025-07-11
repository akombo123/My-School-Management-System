@extends('layouts.app')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Edit Marks Grade</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Marks Grade</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="app-content">
    <div class="container-fluid">
      <div class="row g-4">
        <div class="col-md-12">
          <div class="card card-primary card-outline mb-4">
            <div class="card-header"><div class="card-title">Edit Marks Grade</div></div>
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
                    <label>Percent From</label>
                    <input
                      name="percent_from"
                      type="number"
                      value="{{ old('percent_to',$getRecord->percent_from) }}"
                      class="form-control"
                    />
                  </div>

                  <div class="mb-3">
                    <label>Percent To</label>
                    <input
                      name="percent_to"
                      type="number"
                      value="{{ old('percent_to',$getRecord->percent_to) }}"
                      class="form-control"
                    />
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
