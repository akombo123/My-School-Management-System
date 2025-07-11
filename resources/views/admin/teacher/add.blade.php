@extends('layouts.app')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Add Teacher</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Teacher</li>
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
            <div class="card-header"><div class="card-title">Add Teacher</div></div>
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
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>First Name</label>
                        <input
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            class="form-control"
                        />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Last Name</label>
                        <input
                            name="l_name"
                            type="text"
                            value="{{ old('l_name') }}"
                            class="form-control"
                        />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>DOB</label>
                        <input
                            name="dob"
                            type="date"
                            value="{{ old('dob') }}"
                            class="form-control"
                        />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">--Select Gender--</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Mobile Number</label>
                        <input
                            name="mobile"
                            type="text"
                            value="{{ old('mobile') }}"
                            class="form-control"
                        />
                    </div>
                </div>

                <div class="mb-3">
                    <label>Email address</label>
                    <input
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        placeholder="Enter email"
                        class="form-control"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                    />
                    <p style="color: red">{{ $errors->first('email') }}</p>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" />
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">--Select--</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Active</option>
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Inactive</option>
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
