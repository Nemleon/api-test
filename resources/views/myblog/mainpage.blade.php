@extends('template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-3">Информация обо мне</h2>
                <div class="card mb-3">
                    <div class="card-header d-flex flex-row justify-content-between">
                        <div class="d-flex justify-content-center flex-column">
                            <h4 class="mb-0">{{$content['user info'][0]['name']}}</h4>
                        </div>
                        <div class="d-flex">
                            <form method="GET" action="{{ route('updateMySelfView') }}">
                                @csrf
                                <input type="hidden" name="url" value="users/blog/{{ $content['user info'][0]['name'] }}">
                                <input class="btn btn-primary" type="submit" value="Редактировать профиль">
                            </form>
                            <form method="POST" action="{{ route('deleteMySelf') }}">
                                @method('DELETE')
                                @csrf
                                <input type="hidden" name="url" value="users/delete">
                                <input type="hidden" name="name" value="{{ $content['user info'][0]['name'] }}">
                                <input class="btn btn-danger" type="submit" value="Удалить профиль">
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-6"><strong>ID:</strong> {{$content['user info'][0]['id']}}</div>
                        <div class="col-md-6"><strong>Почта:</strong> {{$content['user info'][0]['email']}}</div>
                        <div class="col-md-6"><strong>Обо мне:</strong> {{$content['user info'][0]['about']}}</div>
                        <div class="col-md-6"><strong>Роль:</strong> {{$content['user info'][0]['role']}}</div>
                    </div>
                </div>
                @if (is_array($content['user posts']))
                    <div class="d-flex justify-content-between">
                        <h2 class="mb-3">Мои посты</h2>
                        <div>
                            <a class="btn btn-success" href="{{ route('createMyPostView') }}">Создать пост</a>
                        </div>
                    </div>
                    @for($i=0; $i < count($content['user posts']); $i++)
                        <div class="card mb-3">
                            <div class="card-header d-flex flex-row justify-content-between">
                                <div class="d-flex justify-content-center flex-column">
                                    <h4 class="mb-0"> {{ $content['user posts'][$i]['title'] }} </h4>
                                </div>
                                <div>
                                    <div class="d-flex">
                                        <form method="GET" action="{{ route('updateMyPostView') }}">
                                            @csrf
                                            <input type="hidden" name="url" value="blog/post/{{ $content['user posts'][$i]['title'] }}">
                                            <input class="btn btn-primary" type="submit" value="Редактировать пост">
                                        </form>
                                        <form method="POST" action="{{ route('deleteMyPost') }}">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="url" value="blog/delete">
                                            <input type="hidden" name="post_id" value="{{ $content['user posts'][$i]['post_id'] }}">
                                            <input type="hidden" name="name" value="{{ $content['user posts'][$i]['name'] }}">
                                            <input class="btn btn-danger" type="submit" value="Удалить пост">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="text-muted text-right">{{ $content['user posts'][$i]['created_at'] }}</div>
                                <div class="text-dark text-center">{{ $content['user posts'][$i]['post'] }}</div>
                            </div>
                        </div>
                    @endfor
                @else
                    <div class="d-flex justify-content-between">
                        <h2>Вы еще не создавали постов</h2>
                        <div>
                            <a class="btn btn-success" href="{{ route('createMyPostView') }}">Хотите создать?</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
