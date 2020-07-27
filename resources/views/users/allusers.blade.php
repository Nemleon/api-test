@extends('template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between">
                    <h2 class="mb-3">Все пользователи</h2>
                </div>
                @for($i=0; $i < count($content['message']); $i++)
                    <div class="card mb-3">
                        <div class="card-header d-flex flex-row justify-content-between">
                            <div class="d-flex justify-content-center flex-column">
                                <h4 class="mb-0"> {{ $content['message'][$i]['name'] }} </h4>
                            </div>
                            <a class="btn btn-link" href="{{ route('getCurrentUser', ['userName' => $content['message'][$i]['name']]) }}">Посмотреть профиль</a>
                        </div>
                        <div class="card-body">
                            <div class="col-md-6"><strong>Почта:</strong> {{$content['message'][$i]['email']}}</div>
                            <div class="col-md-6"><strong>О себе:</strong> {{$content['message'][$i]['about']}}</div>
                            <div class="col-md-6"><strong>Роль:</strong> {{$content['message'][$i]['role']}}</div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
@endsection
