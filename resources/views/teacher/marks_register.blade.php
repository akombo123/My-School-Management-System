@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Marks Register</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Marks Register</li>
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
                <div class="card-header"><div class="card-title">Search Marks Register</div></div>
                <form action="" method="GET">
                  @csrf
                  <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Exam Name</label>
                            <select name="exam_id" id="" class="form-control">
                                <option value="">--Select Exam--</option>
                                @foreach($getExam as $exam)
                                <option value="{{ $exam->exam_id }}" {{ Request::get('exam_id') == $exam->exam_id ? 'selected' : '' }}>{{ $exam->exam_name }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="col-md-3">
                            <label>Class Name</label>
                            <select name="class_id" id="" class="form-control">
                                <option value="">--Select Class--</option>
                                @foreach($getClass as $class)
                                <option value="{{ $class->class_id }}" {{ Request::get('class_id') == $class->class_id ? 'selected' : '' }}>{{ $class->class_name }}</option>
                                @endforeach
                            </select>
                          </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-info" style="margin-top: 24px">Submit</button>
                            <a class="btn btn-warning ms-2" href="{{ url('admin/exams/marks-register') }}" style="margin-top: 24px">Reset
                            </a>
                        </div>
                    </div>
                  </div>
                </form>
              </div>
        @if(!empty($getSubject))
          <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">Marks Register</h3></div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    @foreach ($getSubject as $subject)
                        <th>{{ $subject->subject_name }}
                            <br>
                            ( {{ $subject->subject_type == 1 ? 'Theory' : 'Practical' }}
                            {{ $subject->passing_marks }}/{{ $subject->full_marks }}
                            )
                        </th>
                    @endforeach
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @if(!empty($getStudentClass) && count($getStudentClass) > 0)

                        @foreach ($getStudentClass as $value)
                        <form action="" class="submitForm" method="POST">
                            @csrf
                            <input type="hidden" name="exam_id" value="{{ Request::get('exam_id') }}">
                            <input type="hidden" name="class_id" value="{{ Request::get('class_id') }}">
                            <input type="hidden" name="student_id" value="{{ $value->id }}" >
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->name }} {{ $value->l_name }}</td>
                            @php
                            $i = 1;
                            $studentMark = 0;
                            $totalFullMark = 0;
                            $totalPassingMark = 0;
                            $pass_fail_validation = 0;
                            @endphp
                            @foreach ($getSubject as $subject)
                            @php
                            $total_mark = 0;
                            $getMark = $value->getMark(Request::get('class_id'),$subject->subject_id, Request::get('exam_id'),$value->id);
                            if(!empty($getMark)){
                            $total_mark = $getMark->homework + $getMark->classwork + $getMark->test_work + $getMark->exam_marks;
                            }
                            $studentMark = $studentMark + $total_mark;
                            $totalFullMark = $totalFullMark + $subject->full_marks;
                            $totalPassingMark = $totalPassingMark + $subject->passing_marks;
                            @endphp
                            <td>
                                <div>
                                    <label for="">HomeWork</label>
                                    <input type="hidden" name="marks[{{ $i }}][passing_marks]" value="{{ $subject->passing_marks }}">
                                    <input type="hidden" name="marks[{{ $i }}][full_marks]" value="{{ $subject->full_marks }}">
                                    <input type="hidden" name="marks[{{ $i }}][id]" value="{{ $subject->id }}">
                                    <input type="hidden" name="marks[{{ $i }}][subject_id]" value="{{ $subject->subject_id }}">
                                    <input type="text" style="width: 200px" class="form-control" id="homework_{{ $subject->subject_id }}{{ $value->id }}" name="marks[{{ $i }}][homework]" value="{{ !empty($getMark->homework) ? $getMark->homework :'' }}" >
                                </div>
                                <div>
                                    <label for="">Class Work</label>
                                    <input type="text" style="width: 200px" class="form-control" id="classwork_{{ $subject->subject_id }}{{ $value->id }}" name="marks[{{ $i }}][classwork]" value="{{ !empty($getMark->classwork) ? $getMark->classwork :'' }}">
                                </div>
                                <div>
                                    <label for="">Test Work</label>
                                    <input type="text" style="width: 200px" class="form-control" id="test_work_{{ $subject->subject_id }}{{ $value->id }}" name="marks[{{ $i }}][test_work]" value="{{ !empty($getMark->test_work) ? $getMark->test_work :'' }}">
                                </div>
                                <div>
                                    <label for="">Exam Marks</label>
                                    <input type="text" style="width: 200px" class="form-control" id="exam_marks_{{ $subject->subject_id }}{{ $value->id }}" name="marks[{{ $i }}][exam_marks]" value="{{ !empty($getMark->exam_marks) ? $getMark->exam_marks :'' }}">
                                </div>
                                <div style="margin-top: 10px;">
                                    <button type="button" class="btn btn-info saveSingle" id="{{ $value->id }}" data-class="{{ Request::get('class_id') }}" data-exam="{{ Request::get('exam_id') }}" data-subject="{{ $subject->subject_id }}" data-schedule="{{ $subject->id }}">Save</button>
                                </div>
                                @if(!empty($getMark))
                                <div style="margin-top: 10px;">
                                   <b>Total Marks</b>: {{ $total_mark }}
                                   <br>
                                   <b>Passing Marks</b>: {{ $subject->passing_marks }} <br>
                                   @php
                                       $getLoopGrade = \App\Models\MarksGradeModel::getGrade($total_mark);
                                   @endphp
                                   @if(!empty($getLoopGrade))
                                      <b>Grade</b>: {{ $getLoopGrade }}
                                   @endif
                                      <br>
                                   @if ($total_mark >= $subject->passing_marks)
                                   <b>Result</b>: <span class="badge bg-success">Pass</span>
                                   @else
                                   <b>Result</b>:<span class="badge bg-danger">Fail</span>
                                        @php
                                            $pass_fail_validation = 1;
                                        @endphp
                                   @endif
                                </div>
                                @endif
                            </td>
                            @php
                            $i++;
                            @endphp
                            @endforeach
                            <td colspan="{{ count($getSubject) + 3 }}" class="text-center">
                                    <button type="submit" class=" btn btn-primary">Submit</button>
                                    @if(!empty($studentMark))
                                    <br>
                                    <br>
                                    <br>

                                    <b>Total Full Marks</b>: {{ $totalFullMark }}
                                    <br>
                                    <b>Total Passing Marks</b>: {{ $totalPassingMark }}
                                    <br>
                                    <b>Total Student Marks</b>:  {{ $studentMark }}
                                    <br>
                                    @php
                                        $percent = ($studentMark *100) / $totalFullMark;
                                        $getGrade = \App\Models\MarksGradeModel::getGrade($percent);
                                    @endphp
                                    <b>Percentage</b>: {{ number_format($percent, 2) }} %
                                    <br>
                                    @if (!empty($getGrade))
                                    <b>Grade</b>: {{ $getGrade }}
                                    @endif
                                    <br>
                                    @if ($pass_fail_validation == 0)
                                    <b>Result</b>: <span class="badge bg-success">Pass</span>
                                    @else
                                    <b>Result</b>:  <span class="badge bg-danger">Fail</span>
                                    @endif
                                    @endif
                            </td>
                        </tr>
                        </form>
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
    $('.submitForm').submit(function(e){
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: '{{ url('teacher/submit-marks-register') }}',
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                alert(response.message);
            },
            error: function(xhr, status, error) {
                alert('An error occurred. Please try again.');
            }
        });
    });

    $('.saveSingle').click(function(e){
       var student_id = $(this).attr('id');
       var class_id = $(this).attr('data-class');
       var exam_id = $(this).attr('data-exam');
       var subject_id = $(this).attr('data-subject');
       var id = $(this).attr('data-schedule');
       var homework = $('#homework_'+subject_id+student_id).val();
       var classwork = $('#classwork_'+subject_id+student_id).val();
       var test_work = $('#test_work_'+subject_id+student_id).val();
       var exam_marks = $('#exam_marks_'+subject_id+student_id).val();

        $.ajax({
            type: 'POST',
            url: '{{ url('teacher/single-submit-marks-register') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                student_id: student_id,
                class_id: class_id,
                exam_id: exam_id,
                subject_id: subject_id,
                homework: homework,
                classwork: classwork,
                test_work: test_work,
                exam_marks: exam_marks,
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
