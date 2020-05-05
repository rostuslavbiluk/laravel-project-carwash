<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\ServiceList;

class CreateServiceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('active', 1)->default('Y');
            $table->string('name');

            $table->integer('category_id', 3)->unsigned()->nullable();

            $table->dateTime('active_from')->nullable();
            $table->dateTime('active_to')->nullable();

            $table->tinyInteger('sort')->unsigned()->default(100);
            $table->string('code')->nullable();

            $table->tinyInteger('preview_picture')->unsigned()->nullable();
            $table->text('preview_text')->nullable();

            $table->tinyInteger('detail_picture')->unsigned()->nullable();
            $table->text('detail_text')->nullable();

            $table->string('xml_id')->nullable();
            $table->text('params')->nullable();

            $table->timestamps();
        });

        ServiceList::create([
            'name' => 'Услуга 1',
            'code' => 'usluga1',
            'preview_text' => 'Краткое описание услуги 1',
            'detail_text' => 'Детальное описание услуги 1',
        ]);
        ServiceList::create([
            'name' => 'Услуга 2',
            'code' => 'usluga2',
            'preview_text' => 'Краткое описание услуги 2',
            'detail_text' => 'Детальное описание услуги 2',
        ]);
        ServiceList::create([
            'name' => 'Услуга 3',
            'code' => 'usluga3',
            'preview_text' => 'Краткое описание услуги 3',
            'detail_text' => 'Детальное описание услуги 3',
        ]);
        ServiceList::create([
            'name' => 'Услуга 4',
            'code' => 'usluga4',
            'preview_text' => 'Краткое описание услуги 4',
            'detail_text' => 'Детальное описание услуги 4',
        ]);
        ServiceList::create([
            'name' => 'Услуга 5',
            'code' => 'usluga5',
            'preview_text' => 'Краткое описание услуги 5',
            'detail_text' => 'Детальное описание услуги 5',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_lists');
    }
}
