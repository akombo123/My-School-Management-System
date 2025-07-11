@extends('layouts.app')
@section('style')
@endsection
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Homework</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Homework</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="app-content">
    <div class="container-fluid">
      <div class="row g-4">
        <div class="col-md-12">
          <div class="card card-primary card-outline mb-4">
            <div class="card-header"><div class="card-title">Homework</div></div>
            <form action="" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="mb-3">
                    <label>Class</label>
                    <select name="class_id" id="getClass" class="form-control">
                      <option value="">--Select Class--</option>
                      @foreach ($getClass as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="mb-3">
                    <label>Subject</label>
                    <select name="subject_id" id="getSubject" class="form-control">
                      <option value="">--Select Subject--</option>
                    </select>
                  </div>

                <div class="mb-3">
                    <label>Homework Date</label>
                    <input
                      name="homework_date"
                      type="date"
                      value="{{ old('homework_date') }}"
                      class="form-control"
                    />
                  </div>

                  <div class="mb-3">
                    <label>Submission Date</label>
                    <input
                      name="submission_date"
                      type="date"
                      value="{{ old('submission_date') }}"
                      class="form-control"
                    />
                  </div>

                  <div class="mb-3">
                    <label>Document</label>
                    <input
                      name="document_file"
                      type="file"
                      value="{{ old('document_file') }}"
                      class="form-control"
                    />
                  </div>
                  <div class="mb-3">
                    <label>Description</label>
                    <textarea
                    name="description"
                    id="summernote"
                    class="form-control"
                    rows="4"
                    placeholder="Enter Description">{{ old('description') }}</textarea>
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
@section('scripts')
<script src="{{ asset('dist/js/select2.full.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 250
        });

        $('#getClass').change(function() {
            var class_id = $(this).val();

            $.ajax({
                url: "{{ url('admin/homework/get_subject_ajax') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    class_id: class_id,
                },
                success: function(data) {
                    $('#getSubject').html(data.html);
                }
            });
        });
    });

</script>
@endsection
