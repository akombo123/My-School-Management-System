@extends('layouts.app')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Student Attendance</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Student Attendance</li>
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
                <div class="card-header"><div class="card-title">Search Student Attendance Register</div></div>
                <form action="" method="GET">
                  @csrf
                  <div class="card-body">
                    <div class="row">
                          <div class="col-md-3">
                            <label>Class Name</label>
                            <select id="getClass" name="class_id" class="form-control">
                                <option value="">--Select Class</option>
                                @foreach($getClass as $class)
                                <option value="{{ $class->id }}" {{ Request::get('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="col-md-3">
                            <label>Attendance Date</label>
                           <input id="getAttendance" type="date" name="attendance_date" value="{{  Request::get('attendance_date') }}" class="form-control">
                          </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-info" style="margin-top: 24px">Submit</button>
                            <a class="btn btn-warning ms-2" href="{{ url('admin/attendance/student') }}" style="margin-top: 24px">Reset
                            </a>
                        </div>
                    </div>
                  </div>
                </form>
              </div>
        @if(!empty(Request::get('class_id')) && !empty(Request::get('attendance_date')))
          <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">Student Attendance Register</h3></div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Attendance</th>
                  </tr>
                </thead>
                <tbody>
                    @if(!empty($getStudentClass) && count($getStudentClass) > 0)
                    @foreach($getStudentClass as $student)
                    @php
                    $attendance = '';
                    $getAttendance = $student->getAttendance(Request::get('class_id'),Request::get('attendance_date'),$student->id);
                    if(!empty($getAttendance)){
                        $attendance = $getAttendance->attendance_type;
                    }
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $student->name }} {{ $student->l_name }}</td>
                        <td>
                        <label for="" style="margin-left: 10px"><input type="radio" class="saveAttendance" name="attendance{{ $student->id }}" value="1" id="{{ $student->id }}" {{ ($attendance == 1) ? 'checked' : '' }}>Present</label>
                        <label for="" style="margin-left: 10px"><input type="radio" class="saveAttendance" name="attendance{{ $student->id }}" value="2"  id="{{ $student->id }}" {{ ($attendance == 2) ? 'checked' : '' }}>Late</label>
                        <label for="" style="margin-left: 10px"><input type="radio" class="saveAttendance" name="attendance{{ $student->id }}" value="3"  id="{{ $student->id }}" {{ ($attendance == 3) ? 'checked' : '' }}>Absent</label>
                        <label for="" style="margin-left: 10px"><input type="radio" class="saveAttendance" name="attendance{{ $student->id }}" value="4"  id="{{ $student->id }}" {{ ($attendance == 4) ? 'checked' : '' }}>Half Day</label>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
              </table>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
</div>
@endsection
@section('scripts')
<script>

$('.saveAttendance').change(function(e){
       var student_id = $(this).attr('id');
       var attendance_type = $(this).val();
       var attendance_date = $('#getAttendance').val();
       var class_id = $('#getClass').val();
         console.log(student_id, attendance_type, attendance_date, class_id);

        $.ajax({
            type: 'POST',
            url: '{{ url('admin/attendance/student/save') }}',
            data: {
                _token: '{{ csrf_token() }}',
                student_id: student_id,
                attendance_type: attendance_type,
                attendance_date: attendance_date,
                class_id: class_id,
                },
            dataType: "json",
            success: function(response) {
                alert(response.message);
            },
            error: function(xhr, status, error) {
                alert('An error occurred. Please try again.');
            }
        });
    });
</script>
@endsection
