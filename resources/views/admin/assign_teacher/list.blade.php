@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Assign Teacher List</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
          </ol>
        </div>
        <div class="col-sm-12 d-flex justify-content-end">
            <a class="btn btn-primary" href="{{ url('admin/assign_teacher/add') }}"><i class="bi bi-plus"></i> Add New
            </a>
        </div>
      </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">

            <div class="card card-primary card-outline mb-4">
                <div class="card-header"><div class="card-title">Search Assign Teacher</div></div>
                <form action="" method="GET">
                  @csrf
                  <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Class Name</label>
                            <input
                              name="class_name"
                              type="text"
                              value="{{ Request::get('class_name') }}"
                              placeholder="Enter Class Name"
                              class="form-control"
                            />
                        </div>

                            <div class="col-md-3">
                                <label>Teacher Name</label>
                                <input
                                  name="teacher_name"
                                  type="text"
                                  value="{{ Request::get('teacher_name') }}"
                                  placeholder="Enter Teacher Name"
                                  class="form-control"
                                />
                          </div>

                          <div class="col-md-3">
                            <label for="">Status</label>
                            <select name="status" class="form-control">
                                <option value="">--Select Status--</option>
                                <option {{ (Request::get('status') == 100) ? 'selected' :'' }} value="100">Active</option>
                                <option {{ (Request::get('status') == 1) ? 'selected' :'' }} value="1">Inactive</option>
                            </select>
                          </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-info" style="margin-top: 24px">Submit</button>
                            <a class="btn btn-warning ms-2" href="{{ url('admin/assign_teacher/list') }}" style="margin-top: 24px">Reset
                            </a>
                        </div>
                    </div>
                  </div>
                </form>
              </div>
          <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">List</h3></div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Teacher Name</th>
                    <th>Class Name</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                 @foreach ($getRecord as $value)
                  <tr class="align-middle">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $value->teacher_name }} {{ $value->teacher_l_name }}</td>
                    <td>{{ $value->class_name }}</td>
                     <td>
                        @if($value->status == 0)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ url('admin/assign_teacher/edit/'.$value->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        <a href="{{ url('admin/assign_teacher/edit_single/'.$value->id) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-pen"></i>
                        </a>

                        <a href="{{ url('admin/assign_teacher/delete/'.$value->id) }}" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>

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
