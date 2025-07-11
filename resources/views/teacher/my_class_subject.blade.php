@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Classes & Subjects</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Classes & Subjects</li>
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
            <div class="card-header"><h3 class="card-title">My Classes & Subjects</h3></div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Class Name</th>
                    <th>Subject Name</th>
                    <th>Subject Type</th>
                    <th>Today's TimeTable</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                 @foreach ($getRecord as $value)
                 <tr class="align-middle">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $value->class_name }}</td>
                    <td>{{ $value->subject_name }}</td>
                    <td>
                    @if($value->subject_type == 1)
                        Practical
                    @else
                        Theory
                    @endif
                    <td>
                        @php
                            $classSubject = $value->getTimeTable($value->class_id,$value->subject_id)
                        @endphp
                        @if(!empty($classSubject))
                         {{ date('h:i A',strtotime($classSubject->start_time)) }} to {{ date('h:i A',strtotime($classSubject->end_time)) }}
                         <br>
                          ROOM : {{ $classSubject->room_number }}
                        @endif
                    </td>
                  </td>
                    <td>
                        <a href="{{ url('teacher/my-class-subject/my-timetable/'.$value->class_id.'/'.$value->subject_id) }}" class="btn btn-primary btn-sm">
                        Timetable
                        </a>
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
