<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Model\Payment;

class CreatePaymentOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('active', 1)->default('Y');
            $table->string('name');
            $table->string('code');
            $table->tinyInteger('sort')->unsigned()->default(100);
            $table->tinyInteger('picture')->unsigned()->nullable();
            $table->text('description')->nullable();
            $table->string('xml_id')->nullable();
            $table->text('params')->nullable();
            $table->timestamps();
        });

        Payment::created([
            'name' => 'Оплата картой',
            'code' => 'card',
            'sort' => '100',
        ]);
        Payment::create([
            'name' => 'Списать со счета',
            'code' => 'bill',
            'sort' => '200',
        ]);
        Payment::create([
            'name' => 'Наличные',
            'code' => 'cash',
            'sort' => '300',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
