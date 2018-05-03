<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->integer('customer_id')->unsigned();
            $table->date('date');
            $table->date('due_date');
            $table->string('reference')->nullable();
            $table->text('terms_and_conditions');
            $table->double('sub_total')->comment('原价');
            $table->double('discount')->default(0)->comment('折扣');
            $table->double('total')->comment('现价');
            $table->timestamps();
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned();
            $table->integer('product_id')->unsigend();
            $table->double('unit_price')->comment('单价');
            $table->integer('qty')->comment('数量');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `invoices` comment'发票表'");
        DB::statement("ALTER TABLE `invoice_items` comment'发票明细表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoice_items');

    }
}
