<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Print Exam Result</title>
  <style>
    @page {
      size: A4;
      margin: 20mm;
    }

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .header {
      display: flex;
      align-items: center;
      justify-content: flex-start;
      margin-bottom: 20px;
      gap: 20px;
    }

    .header img {
      width: 110px;
      height: auto;
    }

    .school-name {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .school-name h1 {
      font-size: 24px;
      margin: 0;
      text-transform: uppercase;
    }

    .school-name p {
      font-size: 14px;
      margin: 5px 0 0;
    }

    .student-info, .result-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
      margin-bottom: 20px;
    }

    .student-info td {
      padding: 4px 8px;
    }

    .student-photo {
      border-radius: 6px;
      height: 100px;
      width: 100px;
      object-fit: cover;
    }

    .result-table th,
    .result-table td {
      border: 1px solid #000;
      padding: 6px;
      text-align: center;
    }

    .badge {
      padding: 4px 10px;
      color: #fff;
      border-radius: 4px;
      font-size: 12px;
    }

    .bg-success {
      background-color: #28a745;
    }

    .bg-danger {
      background-color: #dc3545;
    }

    .summary {
      text-align: right;
      font-weight: bold;
    }

    .signature-section {
      margin-top: 40px;
    }

    .signature-line {
      width: 200px;
      border-bottom: 1px solid #000;
      display: inline-block;
    }

    .print-note {
      font-size: 12px;
      color: #555;
      margin-top: 20px;
    }

    .text-end {
      text-align: right;
    }
  </style>
</head>
<body>

  <div class="header">
    <img src="http://localhost:8000/uploads/profile/20250407051922vwlbo1mpj5jg7zf2ieb1.jpg" alt="Logo">
    <div class="school-name">
      <h1>SCHOOL MODEL</h1>
      <p>INTERNATIONAL SCHOOL</p>
    </div>
  </div>

  <table class="student-info">
    <tr>
      <td style="width: 70%;">
        <table>
          <tr><td><strong>Student Name:</strong></td><td>{{ $getUser->name }} {{ $getUser->l_name }}</td></tr>
          <tr><td><strong>Adm No:</strong></td><td>{{ $getUser->adm_no }}</td></tr>
          <tr><td><strong>Class:</strong></td><td>{{ $getClass->class_name }}</td></tr>
          <tr><td><strong>Term:</strong></td><td>{{ $getExam->name }}</td></tr>

        </table>
      </td>
      <td style="width: 30%; text-align: center;">
        <img class="student-photo" src="{{ $getUser->getProfile() }}" alt="Student Photo"><br>
        <strong>Gender:</strong> {{ $getUser->gender }}
      </td>
    </tr>
  </table>

  <table class="result-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Subject Name</th>
        <th>Home Work</th>
        <th>Test Work</th>
        <th>Class Work</th>
        <th>Exam Marks</th>
        <th>Total Marks / Full Marks</th>
        <th>Result</th>
      </tr>
    </thead>
    <tbody>
        @php
            $total_marks = 0;
            $total_full_marks = 0;
            $pass_fail_validation = 0;
        @endphp
     @foreach ($exam as $marks)
        @php
            $total_marks += $marks['total_marks'];
            $total_full_marks += $marks['full_marks'];
        @endphp
     <tr>
        <td>{{ $loop->iteration }}</td>
        <td style="text-align: left">{{ $marks['subject_name'] }}</td>
        <td>{{ $marks['homework'] }}</td>
        <td>{{ $marks['test_work'] }}</td>
        <td>{{ $marks['classwork'] }}</td>
        <td>{{ $marks['exam_marks'] }}</td>
        <td>{{ $marks['total_marks'] }}/ {{ $marks['full_marks'] }}</td>
        <td>
            @if ($marks['total_marks'] >= $marks['passing_marks'])
                <span class="badge bg-success">Pass</span>
            @else
                <span class="badge bg-danger">Fail</span>
                @php $pass_fail_validation = 1; @endphp
            @endif
        </td>
      </tr>
     @endforeach
     <tr>
        <td colspan="5" class="text-end"><b>Grand Total: {{ $total_marks }}/{{ $total_full_marks }}</b></td>
        <td>
            @php $percentage = ($total_marks / $total_full_marks) * 100; @endphp
            <b>Percentage: {{ number_format($percentage, 2) }}%</b>
        </td>
        <td>
            @php $getGrade = \App\Models\MarksGradeModel::getGrade($percentage); @endphp
            <b>Grade: {{ $getGrade }}</b>
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

  <div class="signature-section">
    <p>
      Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since the 1500s.
    </p>

    <p><strong>Signature:</strong> <span class="signature-line"></span></p>
    <p class="print-note">* This is a system-generated document and does not require a physical signature.</p>
  </div>

  <script>
    window.print();
  </script>

</body>
</html>
