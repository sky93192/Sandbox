<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('pic', 255); // 圖片網址
            $table->text('desc')->nullable(); // 商品描述
            $table->integer('price')->default(0)->unsigned(); // 價格不得為負
            $table->timestamp('sell_at')->nullable();
            $table->boolean('enalbled')->default(true); // 預設有貨
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
