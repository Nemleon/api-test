<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['item_id', 'name', 'description'];

    static function updateItem($itemId, array $params)
    {
        try {
            Item::where('item_id', $itemId)
                ->update($params);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}
