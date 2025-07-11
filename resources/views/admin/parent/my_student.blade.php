@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Parents Student List  ({{ $getParent->name }} {{ $getParent->l_name }})</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
          </ol>
        </div>
      </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">

            <div class="card card-primary card-outline mb-4">
                <div class="card-header"><div class="card-title">Search Student</div></div>
                <form action="" method="GET">
                  @csrf
                  <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Adm No</label>
                            <input
                              name="adm_no"
                              type="text"
                              value="{{ Request::get('adm_no') }}"
                              placeholder="Enter Adm No"
                              class="form-control"
                            />
                          </div>
                        <div class="col-md-2">
                            <label>Name</label>
                            <input
                              name="name"
                              type="text"
                              value="{{ Request::get('name') }}"
                              placeholder="Enter name"
                              class="form-control"
                            />
                          </div>
                          <div class="col-md-2">
                          <label>Email address</label>
                          <input
                          name="email"
                            type="email"
                            value="{{ Request::get('email') }}"
                            placeholder="Enter email"
                            class="form-control"
                          />
                        </div>

                        <div class="col-md-2">
                            <label>Mobile</label>
                            <input
                              name="mobile"
                              type="text"
                              value="{{ Request::get('mobile') }}"
                              placeholder="Enter Mobile No"
                              class="form-control"
                            />
                          </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-info" style="margin-top: 24px">Search</button>
                            <a class="btn btn-warning ms-2" href="{{ url('admin/parent/my-student/'.$parent_id) }}" style="margin-top: 24px">Reset
                            </a>
                        </div>
                    </div>
                  </div>
                </form>
              </div>
        @if(!empty($getSearchStudent))
        <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">Student List</h3></div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Profile Pic</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Parent Name</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Email</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                 @foreach ($getSearchStudent as $value)
                 <tr class="align-middle">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if(!empty($value->getProfile()))
                            <img src="{{ $value->getProfile() }}" alt="Profile Pic" style="width: 50px; height: 50px; border-radius: 50%;">
                        @endif
                    </td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->l_name }}</td>
                    <td>{{ $value->parent_name }} {{ $value->parent_l_name }}</td>
                    <td>
                      {{ $value->gender == 'Male' ? 'Male' : 'Female' }}
                    </td>
                    <td>{{ $value->mobile }}</td>
                    <td>
                        @if($value->status == 0)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $value->email }}</td>
                    <td>
                        <a href="{{ url('admin/parent/assign_student_parent/'.$value->id.'/'.$parent_id) }}" class="btn btn-primary btn-sm">
                            </i>Assign Student
                        </a>
                    </td>
                  </tr>
                 @endforeach
                </tbody>
              </table>
            </div>
          </div>
          @endif
          <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">Parents Student List</h3></div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Profile Pic</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Email</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                 @foreach ($getRecord as $value)
                 <tr class="align-middle">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if(!empty($value->getProfile()))
                            <img src="{{ $value->getProfile() }}" alt="Profile Pic" style="width: 50px; height: 50px; border-radius: 50%;">
                        @endif
                    </td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->l_name }}</td>
                    <td>
                      {{ $value->gender == 'Male' ? 'Male' : 'Female' }}
                    </td>
                    <td>{{ $value->mobile }}</td>
                    <td>
                        @if($value->status == 0)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $value->email }}</td>
                    <td>
                        <a href="{{ url('admin/parent/assign_student_parent_delete/'.$value->id) }}" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                  </tr>
                 @endforeach
                </tbody>
              </table>
              {{-- <div class="d-flex justify-content-end mt-3">
                {{ $getRecord->links() }}
            </div> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection
