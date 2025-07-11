@extends('layouts.app')
@section('style')
@endsection
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Submit Homework</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Submit Homework</li>
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
            <div class="card-header"><div class="card-title">Submit Homework</div></div>
            <form action="" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="card-body">

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
<script>
    $('#summernote').summernote({
            height: 250
        });

</script>
@endsection
