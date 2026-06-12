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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->uuid()->nullable();
            $table->foreignId("creator_id")->nullable()->constrained("users")->nullOnDelete()->comment("From user table");
            $table->foreignId("user_id")->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId("profile_id")->constrained()->cascadeOnDelete();
            $table->string("title");
            $table->string("company")->nullable();
            $table->string("key_skills")->nullable();
            $table->string("role")->nullable();
            $table->text("about")->nullable();
            $table->boolean("current_here")->default(false);
            $table->date("start_date")->nullable();
            $table->date("finish_date")->nullable();
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
        Schema::dropIfExists('experiences');
    }
};
