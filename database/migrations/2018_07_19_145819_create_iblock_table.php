<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Iblock;

class CreateIblockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iblocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('active', 1)->default('Y');
            $table->string('name');
            $table->string('code');
            $table->tinyInteger('sort')->unsigned()->default('500');
            $table->tinyInteger('picture')->unsigned()->nullable();
            $table->text('description')->nullable();
            $table->string('xml_id')->nullable();
            $table->text('params')->nullable();
            $table->timestamps();
        });

        Iblock::create([
            'name' => 'Объекты',
            'code' => 'entities',
            'created_by' => '1',
        ]);
        Iblock::create([
            'name' => 'Тип оплаты',
            'code' => 'payment_option',
            'created_by' => '1',
        ]);
        Iblock::create([
            'name' => 'Города',
            'code' => 'cities',
            'created_by' => '1',
        ]);
        Iblock::create([
            'name' => 'Группы пользователей',
            'code' => 'user_group',
            'created_by' => '1',
        ]);
        Iblock::create([
            'name' => 'Услуги',
            'code' => 'service_list',
            'created_by' => '1',
        ]);
        Iblock::create([
            'name' => 'Пользователи',
            'code' => 'user',
            'created_by' => '1',
        ]);
        Iblock::create([
            'name' => 'Бренд',
            'code' => 'brands',
            'created_by' => '1',
        ]);
        Iblock::create([
            'name' => 'Организации',
            'code' => 'organizations',
            'created_by' => '1',
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('iblocks');
    }
}
