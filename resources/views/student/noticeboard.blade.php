@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Noticeboard</h3></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Noticeboard</li>
          </ol>
        </div>
      </div>
    </div>
</div>

    <section class="content">
        <div class="container-fluid">
            @if($getRecord->isEmpty())
                <div class="alert alert-info">
                    No notices available.
                </div>
            @else
                @foreach($getRecord as $notice)
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong>{{ $notice->title }}</strong>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($notice->created_at)->format('d M Y, h:i A') }}</small>
                        </div>
                        <div class="card-body">
                            {!! $notice->message !!}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>
</div>
@endsection
