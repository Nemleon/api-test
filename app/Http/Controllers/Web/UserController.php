<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Web\GetApiInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    public function updateUserView(Request $request)
    {
        $params = $request->all();
        $url = $params['url'];

        $data = GetApiInfo::getItemsUrl($url);
        $content = json_decode($data['content'], true, JSON_UNESCAPED_UNICODE);

        return view('myblog.updateprofile', ['content' => $content]);
    }

    public function deleteUser()
    {

    }

    public function actionWithUser(Request $request)
    {
        if ($request->method() == 'DELETE') {
            Cookie::queue(Cookie::forget('auth'));
            Cookie::queue(Cookie::forget('bearer_token'));
        }

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

    public function getAllUsers ()
    {
        $data = GetApiInfo::getItemsUrl('users');
        $content = json_decode($data['content'], true, JSON_UNESCAPED_UNICODE);

        return view('users.allusers', ['content' => $content]);
    }

    public function getCurrentUser($userName)
    {
        $data = GetApiInfo::getItemsUrl('users/blog/'.$userName);
        $content = json_decode($data['content'], true, JSON_UNESCAPED_UNICODE);

        return view('users.currentuser', ['content' => $content]);
    }
}
