@extends('layouts.app')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Assign Teacher</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Assign Teacher</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="app-content">
    <div class="container-fluid">
      <div class="row g-4">
        <div class="col-12  d-flex justify-content-end">
            <a class="btn btn-primary" href="{{ url('admin/assign_teacher/list') }}" >  Back
            </a>
        </div>
        <div class="col-md-12">
          <div class="card card-primary card-outline mb-4">
            <div class="card-header"><div class="card-title">Assign Teacher</div></div>
            <form action="" method="POST">
              @csrf
              <div class="card-body">
                  <div class="mb-3">
                   <label>Class Name</label>
                   <select name="class_id"  class="form-control">
                    <option value="">--Select Class--</option>
                    @foreach ($getClass as $class)
                     <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                   </select>
                  </div>

                    <div class="mb-3">
                        <label>Teacher's Name</label>
                         @foreach ($getTeacher as $teacher)
                         <div>
                            <label>
                                <input type="checkbox" name="teacher_id[]" value="{{ $teacher->id }}"> {{ $teacher->name }} {{ $teacher->teacher_l_name }}
                            </label>
                         </div>
                         @endforeach
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                       <select name="status"  class="form-control">
                        <option value="">--Select--</option>
                        <option value="0">Active</option>
                        <option value="1">Inactive</option>
                       </select>
                      </div>

              </div>

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
