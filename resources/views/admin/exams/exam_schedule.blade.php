@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Exam Schedule</h3></div>
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
                <div class="card-header"><div class="card-title">Search Exam Schedule</div></div>
                <form action="" method="GET">
                  @csrf
                  <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Exam Name</label>
                            <select name="exam_id" id="" class="form-control">
                                <option value="">--Select Exam</option>
                                @foreach($getExam as $exam)
                                <option value="{{ $exam->id }}" {{ Request::get('exam_id') == $exam->id ? 'selected' : '' }}>{{ $exam->name }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="col-md-3">
                            <label>Class Name</label>
                            <select name="class_id" id="" class="form-control">
                                <option value="">--Select Class</option>
                                @foreach($getClass as $class)
                                <option value="{{ $class->id }}" {{ Request::get('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                @endforeach
                            </select>
                          </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-info" style="margin-top: 24px">Submit</button>
                            <a class="btn btn-warning ms-2" href="{{ url('admin/exams/list') }}" style="margin-top: 24px">Reset
                            </a>
                        </div>
                    </div>
                  </div>
                </form>
              </div>
        @if(!empty($getRecord))
        <form action="{{ url('admin/exams/exam_schedule_insert') }}" method="POST">
            @csrf
            <input type="hidden" name="exam_id" value="{{ Request::get('exam_id') }}">
            <input type="hidden" name="class_id" value="{{ Request::get('class_id') }}">
          <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">Exam List</h3></div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Subject Name</th>
                    <th>Exam Date</th>
                    <th>Starting Time</th>
                    <th>End Time</th>
                    <th>Room Number</th>
                    <th>Full Marks</th>
                    <th>Passing Marks</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $i = 1;
                 @endphp
                @foreach ($getRecord as $value)
                <tr class="align-middle">
                    <td>{{ $loop->iteration }}</td>
                    <th>
                        {{ $value['subject_name'] }}
                        <input type="hidden" name="class_timetable[{{ $i }}][subject_id]" value="{{ $value['subject_id'] }}">
                    </th>
                    <td>
                        <input type="date" class="form-control" name="class_timetable[{{ $i }}][exam_date]" value="{{ $value['exam_date'] }}"  placeholder="Start Time">
                    </td>
                    <td>
                        <input type="time" class="form-control" name="class_timetable[{{ $i }}][start_time]" value="{{ $value['start_time'] }}"  placeholder="Start Time">
                    </td>
                    <td>
                        <input type="time" class="form-control" name="class_timetable[{{ $i }}][end_time]" value="{{ $value['end_time'] }}"  placeholder="End Time">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="class_timetable[{{ $i }}][room_number]" value="{{ $value['room_number'] }}"  placeholder="Room Number">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="class_timetable[{{ $i }}][full_marks]" value="{{ $value['full_marks'] }}"  placeholder="Full Marks">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="class_timetable[{{ $i }}][passing_marks]" value="{{ $value['passing_marks'] }}"  placeholder="Passing Marks">
                    </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
                </tbody>
              </table>
            </div>
            <div style="text-align:center;padding:20px">
                <button class=" btn btn-primary">Submit</button>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection
