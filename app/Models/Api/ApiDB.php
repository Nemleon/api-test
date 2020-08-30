<?php

namespace App\Models\Api;

use Illuminate\Support\Facades\DB;

class ApiDB
{
    public function createItem($params)
    {
        try {
            DB::table('items')
                ->insert([
                    'item_id' => $params['item_id'],
                    'name' => $params['name'],
                    'description' => $params['description']
                ]);

            if (isset($params['category_id'])) {
                DB::table('assoc')
                    ->insert([
                        'item' => $params['item_id'],
                        'category' => $params['category_id']
                    ]);
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getItem($params)
    {
        try {
            return DB::table('items as i')
                ->select('i.item_id', 'i.name as itemName', 'i.description', 'c.category_id', 'c.name as categoryName')
                ->join('assoc as a', 'i.item_id', '=', 'a.item')
                ->join('categorys as c', 'c.category_id', '=', 'a.category')
                ->where('item_id', '=', $params['item_id'])
                ->get();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getItemsFromCategory($params)
    {
        try {
            return DB::table('items as i')
                ->select('i.item_id', 'i.name as itemName', 'i.description', 'c.category_id', 'c.name as categoryName')
                ->join('assoc as a', 'i.item_id', '=', 'a.item')
                ->join('categorys as c', 'c.category_id', '=', 'a.category')
                ->where('c.category_id', '=', $params['category_id'])
                ->get();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteCategoriesInItem($params)
    {
        try {
            DB::table('assoc')
                ->where('item', '=', $params['item_id'])
                ->delete();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteItem($params)
    {
        try {
            DB::table('items')->where('item_id', '=', $params['item_id'])->delete();
            DB::table('assoc')->where('item', '=', $params['item_id'])->delete();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function addCategoryToItem($params)
    {
        $check = DB::table('assoc')
            ->where('item', '=', $params['item_id'])
            ->where('category', '=', $params['category_id'])
            ->get();

        switch ($check->toArray()) {
            case [] :
                try {
                    DB::table('assoc')
                        ->insert([
                            'item' => $params['item_id'],
                            'category' => $params['category_id']
                        ]);
                    return true;
                } catch (\Exception $e) {
                    return false;
                }
                break;

            default :
                return null;
                break;
        }
    }
}
