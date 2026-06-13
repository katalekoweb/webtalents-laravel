<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vacancy_languages', function (Blueprint $table) {
            $table->id();
            $table->uuid()->nullable();
            $table->foreignId("creator_id")->nullable()->constrained("users")->nullOnDelete()->comment("From user table");
            $table->foreignId("tenant_id")->constrained()->cascadeOnDelete();
            $table->foreignId("vacancy_id")->constrained()->cascadeOnDelete();
            $table->foreignId("language_id")->constrained()->cascadeOnDelete();
            $table->enum("level", ['basic', 'intermediate', 'advanced', 'native'])->default('intermediate');
            $table->boolean("is_required")->default(false);
            $table->boolean("is_active")->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancy_languages');
    }
};
