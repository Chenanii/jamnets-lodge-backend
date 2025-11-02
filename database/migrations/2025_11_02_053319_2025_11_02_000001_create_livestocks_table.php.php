<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
public function up()
{
Schema::create('livestocks', function (Blueprint $table) {
$table->id();
$table->string('type'); // e.g. cattle, goats, chickens
$table->integer('total_count')->default(0);
$table->integer('alive_count')->default(0);
$table->integer('sick_count')->default(0);
$table->integer('dead_count')->default(0);
$table->date('recorded_at')->nullable(); // optional date for the snapshot
$table->text('notes')->nullable();
$table->timestamps();
});
}


public function down()
{
Schema::dropIfExists('livestocks');
}
};