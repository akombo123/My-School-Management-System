@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Noticeboard List</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Noticeboard List</li>
          </ol>
        </div>
        <div class="col-sm-12 d-flex justify-content-end">
            <a class="btn btn-primary" href="{{ url('admin/communicate/noticeboard/add') }}"><i class="bi bi-plus"></i> Add New
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
                <div class="card-header"><div class="card-title">Search User</div></div>
                <form action="" method="GET">
                  @csrf
                  <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label>Title</label>
                            <input
                              name="title"
                              type="text"
                              value="{{ Request::get('title') }}"
                              placeholder="Enter Title"
                              class="form-control"
                            />
                          </div>
                          <div class="col-md-3 mb-3">
                          <label>Publish Date From</label>
                          <input
                          name="publish_date_from"
                            type="date"
                            value="{{ Request::get('publish_date_from') }}"
                            class="form-control"
                          />
                          </div>
                          <div class="col-md-3 mb-3">
                            <label>Publish Date To</label>
                            <input
                            name="publish_date_to"
                              type="date"
                              value="{{ Request::get('publish_date_to') }}"
                              class="form-control"
                            />
                          </div>
                          <div class="col-md-3 mb-3">
                            <label>Message To</label>
                            <select name="message_to" class="form-control">
                                <option value="">Select Message To</option>
                                <option value="1" {{ Request::get('message_to') == 1 ? 'selected' : '' }}>Admin</option>
                                <option value="2" {{ Request::get('message_to') == 2 ? 'selected' : '' }}>Teachers</option>
                                <option value="3" {{ Request::get('message_to') == 3 ? 'selected' : '' }}>Students</option>
                                <option value="4" {{ Request::get('message_to') == 4 ? 'selected' : '' }}>Parents</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="submit" class="btn btn-info" style="margin-top: 24px">Submit</button>
                            <a class="btn btn-warning ms-2" href="{{ url('admin/communicate/noticeboard') }}" style="margin-top: 24px">Reset
                            </a>
                        </div>
                    </div>
                  </div>
                </form>
              </div>
          <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">Noticeboard List</h3></div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Notice Date</th>
                    <th>Publish Date</th>
                    <th>Message To</th>
                    <th>Created Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                 @foreach ($getRecord as $value)
                 <tr class="align-middle">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $value->title }}</td>
                    <td>{{ date('d-m-Y',strtotime($value->notice_date)) }}</td>
                    <td>{{ date('d-m-Y',strtotime($value->publish_date)) }}</td>
                    <td>
                        @foreach($value->getMessage as $message)
                            @if($message->message_to == 1)
                                <span class="badge bg-primary">Admin</span>
                            @elseif($message->message_to == 2)
                                <span class="badge bg-success">Teachers</span>
                            @elseif($message->message_to == 3)
                                <span class="badge bg-warning">Students</span>
                            @elseif($message->message_to == 4)
                                <span class="badge bg-danger">Parents</span>
                            @endif
                        @endforeach
                    </td>
                    <td>{{ date('d-m-Y',strtotime($value->created_at)) }}</td>
                    <td>
                        <a href="{{ url('admin/communicate/noticeboard/edit/'.$value->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="{{ url('admin/communicate/noticeboard/delete/'.$value->id) }}" class="btn btn-danger btn-sm">
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
