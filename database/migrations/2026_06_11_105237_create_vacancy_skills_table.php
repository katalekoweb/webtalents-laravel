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
        Schema::create('vacancy_skills', function (Blueprint $table) {
            $table->id();
            $table->uuid()->nullable();
            $table->foreignId("creator_id")->nullable()->constrained("users")->nullOnDelete()->comment("From user table");
            $table->foreignId("tenant_id")->constrained()->cascadeOnDelete();
            $table->foreignId("vacancy_id")->constrained()->cascadeOnDelete();
            $table->foreignId("skill_id")->constrained()->cascadeOnDelete();
            $table->integer("min_experience_years")->default(0);
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
        Schema::dropIfExists('vancacy_skills');
    }
};
