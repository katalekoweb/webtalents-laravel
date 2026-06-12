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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->uuid()->nullable();
            $table->foreignId("creator_id")->nullable()->constrained("users")->nullOnDelete()->comment("From user table");
            $table->string("name");
            $table->string("slug")->nullable()->unique();
            $table->string("domain")->nullable()->unique();
            $table->string("email")->nullable();
            $table->string("phone")->nullable();
            $table->string("website")->nullable();

            $table->foreignId("country_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("state_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("city_id")->nullable()->constrained()->nullOnDelete();
            $table->string("address")->nullable();
            $table->string("linkedin")->nullable();
            $table->string("whatsapp")->nullable();
            $table->text("about")->nullable();
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
        Schema::dropIfExists('tenants');
    }
};
