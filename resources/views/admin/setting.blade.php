@extends('layouts.app')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Setting</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Setting</li>
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
          <div class="card-header">
            <div class="card-title">Setting</div>
          </div>
          <form action="" method="POST">
            @csrf
            <div class="card-body">
              <div class="mb-3">
                <label>PayPal Business Email</label>
                <input name="paypal_email" value="{{ $getRecord->paypal_email }}" type="text" class="form-control" />
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
