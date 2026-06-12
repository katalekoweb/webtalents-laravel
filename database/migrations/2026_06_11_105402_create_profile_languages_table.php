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
        Schema::create('profile_languages', function (Blueprint $table) {
            $table->id();
            $table->uuid()->nullable();
            $table->foreignId("creator_id")->nullable()->constrained("users")->nullOnDelete()->comment("From user table");
            $table->foreignId("user_id")->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId("profile_id")->constrained()->cascadeOnDelete();
            $table->foreignId("language_id")->constrained()->cascadeOnDelete();
            $table->integer("level")->default(1);
            $table->integer("order")->default(1);
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
        Schema::dropIfExists('profile_languages');
    }
};
