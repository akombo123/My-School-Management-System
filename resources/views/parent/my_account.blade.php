@extends('layouts.app')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">My Account</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Account</li>
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
            <div class="card-header"><div class="card-title">My Account</div></div>
            <form action="" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Profile Pic</label>
                        <input
                            name="profile_pic"
                            type="file"
                            class="form-control"
                        />
                        @if(!empty($getRecord->getProfile()))
                        <img src="{{ $getRecord->getProfile() }}" alt="Profile Pic" style="width: 100px; height: 100px; border-radius: 50%;">
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>First Name</label>
                        <input
                            name="name"
                            type="text"
                             value="{{ old('name',$getRecord->name) }}"
                            class="form-control"
                        />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Last Name</label>
                        <input
                            name="l_name"
                            type="text"
                            value="{{ old('l_name',$getRecord->l_name) }}"
                            class="form-control"
                        />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Mobile Number</label>
                        <input
                            name="mobile"
                            type="text"
                            value="{{ old('mobile',$getRecord->mobile) }}"
                            class="form-control"
                        />
                    </div>
                </div>

                <div class="mb-3">
                    <label>Email address</label>
                    <input
                        name="email"
                        type="email"
                        value="{{ old('email',$getRecord->email) }}"
                        placeholder="Enter email"
                        class="form-control"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                    />
                    <p style="color: red">{{ $errors->first('email') }}</p>
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
