@extends('template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex flex-row justify-content-between">
                        <div class="d-flex justify-content-center flex-column">
                            <h4 class="mb-0"> {{ $content['message'][0]['title'] }} </h4>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a class="btn btn-link" href="{{ route('getCurrentUser', ['userName' => $content['message'][0]['name']]) }}">{{ $content['message'][0]['name'] }}</a>
                            </div>
                            <div class="d-flex justify-content-center flex-column">
                                <span class="text-muted">{{ $content['message'][0]['created_at'] }}</span>
                            </div>
                        </div>
                        <div class="text-dark text-center">{{ $content['message'][0]['post'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
