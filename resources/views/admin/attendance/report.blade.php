@extends('layouts.app')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Student Attendance Report</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Student Attendance Report</li>
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
                <div class="card-header"><div class="card-title">Search Student Attendance Report</div></div>
                <form action="" method="GET">
                  @csrf
                  <div class="card-body">
                    <div class="row">
                          <div class="col-md-3">
                            <label>Class Name</label>
                            <select name="class_id" id="" class="form-control">
                                <option value="">--Select Class</option>
                                @foreach($getClass as $class)
                                <option id="getClass" value="{{ $class->id }}" {{ Request::get('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="col-md-3">
                            <label>Attendance Date</label>
                           <input id="getAttendance" type="date" name="attendance_date" value="{{  Request::get('attendance_date') }}" class="form-control">
                          </div>
                          <div class="col-md-3">
                            <label>Attendance Type</label>
                            <select name="attendance_type" id="" class="form-control">
                                <option value="">--Type--</option>
                                <option {{ Request::get('attendance_type') == 1 ? 'selected' : '' }} value="1">Present</option>
                                <option {{ Request::get('attendance_type') == 2 ? 'selected' : '' }} value="2">Late</option>
                                <option {{ Request::get('attendance_type') == 3 ? 'selected' : '' }} value="3">Absent</option>
                                <option {{ Request::get('attendance_type') == 4 ? 'selected' : '' }} value="4">Half Day</option>
                            </select>
                          </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-info" style="margin-top: 24px">Submit</button>
                            <a class="btn btn-warning ms-2" href="{{ url('admin/attendance/report') }}" style="margin-top: 24px">Reset
                            </a>
                        </div>
                    </div>
                  </div>
                </form>
              </div>

          <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">Student Attendance Report</h3>
                <form action="{{ url('admin/attendance/export-report') }}" method="POST" style="float: right">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ Request::get('class_id') }}">
                    <input type="hidden" name="attendance_type" value="{{ Request::get('attendance_type') }}">
                    <input type="hidden" name="attendance_date" value="{{ Request::get('attendance_date') }}">
                    <button type="submit" class="btn btn-primary">Export</button>
                </form>
            </div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Class Name</th>
                    <th>Attendance Type</th>
                    <th>Attendance Date</th>
                    <th>Created Date</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse($getRecord as $student)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $student->student_name }} {{ $student->student_l_name }}</td>
                        <td>{{ $student->class_name }}</td>
                        <td>
                            @if($student->attendance_type == 1)
                            <span class="badge bg-success">Present</span>
                            @elseif($student->attendance_type == 2)
                            <span class="badge bg-warning">Late</span>
                            @elseif($student->attendance_type == 3)
                            <span class="badge bg-danger">Absent</span>
                            @elseif($student->attendance_type == 4)
                            <span class="badge bg-info">Half Day</span>
                            @endif
                        </td>
                        <td>{{ date('d-m-Y',strtotime($student->attendance_date)) }}</td>
                        <td>{{ date('d-m-Y H:i A',strtotime($student->created_at)) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No Records Found</td>
                    </tr>
                    @endforelse
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
<script>
</script>
@endsection
