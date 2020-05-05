<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToRequisitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisites', function (Blueprint $table) {
            $table->integer('entity_id')->unsigned()->default(1);
            $table->foreign('entity_id')->references('id')->on('entities');
            $table->string('type')->nullable();
            $table->string('inn')->nullable();
            $table->string('kpp')->nullable();
            $table->string('ogrn')->nullable();
            $table->string('postcode1')->nullable();
            $table->string('address1')->nullable();
            $table->string('postcode2')->nullable();
            $table->string('address2')->nullable();
            $table->string('bik', 20)->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('kor_account')->nullable();
            $table->string('ras_account')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('type_nds')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
