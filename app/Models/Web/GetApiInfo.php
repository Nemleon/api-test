<?php

namespace App\Models\Web;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cookie;
use function GuzzleHttp\Psr7\str;

class GetApiInfo
{
    static public function getItems(Request $request)
    {
        $gotRequest = $request->all();

        $url = $gotRequest['url'];
        $endpoint = "http://exs.test/api/" . $url;

        $params = [];
        foreach ($gotRequest as $key => $value) {
            if ($key !== '_token' && $key !== 'url' && $key !== '_method') {
                if ($value !== null) {
                    $params += [$key => $value];
                }
            }
        }

        $method = $request->method();

        $client = new Client();

        try {
            if (Cookie::get('bearer_token')) {

                $token = json_decode(Cookie::get('bearer_token'), true, JSON_UNESCAPED_UNICODE);

                $response = $client->request($method, $endpoint, [
                    'headers' => [
                        'Authorization' => "Bearer {$token}"
                    ],
                    'query' => $params
                ]);

            } else {

                $response = $client->request($method, $endpoint, [
                    'query' => $params
                ]);

            }
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $content['headers'] =  $e->getResponse()->getHeaders();
                $content['code'] = $e->getResponse()->getStatusCode();
                $content['content'] = $e->getResponse()->getBody()->getContents();

                return $content;
            }
        }

        $content['headers'] =  $response->getHeaders();
        $content['code'] = $response->getStatusCode();
        $content['content'] = $response->getBody()->getContents();

        return $content;
    }

    static public function getItemsUrl($url)
    {
        $endpoint = "http://exs.test/api/" . $url;
        $method = 'GET';

        $client = new Client();

        try {
            if (Cookie::get('bearer_token')) {

                $token = json_decode(Cookie::get('bearer_token'), true, JSON_UNESCAPED_UNICODE);

                $response = $client->request($method, $endpoint, [
                    'headers' => [
                        'Authorization' => "Bearer {$token}"
                    ],
                ]);

            } else {

                $response = $client->request($method, $endpoint);

            }
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $content['headers'] =  $e->getResponse()->getHeaders();
                $content['code'] = $e->getResponse()->getStatusCode();
                $content['content'] = $e->getResponse()->getBody()->getContents();

                return $content;
            }
        }

        $content['headers'] = $response->getHeaders();
        $content['code'] = $response->getStatusCode();
        $content['content'] = $response->getBody()->getContents();

        return $content;
    }
}
