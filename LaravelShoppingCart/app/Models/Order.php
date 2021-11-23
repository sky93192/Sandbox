<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    // 包含哪些商品
    public function items(){
        return $this->belongsToMany(\App\Models\Item::class)->withTimeStamps()->withPivot('qty'); // 在中介表抓數量
    }

    // 統計
    public function getSumAttribute(){
        $orderItems = $this->items;
        $sum = 0;
        foreach($orderItems as $item){
            $sum += ($item->price*$items->pivot->qty);
        }

        return $sum;
    }
}
