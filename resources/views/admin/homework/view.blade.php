@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">View Homework</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Homework</li>
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
            <div class="card-header"><h3 class="card-title">View Homework</h3></div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Document</th>
                    <th>Description</th>
                  </tr>
                </thead>
                <tbody>
                 @forelse($getRecord as $value)
                 <tr class="align-middle">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $value->class_name }}</td>
                    <td>{{ $value->subject_name }}</td>
                    <td>
                        @if(!empty($value->getDocument()))
                            <button class="btn btn-primary btn-sm" href="{{ asset('uploads/homework/'.$value->document_file) }}" download="" target="_blank">Download</button>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{!! $value->description !!}</td>
                    <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                  </tr>
                 @empty
                    <tr>
                        <td colspan="5" class="text-center">No Record Found</td>
                    </tr>
                 @endforelse
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
