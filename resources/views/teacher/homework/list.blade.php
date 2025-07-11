@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Homework List</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Homework List</li>
          </ol>
        </div>
        <div class="col-sm-12 d-flex justify-content-end">
            <a class="btn btn-primary" href="{{ url('teacher/homework/homework/add') }}"><i class="bi bi-plus"></i> Add New
            </a>
        </div>
      </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">

          <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">Homework List</h3></div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Homework Date</th>
                    <th>Submission Date</th>
                    <th>Document</th>
                    <th>Created Date</th>
                    <th>Action</th>

                  </tr>
                </thead>
                <tbody>
                 @foreach($getRecord as $value)
                 <tr class="align-middle">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $value->class_name }}</td>
                    <td>{{ $value->subject_name }}</td>
                    <td>{{ date('d-m-Y', strtotime($value->homework_date)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($value->submission_date)) }}</td>
                    <td>
                        @if(!empty($value->getDocument()))
                            <button class="btn btn-primary btn-sm" href="{{ asset('uploads/homework/'.$value->document_file) }}" download="" target="_blank">Download</button>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                    <td>
                        <a href="{{ url('teacher/homework/homework/edit/'.$value->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="{{ url('teacher/homework/homework/delete/'.$value->id) }}" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </a>
                        <a href="{{ url('teacher/homework/homework/submitted/'.$value->id) }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-eye"></i> View Submitted Doc
                        </a>
                    </td>
                  </tr>
                 @endforeach
                </tbody>
              </table>
              <div class="d-flex justify-content-end mt-3">
                {{ $getRecord->links() }}
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection
@section('scripts')
@endsection
