@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Class Timetable</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Class Timetable</li>
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
                <div class="card-header"><div class="card-title">Search Class Timetable</div></div>
                <form action="" method="GET">
                  @csrf
                  <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Class Name</label>
                                <select name="class_id" class="form-control getClass">
                                <option value="">--Select Class--</option>
                                @foreach ($getClass as $class)
                                 <option {{ (Request::get('class_id') == $class->id ) ? 'selected' :''  }} value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                               </select>
                        </div>

                            <div class="col-md-3">
                                <label>Subject Name</label>
                                <select name="subject_id" class="form-control getSubject" id="subject_id">
                                    <option value="">--Select Subject--</option>
                                    @if(!empty($getSubject))
                                    @foreach ($getSubject as $subject)
                                    <option {{ (Request::get('subject_id') == $subject->subject_id ) ? 'selected' :''  }} value="{{ $subject->subject_id }}">{{ $subject->subject_name }}</option>
                                   @endforeach
                                   @endif
                                   </select>

                          </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-info" style="margin-top: 24px">Submit</button>
                            <a class="btn btn-warning ms-2" href="{{ url('admin/class_timetable/list') }}" style="margin-top: 24px">Reset
                            </a>
                        </div>
                    </div>
                  </div>
                </form>
              </div>
              @if(!empty(Request::get('class_id')) && !empty(Request::get('subject_id')))
              <form action="{{ url('admin/class_timetable/add') }}" method="POST">
                @csrf
                <input type="hidden" name="class_id" value="{{ Request::get('class_id') }}">
                <input type="hidden" name="subject_id" value="{{ Request::get('subject_id') }}">
                <input type="hidden" name="id" value="{{ $week[0]['id'] }}">
              <div class="card mb-4">
                <div class="card-header"><h3 class="card-title">Class Timetable</h3></div>
                <div class="card-body">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Week</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Room Number</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                     @foreach ($week as $value)
                     <tr class="align-middle">
                        <th>
                            {{ $value['week_name'] }}
                            <input type="hidden" name="class_timetable[{{ $i }}][id]" value="{{ $value['id'] }}">
                        </th>
                        <td>
                            <input type="time" class="form-control" name="class_timetable[{{ $i }}][start_time]" value="{{ $value['start_time'] }}"  placeholder="Start Time">
                        </td>
                        <td>
                            <input type="time" class="form-control" name="class_timetable[{{ $i }}][end_time]" value="{{ $value['end_time'] }}"  placeholder="End Time">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="class_timetable[{{ $i }}][room_number]" value="{{ $value['room_number'] }}"  placeholder="Room Number">
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
            </form>
              @endif
        </div>
      </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
 $('.getClass').change(function() {
    var class_id = $(this).val();

    $.ajax({
        url: "{{ url('admin/class_timetable/get-subject') }}",
        type: "POST",
        data: {
            "_token": "{{ csrf_token() }}",
            class_id: class_id },
        dataType: "json",
        success: function(data) {
            $('.getSubject').html(data.html)
            var subjectSelect = $('#subject_id');

        }
    });
});
</script>
@endsection
