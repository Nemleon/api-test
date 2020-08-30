<?php

namespace App\Http\Controllers\Api\Controllers;

use App\Models\Api\MiddlewareChain\General\GetResponse;
use App\Models\Api\MiddlewareChain\Item\CreateItem;
use App\Models\Api\MiddlewareChain\Item\CreateItemValidator;
use App\Models\Api\MiddlewareChain\Item\DeleteItem;
use App\Models\Api\MiddlewareChain\Item\DeleteItemValidator;
use App\Models\Api\MiddlewareChain\Item\GetItem;
use App\Models\Api\MiddlewareChain\Item\GetItemFromCatValidator;
use App\Models\Api\MiddlewareChain\Item\GetItemsFromCategory;
use App\Models\Api\MiddlewareChain\Item\GetItemValidator;
use App\Models\Api\MiddlewareChain\Item\UpdateItem;
use App\Models\Api\MiddlewareChain\Item\UpdateItemValidator;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function createItem(Request $request)
    {
        $item = new CreateItemValidator($request);
        $item->linkWith(new CreateItem())
            ->linkWith(new GetResponse());

        $response = $item->handler();

        return response()->json($response['message'], $response['code']);
    }

    public function getItem(Request $request)
    {
        $item = new GetItemValidator($request);
        $item->linkWith(new GetItem())
            ->linkWith(new GetResponse());

        $response = $item->handler();

        return response()->json($response['message'], $response['code']);
    }

    public function getItemsFromCategory(Request $request)
    {
        $items = new GetItemFromCatValidator($request);
        $items->linkWith(new GetItemsFromCategory())
            ->linkWith(new GetResponse());

        $response = $items->handler();

        return response()->json($response['message'], $response['code']);
    }

    public function updateItem(Request $request)
    {
        $item = new UpdateItemValidator($request);
        $item->linkWith(new UpdateItem())
            ->linkWith(new GetResponse());

        $response = $item->handler();

        return response()->json($response['message'], $response['code']);
    }

    public function deleteItem(Request $request)
    {
        $item = new DeleteItemValidator($request);
        $item->linkWith(new DeleteItem())
            ->linkWith(new GetResponse());

        $response = $item->handler();

        return response()->json($response['message'], $response['code']);
    }
}
