@extends('template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Создать пост</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('updateMyPost') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="url" value="blog/update">
                            <input type="hidden" name="name" value="{{$content['message'][0]['name']}}">
                            <input type="hidden" name="post_id" value="{{$content['message'][0]['post_id']}}">
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
                                <label for="title" class="col-md-4 col-form-label text-md-right">Заголовок</label>
                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control" name="title" value="{{$content['message'][0]['title']}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="post" class="col-md-4 col-form-label text-md-right">Текст</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="post" id="post" cols="30" rows="20"
                                    style="resize: none; overflow: auto;">{{$content['message'][0]['post']}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Обновить запись
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
