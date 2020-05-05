<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Group;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->char('active', 1)->default('Y');
            $table->tinyInteger('sort')->unsigned()->default(100);
            $table->text('text')->nullable();
            $table->timestamps();
        });

        Group::create([
            'name' => 'Администратор',
            'text' => 'Группа администрирования',
        ]);
        Group::create([
            'name' => 'Зарегистрированные пользователи',
            'text' => 'Зарегистрированные пользователи',
        ]);
        Group::create([
            'name' => 'Пользователи, имеющие право управления',
            'text' => 'Данная группа позволяет управлять инфоблоками',
        ]);
        Group::create([
            'name' => 'Пользователи, имеющие право просмотра',
            'text' => 'Пользователи, имеющие право просмотра',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
