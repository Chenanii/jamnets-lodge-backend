<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
public function up(): void
{
Schema::create('rooms', function (Blueprint $table) {
$table->id();
$table->string('title');
$table->string('slug')->unique();
$table->enum('type', ['standard', 'junior', 'class', 'deluxe']);
$table->text('features')->nullable();
$table->decimal('price', 10, 2);
$table->integer('capacity')->nullable();
$table->enum('status', ['available', 'unavailable', 'maintenance'])->default('available');
$table->timestamps();
});
}


public function down(): void
{
Schema::dropIfExists('rooms');
}
};