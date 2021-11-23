<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Item;
use App\Models\Order;
use Log;

class ShopPage extends Component
{
    public $items;
    public Order $order;

    // 創建時呼叫
    public function mount(){
        $this->items = Item::get();
        $order = Order::create(['user_id'=>1]);
        session(['order'=>$order]);
    }

    public function render()
    {
        return view('livewire.shop-page');
    }

    //加入購物車 $id為商品id
    public function addCart($id){
        Log::debug('addCart');

        $order = session()->get('order'); // 保留訂單狀態
        $this->order = Order::with('items')->findOrFail($order->id);
        $item = Item::findOrFail($id);
        $order->items()->save($item, ['qty'=>1]);
        $this->order = Order::with('items')->findOrFail($order->id);
    }
}
