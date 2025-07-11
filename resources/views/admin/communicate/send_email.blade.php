@extends('layouts.app')
@section('style')
<link rel="stylesheet" href="{{ asset('dist/css/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('dist/css/select2.min.css') }}" />
<style>
    .select2-container .select2-selection--single{
        height: 30px;
    }
</style>
@endsection
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Send Email</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Send Email</li>
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
            <div class="card-header"><div class="card-title">Send Email</div></div>
            <form action="" method="POST">
              @csrf
              <div class="card-body">
                <div class="mb-3">
                    <label>Subject</label>
                    <input
                      name="subject"
                      type="text"
                      value="{{ old('subject') }}"
                      class="form-control"
                    />
                  </div>

                  <div class="mb-3">
                    <div class="form-group">
                      <label>User (Admin / Parent / Student / Teacher)</label>
                      <select name="user_id" class="form-control select2" style="width: 100%;">
                        <option value="">--Search--</option>
                      </select>
                    </div>
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
<script src="{{ asset('dist/js/select2.full.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            ajax: {
                url: '{{ url('admin/communicate/get_users') }}',
                dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        search: data.term || '',
                    };
                },
                processResults: function(response) {
                    return {
                        results:response
                    };
                },
            }
        });

        $('#summernote').summernote({
            height: 250
        });
    });

</script>
@endsection
