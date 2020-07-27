<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Web\GetApiInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class BlogController extends Controller
{
    public function index()
    {
        $cookie = json_decode(Cookie::get('auth'), true, JSON_UNESCAPED_UNICODE);
        $userName = $cookie['name'];

        $url = 'users/blog/'.$userName;

        $data = GetApiInfo::getItemsUrl($url);
        $content = json_decode($data['content'], true, JSON_UNESCAPED_UNICODE);

        return response()->view('myblog.mainpage', ['content' => $content['message']], $data['code']);
    }

    public function updatePostView(Request $request)
    {
        $params = $request->all();
        $url = $params['url'];

        $data = GetApiInfo::getItemsUrl($url);
        $content = json_decode($data['content'], true, JSON_UNESCAPED_UNICODE);

        return view('myblog.updatepost', ['content' => $content]);
    }

    public function createPostView()
    {
        return view('myblog.createpost');
    }

    public function actionWithPost(Request $request)
    {
        $data = GetApiInfo::getItems($request);
        $content = json_decode($data['content'], true, JSON_UNESCAPED_UNICODE);

        if (!isset($content['error'])) {
            return response()->view(
                'myblog.success',
                ['content' => $content['message']],
                $data['code']);

        } else {
            return redirect()->back()->with(['err' => $content['message']]);
        }
    }

    public function getAllPosts()
    {
        $data = GetApiInfo::getItemsUrl('blog');
        $content = json_decode($data['content'], true, JSON_UNESCAPED_UNICODE);

        return view('posts.allposts', ['content' => $content]);
    }

    public function getCurrentPost($postName)
    {
        $data = GetApiInfo::getItemsUrl('blog/post/'.$postName);
        $content = json_decode($data['content'], true, JSON_UNESCAPED_UNICODE);

        return view('posts.currentpost', ['content' => $content]);
    }
}
