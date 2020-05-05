<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Cities;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('code');
            $table->char('active', 1)->default('Y');
            $table->tinyInteger('sort')->unsigned()->default(100);
            $table->string('xml_id')->nullable();
            $table->text('params')->nullable();
            $table->timestamps();
        });

        Cities::create([
            'name' => 'Москва',
            'code' => 'moscow',
        ]);
        Cities::create([
            'name' => 'Мытищи',
            'code' => 'mytischi',
        ]);
        Cities::create([
            'name' => 'Пушкино',
            'code' => 'pushkino',
        ]);
        Cities::create([
            'name' => 'Королев',
            'code' => 'korolev',
        ]);
        Cities::create([
            'name' => 'Химки',
            'code' => 'himki',
        ]);
        Cities::create([
            'name' => 'Долгопрудный',
            'code' => 'dolgoprudnuy',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
