<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vacancy_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vacancy_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('cover_letter');
            $table->string('cv');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('vacancy_applications');
    }
};
