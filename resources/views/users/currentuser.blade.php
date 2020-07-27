@extends('template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-3">Информация о пользователе</h2>
                <div class="card mb-3">
                    <div class="card-header d-flex flex-row justify-content-between">
                        <div class="d-flex justify-content-center flex-column">
                            <h4 class="mb-0">{{$content['message']['user info'][0]['name']}}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-6"><strong>ID:</strong> {{$content['message']['user info'][0]['id']}}</div>
                        <div class="col-md-6"><strong>Почта:</strong> {{$content['message']['user info'][0]['email']}}</div>
                        <div class="col-md-6"><strong>Обо мне:</strong> {{$content['message']['user info'][0]['about']}}</div>
                        <div class="col-md-6"><strong>Роль:</strong> {{$content['message']['user info'][0]['role']}}</div>
                    </div>
                </div>
                @if (is_array($content['message']['user posts']))
                    <div class="d-flex justify-content-between">
                        <h2 class="mb-3">Посты пользователя</h2>
                    </div>
                        <div class="card mb-3">
                            <div class="card-header d-flex flex-row justify-content-between">
                                <div class="d-flex justify-content-center flex-column">
                                    <h4 class="mb-0"> {{ $content['message']['user posts'][0]['title'] }} </h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="text-muted text-right">{{ $content['message']['user posts'][0]['created_at'] }}</div>
                                <div class="text-dark text-center">{{ $content['message']['user posts'][0]['post'] }}</div>
                            </div>
                        </div>
                @else
                    <div class="d-flex justify-content-between">
                        <h2>{{ $content['message']['user posts'] }}</h2>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
