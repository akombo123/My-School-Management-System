@extends('layouts.app')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Edit Assign Subject</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Assign Subject</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="app-content">
    <div class="container-fluid">
      <div class="row g-4">
        <div class="col-12  d-flex justify-content-end">
            <a class="btn btn-primary" href="{{ url('admin/assign_subject/list') }}" >  Back
            </a>
        </div>
        <div class="col-md-12">
          <div class="card card-primary card-outline mb-4">
            <div class="card-header"><div class="card-title">Assign Subject</div></div>
            <form action="" method="POST">
              @csrf
              <div class="card-body">
                  <div class="mb-3">
                   <label>Class Name</label>
                   <select name="class_id"  class="form-control">
                    <option value="">--Select Class--</option>
                    @foreach ($getClass as $class)
                     <option {{ ($getRecord->class_id == $class->id) ? 'selected' :'' }} value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                   </select>
                  </div>

                  <div class="mb-3">
                  <label>Subject Name</label>
                   <select name="subject_id"  class="form-control">
                    <option value="">--Select Subject--</option>
                    @foreach ($getSubject as $subject)
                     <option {{ ($getRecord->subject_id == $subject->id) ? 'selected' :'' }} value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                   </select>
                  </div>

                    <div class="mb-3">
                        <label>Status</label>
                       <select name="status"  class="form-control">
                        <option value="">--Select--</option>
                        <option {{ ($getRecord->status == 0) ? 'selected' :'' }} value="0">Active</option>
                        <option {{ ($getRecord->status == 1) ? 'selected' :'' }} value="1">Inactive</option>
                       </select>
                      </div>

              </div>

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
