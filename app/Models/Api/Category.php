<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    protected $fillable = ['category_id', 'name', 'description'];

    static public function getAllCategories()
    {
        try {
            return DB::table('categorys')->select('category_id', 'name', 'description')->get();
        } catch (\Exception $e) {
            return false;
        }

    }

    static public function createCategory($params)
    {
        try {
            DB::table('categorys')
                ->insert([
                    'category_id' => $params['category_id'],
                    'name' => $params['name'],
                    'description' => $params['description']
                ]);

            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
