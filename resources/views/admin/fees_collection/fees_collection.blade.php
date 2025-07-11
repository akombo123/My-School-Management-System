@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Fees Collection</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Fees Collection</li>
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
                <div class="card-header"><div class="card-title">Search Fees Collection Form</div></div>
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
                            <label>First Name</label>
                            <input
                              name="f_name"
                              type="text"
                              value="{{ Request::get('f_name') }}"
                              placeholder=""
                              class="form-control"
                            />
                          </div>
                          <div class="col-md-3">
                            <label>Last Name</label>
                            <input
                              name="l_name"
                              type="text"
                              value="{{ Request::get('l_name') }}"
                              placeholder=""
                              class="form-control"
                            />
                          </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-info" style="margin-top: 24px">Submit</button>
                            <a class="btn btn-warning ms-2" href="{{ url('admin/fees-collection/collect-fees') }}" style="margin-top: 24px">Reset
                            </a>
                        </div>
                    </div>
                  </div>
                </form>
              </div>
          <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">Fees Collection</h3></div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>Class Name</th>
                    <th>Total Amount</th>
                    <th>Paid Amount</th>
                    <th>Remaining Amount</th>
                    <th>Created Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @if(!empty($getRecord))
                @foreach ($getRecord as $value)
                @php
                    $paid_amount = $value->getPAidAmount($value->id,$value->class_id);
                    $remeianing_amount = $value->amount - $paid_amount;
                @endphp
                    <tr class="align-middle">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $value->name }} {{ $value->l_name }}</td>
                    <td>{{ $value->class_name }}</td>
                    <td>{{ number_format($value->amount,2) }}</td>
                    <td>{{ number_format($paid_amount,2) }}</td>
                    <td>{{ number_format($remeianing_amount,2) }}</td>
                    <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                    <td>
                        <a href="{{ url('admin/fees-collection/collect-fees/add/'.$value->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                    </td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="100%" class="text-center">No Record Found</td>
                </tr>
                @endif
                </tbody>
              </table>
              <div class="d-flex justify-content-end mt-3">
                @if(!empty($getRecord))
                {{ $getRecord->links() }}
                @endif
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
