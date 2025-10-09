<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vacancy_applications', function (Blueprint $table) {
            $table->enum('status', ['pending', 'shortlisted', 'accepted', 'rejected'])
                  ->default('pending')
                  ->after('cv'); // place after CV column
            $table->text('comments')->nullable()->after('status');
            $table->integer('score')->nullable()->after('comments');
        });
    }

    public function down(): void
    {
        Schema::table('vacancy_applications', function (Blueprint $table) {
            $table->dropColumn(['status', 'comments', 'score']);
        });
    }
};
