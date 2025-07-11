@extends('layouts.app')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Fee Collection Report</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Fee Collection Report</li>
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
                <div class="card-header"><div class="card-title">Search Record From Fees Collection</div></div>
                <form action="" method="GET">
                  @csrf
                  <div class="card-body">
                    <div class="row">
                          <div class="col-md-3">
                          <label>Class Name</label>
                            <select name="class_id" id="" class="form-control">
                                <option value="">--Select Class--</option>
                                @foreach($getClass as $class)
                                <option value="{{ $class->id }}" {{ Request::get('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Student Name</label>
                            <input
                              name="student_name"
                              type="text"
                              value="{{ Request::get('student_name') }}"
                              placeholder=""
                              class="form-control"
                            />
                          </div>
                        <div class="col-md-2">
                            <label>From Date</label>
                            <input
                              name="from_date"
                              type="date"
                              value="{{ Request::get('from_date') }}"
                              placeholder=""
                              class="form-control"
                            />
                          </div>
                          <div class="col-md-2">
                            <label>To Date</label>
                            <input
                              name="to_date"
                              type="date"
                              value="{{ Request::get('to_date') }}"
                              placeholder=""
                              class="form-control"
                            />
                          </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-info" style="margin-top: 24px">Submit</button>
                            <a class="btn btn-warning ms-2" href="{{ url('admin/fees-collection/fees-collection-report') }}" style="margin-top: 24px">Reset
                            </a>
                        </div>
                    </div>
                  </div>
                </form>
              </div>
            <div class="card">
                <div class="card-header"><strong>Fee Collection Report</strong>
                    <form action="{{ url('admin/fees-collection/export-fees-collection-report') }}" method="POST" style="float: right">
                        @csrf
                        <button type="submit" class="btn btn-primary">Export</button>
                    </form>
                </div>
                <div class="card-body">
                  <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                      <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Class Name</th>
                        <th>Total Amount</th>
                        <th>Paid Amount</th>
                        <th>Remaining Amount</th>
                        <th>Payment Type</th>
                        <th>Remark</th>
                        <th>Created Date</th>
                        <th>Created By</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($getRecord as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->student_name }} {{ $value->student_l_name }}</td>
                                <td>{{ $value->class_name }}</td>
                                <td>Ksh {{ number_format($value->total_amount,2) }}</td>
                                <td>Ksh {{ number_format($value->paid_amount,2) }}</td>
                                <td>Ksh {{ number_format($value->remaining_amount,2) }}</td>
                                <td>{{ $value->payment_type }}</td>
                                <td>{{ $value->remark }}</td>
                                <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                                <td>{{ $value->created_by_name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%" class="text-center">No Fees Collection Found</td>
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

