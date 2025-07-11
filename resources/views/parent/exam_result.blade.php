@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Exam Results ({{ $getUser->name }} {{ $getUser->l_name }})</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Exam Results</li>
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
            <div class="card-header"><h3 class="card-title">{{ $value['exam_name'] }}</h3>
                <a style="float: right" target="_blank" href="{{ url('parent/exam-result/print?exam_id='.$value['exam_id'].'&student_id='.$getUser->id ) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Subject Name</th>
                    <th>Home Work</th>
                    <th>Test Work</th>
                    <th>Class Work</th>
                    <th>Exam Marks</th>
                    <th>Total Marks/Full Marks</th>
                    <th>Result</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $total_marks = 0;
                        $total_full_marks = 0;
                        $pass_fail_validation = 0;
                        $total_obtained_marks = 0;
                    @endphp
                 @foreach ($value['exam'] as $marks)
                    @php
                        $total_marks += $marks['total_marks'];
                        $total_full_marks += $marks['full_marks'];
                    @endphp
                 <tr class="align-middle">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $marks['subject_name'] }}</td>
                    <td>{{ $marks['homework'] }}</td>
                    <td>{{ $marks['test_work'] }}</td>
                    <td>{{ $marks['classwork'] }}</td>
                    <td>{{ $marks['exam_marks'] }}</td>
                    <td>{{ $marks['total_marks'] }}/ {{ $marks['full_marks'] }}</td>
                    <td>
                        @if ($marks['total_marks'] >= $marks['passing_marks'])
                            <b><span class="badge bg-success">Pass</span></b>
                            @else
                            <b><span class="badge bg-danger">Fail</span></b>
                            @php
                            $pass_fail_validation = 1;
                            @endphp
                            @endif
                    </td>
                  </tr>
                 @endforeach
                 <tr>
                    <td colspan="5" class="text-end"><b>Grand Total :{{ $total_marks }}/ {{ $total_full_marks }}</b></td>
                    <td><b><b>Percentage </b>{{ number_format(($total_marks/ $total_full_marks)*100,2) }}%</b></td>
                    <td>
                        @php
                            $percentage = ($total_marks/ $total_full_marks)*100;
                            $getGrade = \App\Models\MarksGradeModel::getGrade($percentage);
                        @endphp
                        <b><b>Grade : </b>{{ $getGrade }}</b>
                    </td>
                    <td>
                        @if ($pass_fail_validation == 0)
                        <span class="badge bg-success">Pass</span>
                        @else
                        <span class="badge bg-danger">Fail</span>
                        @endif
                    </td>
                  </tr>
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
@endsection
