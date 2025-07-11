@extends('layouts.app')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Add Notice</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Notice</li>
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
            <div class="card-header"><div class="card-title">Add Notice</div></div>
            <form action="" method="POST">
              @csrf
              <div class="card-body">
                <div class="mb-3">
                    <label>Title</label>
                    <input
                      name="title"
                      type="text"
                      value="{{ old('title') }}"
                      class="form-control"
                    />
                  </div>

                  <div class="mb-3">
                    <label>Notice Date</label>
                    <input
                      name="notice_date"
                      type="date"
                      value="{{ old('notice_date') }}"
                      class="form-control"
                    />
                  </div>

                  <div class="mb-3">
                    <label>Publish Date</label>
                    <input
                      name="publish_date"
                      type="date"
                      value="{{ old('publish_date') }}"
                      class="form-control"
                    />
                  </div>

                  <div class="mb-3">
                    <label>Message</label>
                    <textarea
                    name="message"
                    id="summernote"
                    class="form-control"
                    rows="4"
                    placeholder="Enter message"
                    >{{ old('message') }}</textarea>
                </div>

                  <div class="mb-3">
                    <label>Message To</label>
                   <div>
                    <label for="" style="margin-right: 10px"><input name="message_to[]" type="checkbox" value="1">Admin</label><br>
                    <label for=""style="margin-right: 10px"><input name="message_to[]" type="checkbox" value="2">Teachers</label><br>
                    <label for=""style="margin-right: 10px"><input name="message_to[]" type="checkbox" value="3">Students</label><br>
                    <label for=""><input name="message_to[]" type="checkbox" value="4">Parents</label>
                   </div>
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
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 250
        });
    });

</script>
@endsection
