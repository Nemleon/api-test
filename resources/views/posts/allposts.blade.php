@extends('template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between">
                    <h2 class="mb-3">Все посты</h2>
                </div>
                @for($i=0; $i < count($content['message']); $i++)
                    <div class="card mb-3">
                        <div class="card-header d-flex flex-row justify-content-between">
                            <div class="d-flex justify-content-center flex-column">
                                <h4 class="mb-0"> {{ $content['message'][$i]['title'] }} </h4>
                            </div>
                            <a class="btn btn-link" href="{{ route('getCurrentPost', ['postName' => $content['message'][$i]['title']]) }}">Читать отдельно</a>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a class="btn btn-link" href="{{ route('getCurrentUser', ['userName' => $content['message'][$i]['name']]) }}">{{ $content['message'][$i]['name'] }}</a>
                                </div>
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="text-muted">{{ $content['message'][$i]['created_at'] }}</span>
                                </div>
                            </div>
                            <div class="text-dark text-center">{{ $content['message'][$i]['post'] }}</div>
                        </div>
                    </div>
                @endfor
                @endsection
            </div>
        </div>
    </div>
