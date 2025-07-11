@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">My Timetable</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Timetable</li>
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
                <div class="card-header"><h3 class="card-title">My TimeTable ({{ $getClass->name }} - {{ $getSubject->name }})</h3></div>
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
                        @foreach ($getRecord as $valueW)
                            <tr>
                                <td>{{ $valueW['week_name']  }}</td>
                                <td>{{ !empty($valueW['start_time']) ? date('h:i A',strtotime($valueW['start_time'] )) : '' }}</td>
                                <td>{{ !empty($valueW['end_time']) ? date('h:i A',strtotime($valueW['end_time'] )) : '' }}</td>
                                <td>{{ $valueW['room_number']  }}</td>
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
<script>
@endsection
