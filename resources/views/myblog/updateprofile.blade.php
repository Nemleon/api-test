@extends('template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Создать пост</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('updateMySelf') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="url" value="users/update">
                            <input type="hidden" name="name" value="{{$content['message']['user info'][0]['name']}}">
                            @if (session('err'))
                                @if (is_array(session('err')))
                                    <div class="alert alert-danger">
                                        <ul class=" m-0">
                                            @foreach(session('err') as $errors)
                                                <li>{{ implode('</li><li>', $errors) }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <div class="alert alert-danger">
                                        <ul class=" m-0"><li>{{ session('err') }}</li></ul>
                                    </div>
                                @endif
                            @endif
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Почта</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{$content['message']['user info'][0]['email']}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="about" class="col-md-4 col-form-label text-md-right">О себе</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="about" id="about" cols="30" rows="20"
                                              style="resize: none; overflow: auto;" required>{{$content['message']['user info'][0]['about']}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Обновить профиль
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
