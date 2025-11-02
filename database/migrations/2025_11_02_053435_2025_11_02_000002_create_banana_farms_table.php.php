<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
public function up()
{
Schema::create('banana_farms', function (Blueprint $table) {
$table->id();
$table->string('farm_name')->nullable();
$table->integer('total_trees')->default(0);
$table->integer('fruiting_trees')->default(0);
$table->integer('sick_trees')->default(0);
$table->integer('dead_trees')->default(0);
$table->date('recorded_at')->nullable();
$table->text('notes')->nullable();
$table->timestamps();
});
}


public function down()
{
Schema::dropIfExists('banana_farms');
}
};
