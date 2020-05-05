<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Model\EntityType;

class CreateTypeEntityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('active', 1)->default('Y');
            $table->string('name', 255);
            $table->string('code', 50)->nullable();
            $table->text('description')->nullable();
            $table->text('params')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamps();
        });

        EntityType::create([
            'name' => 'Автомойка самообслуживания',
            'code' => 'selfservice',
        ]);
        EntityType::create([
            'name' => 'Безконтактная',
            'code' => 'contactless',
        ]);
        EntityType::create([
            'name' => 'Ручная мойка',
            'code' => 'manual',
        ]);
        EntityType::create([
            'name' => 'Портальная',
            'code' => 'portal',
        ]);
        EntityType::create([
            'name' => 'Тунельная',
            'code' => 'tunnel',
        ]);
        EntityType::create([
            'name' => 'Сухая',
            'code' => 'dry',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entity_types');
    }
}
