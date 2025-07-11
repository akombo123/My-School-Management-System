@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">My Exam Timetable</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Exam Timetable</li>
          </ol>
        </div>
      </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">

            @foreach ($getRecord as $value)
              <div class="card mb-4">
                <div class="card-header"><h3 class="card-title">{{ $value['exam_name'] }}</h3></div>
                <div class="card-body">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Subject Name</th>
                        <th>Exam Date</th>
                        <th>Day</th>
                        <th>Starting Time</th>
                        <th>End Time</th>
                        <th>Room Number</th>
                        <th>Full Marks</th>
                        <th>Passing Marks</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($value['exam'] as $valueW)
                            <tr>
                                <td>{{ $valueW['subject_name']  }}</td>
                                <td>{{ !empty($valueW['exam_date']) ? date('d-m-Y',strtotime($valueW['exam_date'] )) : '' }}</td>
                                <td>{{ !empty($valueW['exam_date']) ? date('l',strtotime($valueW['exam_date'] )) : '' }}</td>
                                <td>{{ !empty($valueW['start_time']) ? date('h:i A',strtotime($valueW['start_time'] )) : '' }}</td>
                                <td>{{ !empty($valueW['end_time']) ? date('h:i A',strtotime($valueW['end_time'] )) : '' }}</td>
                                <td>{{ $valueW['room_number']  }}</td>
                                <td>{{ $valueW['full_marks'] }}</td>
                                <td>{{ $valueW['passing_marks'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            @endforeach
        </div>
      </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
@endsection
