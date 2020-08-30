<?php

namespace App\Http\Controllers\Api\Controllers;

use App\Models\Api\MiddlewareChain\Category\AddCategoryToItem;
use App\Models\Api\MiddlewareChain\Category\AddCategoryToItemValidator;
use App\Models\Api\MiddlewareChain\Category\CreateCategory;
use App\Models\Api\MiddlewareChain\Category\CreateCategoryValidator;
use App\Models\Api\MiddlewareChain\Category\GetAllCategories;
use App\Models\Api\MiddlewareChain\General\GetResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function createCategory(Request $request)
    {
        $category = new CreateCategoryValidator($request);
        $category->linkWith(new CreateCategory())
            ->linkWith(new GetResponse());

        $response = $category->handler();
        return response()->json($response['message'], $response['code']);
    }

    public function addCategoryToItem(Request $request)
    {
        $category = new AddCategoryToItemValidator($request);
        $category->linkWith(new AddCategoryToItem())
            ->linkWith(new GetResponse());

        $response = $category->handler();
        return response()->json($response['message'], $response['code']);
    }

    public function deleteCategoryFromItem(Request $request)
    {

    }

    public function getAllCategory()
    {
        $category = new GetAllCategories();
        $category->linkWith(new GetResponse());

        $response = $category->handler();
        return response()->json($response['message'], $response['code']);
    }

    public function updateCategory(Request $request)
    {

    }

    public function deleteCategory(Request $request)
    {

    }

}
