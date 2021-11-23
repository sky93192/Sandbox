<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    // 商品被加入哪筆訂單
    public function orders(){
        return $this->belongsToMany(\App\Models\Order::class)->withTimestamps();
    }
}
