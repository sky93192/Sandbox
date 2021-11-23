<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::create(['title'=>'牛仔褲', 'price'=>500, 'pic'=>'1.jpg']);
        Item::create(['title'=>'跑鞋', 'price'=>600, 'pic'=>'2.jpg']);
        Item::create(['title'=>'運動長褲', 'price'=>400, 'pic'=>'3.jpg']);
        Item::create(['title'=>'短褲', 'price'=>300, 'pic'=>'4.jpg']);
        Item::create(['title'=>'套裝1', 'price'=>1500, 'pic'=>'5.jpg']);
        Item::create(['title'=>'套裝2', 'price'=>800, 'pic'=>'6.jpg']);
        Item::create(['title'=>'品牌包', 'price'=>900, 'pic'=>'7.jpg']);
        Item::create(['title'=>'太陽眼鏡', 'price'=>1000, 'pic'=>'8.jpg']);
        Item::create(['title'=>'上衣', 'price'=>300, 'pic'=>'9.jpg']);
    }
}
