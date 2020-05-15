<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderRecordItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_record_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_record_id');
            $table->foreign('order_record_id')
                  ->references('id')
                  ->on('order_record');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products');
            $table->decimal('price', 8, 2);
            $table->integer('quantity')->unsigned();
            $table->timestamps();
            $table->date('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_record_items');
    }
}
