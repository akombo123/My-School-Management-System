@extends('layouts.app')
@section('style')
<style>
    .fc-daygrid-event {
    white-space: normal;
  }
</style>
@endsection
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">My Calender</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Calender</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="app-content">
    <div class="container-fluid">
      <div class="row g-4">
        <div class="col-md-12">
          <div id="calendar">

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script src={{ url('calender/index.global.js') }}></script>
<script>
    var events = new Array();

    @foreach($getClassTimeTable as $value)
            events.push({
                title: '{{$value->class_name}} - {{$value->subject_name}} ({{ date('h:i A',strtotime($value->start_time)) }} to {{ date('h:i A',strtotime($value->end_time)) }})',
                daysOfWeek: '{{$value->fullcalendar_day}}',
                startTime: '{{ date('h:i A',strtotime($value->start_time)) }}',
                endTime: '{{ date('h:i A',strtotime($value->end_time)) }}',
                color: '#f00'
            });
    @endforeach

    @foreach ($getExamTimeTable as $exam)
            events.push({
                title: '{{$exam->exam_name}} - {{$exam->subject_name}} ({{ date('h:i A',strtotime($exam->start_time)) }} to {{ date('h:i A',strtotime($exam->end_time)) }})',
                start: '{{ $exam->exam_date }}',
                end: '{{ $exam->exam_date }}',
                color:'red',
                url:'{{ url('teacher/my-exam-timetable') }}',

            });
    @endforeach

    var calendarID = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarID,{
        headerToolbar:{
            left:'prev,next today',
            center:'title',
            right:'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        initialDate:'<?=date('Y-m-d')?>',
        navlinks:true,
        editable:false,
        events:events,
    });
    calendar.render();
</script>
@endsection
