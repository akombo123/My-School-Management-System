@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Admin List</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
          </ol>
        </div>
        <div class="col-sm-12 d-flex justify-content-end">
            <a class="btn btn-primary" href="{{ url('admin/admin/add') }}"><i class="bi bi-plus"></i> Add New {{-- data-bs-toggle="modal" data-bs-target="#addAdmin">
                " --}}
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
                        <div class="col-md-3">
                            <label>Name</label>
                            <input
                              name="name"
                              type="text"
                              value="{{ Request::get('name') }}"
                              placeholder="Enter name"
                              class="form-control"
                            />
                          </div>
                          <div class="col-md-3">
                          <label>Email address</label>
                          <input
                          name="email"
                            type="email"
                            value="{{ Request::get('email') }}"
                            placeholder="Enter email"
                            class="form-control"
                          />
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-info" style="margin-top: 24px">Submit</button>
                            <a class="btn btn-warning ms-2" href="{{ url('admin/admin/list') }}" style="margin-top: 24px">Reset
                            </a>
                        </div>
                    </div>
                  </div>
                </form>
              </div>
          <div class="card mb-4">
            <div class="card-header"><h3 class="card-title">Admin List</h3></div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                 @foreach ($getRecord as $value)
                 <tr class="align-middle">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->email }}</td>
                    <td>
                        <a href="{{ url('admin/admin/edit/'.$value->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="{{ url('admin/admin/delete/'.$value->id) }}" class="btn btn-danger btn-sm">
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

{{-- <div class="modal fade" id="addAdmin" tabindex="-1" aria-labelledby="addAdmin" aria-hidden="true">
<form id="adminForm">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" required>
                <span id="nameError" class="text-danger error-messages"></span>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
                <span id="emailError" class="text-danger error-messages
                $('.error-messages').html('');"></span>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
                <span id="passwordError" class="text-danger error-messages
                $('.error-messages').html('');"></span>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="saveBtn"></button>
              </div>
          </div>
        </div>
      </div>
</form>
</div> --}}
@endsection
@section('scripts')
<script>
        document.addEventListener("DOMContentLoaded", function () {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Welcome!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Continue'
            });
        @endif
</script>
<script>
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

$(document).ready(function(){

    $('#modalTitle').html('Add Admin');
    $('#saveBtn').html('Save');
    var form = $('#adminForm')[0];

    $('#saveBtn').click(function(){
        var formData = new FormData(form);

        $.ajax({
            url: '{{ url('admin/admin/insert') }}',
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert("Admin added successfully!");
                $('#addAdmin').modal('hide');
                $('#adminForm')[0].reset();
            },
            error: function(error) {
                if(error){
              console.log(error.responseJSON.errors.name)
              $('#nameError').html(error.responseJSON.errors.name);
              $('#emailError').html(error.responseJSON.errors.email);
              $('#passwordError').html(error.responseJSON.errors.password);

            }
            }
//             error: function(error) {
//     if (error.responseJSON && error.responseJSON.errors) {
//         // Handle validation errors
//         if (error.responseJSON.errors.name) {
//             $('#nameError').html(error.responseJSON.errors.name[0]);
//         }
//         if (error.responseJSON.errors.email) {
//             $('#emailError').html(error.responseJSON.errors.email[0]);
//         }
//         if (error.responseJSON.errors.password) {
//             $('#passwordError').html(error.responseJSON.errors.password[0]);
//         }
//     } else {
//         // Log the full error object for debugging
//         console.error("Unexpected error response:", error);
//         alert("An unexpected error occurred. Please try again.");
//     }
// }
        });
    });
});
</script>
@endsection
