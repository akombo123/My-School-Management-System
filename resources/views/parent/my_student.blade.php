@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">My Student List  </h3></div>
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
          <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">My Student List</h3></div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Profile Pic</th>
                    <th>Adm No</th>
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
                    <td>{{ $value->adm_no }}</td>
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
                    <td style="width: 100%">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ url('parent/my-student/subject/'.$value->id) }}" class="btn btn-primary btn-sm">
                                Subjects
                            </a>
                            <a href="{{ url('parent/my-student/my-exam-timetable/'.$value->id) }}" class="btn btn-info btn-sm">
                                Exam Schedule
                            </a>
                            <a href="{{ url('parent/my-student/my-exam-result/'.$value->id) }}" class="btn btn-danger btn-sm">
                                Exam Results
                            </a>
                            <a href="{{ url('parent/my-student/attendance/'.$value->id) }}" class="btn btn-dark btn-sm">
                                Attendance
                            </a>
                            <a href="{{ url('parent/my-student/homework/'.$value->id) }}" class="btn btn-secondary btn-sm">
                                Homework
                            </a>
                            <a href="{{ url('parent/my-student/homework-submitted/'.$value->id) }}" class="btn btn-secondary btn-sm">
                                Submitted Homework
                            </a>
                            <a href="{{ url('parent/my-student/my-calender/'.$value->id) }}" class="btn btn-warning btn-sm">
                                Calendar
                            </a>
                            <a href="{{ url('parent/my-student/fee-collection/'.$value->id) }}" class="btn btn-primary btn-sm">
                                Fee Collection
                            </a>
                        </div>
                    </td>
                  </tr>
                 @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection
