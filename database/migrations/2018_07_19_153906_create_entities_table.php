<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Entity;

class CreateEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('active', 1)->default('Y');
            $table->string('name');

            $table->dateTime('active_from')->nullable();
            $table->dateTime('active_to')->nullable();

            $table->tinyInteger('sort')->unsigned()->default(100);
            $table->string('code');

            $table->integer('preview_picture')->unsigned()->nullable();
            $table->text('preview_text')->nullable();

            $table->tinyInteger('detail_picture')->unsigned()->nullable();
            $table->text('detail_text')->nullable();

            $table->string('phone', 20)->nullable();

            $table->string('xml_id')->nullable();
            $table->text('params')->nullable();

            $table->string('location');
            $table->string('user_id');

            $table->string('type_entity')->nullable();
            $table->string('host')->nullable();
            $table->string('apikey')->nullable();
            $table->char('simple', 1)->nullable();

            $table->string('step_cost', 4)->nullable();
            $table->string('limit_min_cost', 5)->nullable();

            $table->integer('commission')->unsigned()->nullable();

            $table->string('status', 1)->nullable()->default('F');

            $table->timestamps();
        });

        Entity::create([
            'name' => 'Наименование объекта 1',
            'code' => 'objec1',
            'preview_text' => 'г.Мытищи, ул. Летная 30/к1
Время работа: пн-пт с 8:30-21:00',
            'detail_text' => 'Проводятся акции!!!',
            'phone' => '9798798798',
            'created_by' => '1',
            'location' => '55.907200, 37.719025',
            'user_id' => '1',
        ]);

        Entity::create([
            'name' => 'Наименование объекта 2',
            'code' => 'objec2',
            'preview_text' => 'улица Борисовка, 8
Мытищи, Московская область, Россия, 141021
График работы: пн-пт круглосуточно',
            'detail_text' => 'Проводятся акции!!!',
            'phone' => '9879879897',
            'created_by' => '1',
            'location' => '55.911966, 37.706569',
            'user_id' => '1',
        ]);

        Entity::create([
            'name' => 'Наименование объекта 3',
            'code' => 'objec3',
            'preview_text' => 'улица Борисовка, 4А
Мытищи, Московская область, Россия, 141021',
            'detail_text' => '',
            'phone' => '9798798798',
            'created_by' => '1',
            'location' => '55.908627, 37.705614',
            'user_id' => '1',
        ]);

        Entity::create([
            'name' => 'Наименование объекта 4',
            'code' => 'objec4',
            'preview_text' => 'улица Мира, с51
Мытищи, Московская область, Россия',
            'detail_text' => 'Проводятся акции!!!',
            'phone' => '9798798798',
            'created_by' => '1',
            'location' => '55.920214, 37.706933',
            'user_id' => '1',
        ]);

        Entity::create([
            'name' => 'Наименование объекта 5',
            'code' => 'objec5',
            'preview_text' => 'проспект Мира, 101с1
Москва, Россия, 129085
График работы: пн-ср, круглосуточно.',
            'detail_text' => '',
            'phone' => '9798798798',
            'created_by' => '1',
            'location' => '55.812008, 37.636464',
            'user_id' => '1',
        ]);

        Entity::create([
            'name' => 'Наименование объекта 6',
            'code' => 'objec6',
            'preview_text' => 'Ярославское шоссе, 109к1
Москва, Россия, 129337',
            'detail_text' => '',
            'phone' => '9798798798',
            'created_by' => '1',
            'location' => '55.869818, 37.707826',
            'user_id' => '1',
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entities');
    }

}
