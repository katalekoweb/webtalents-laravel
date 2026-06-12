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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->uuid()->nullable();
            $table->foreignId("creator_id")->nullable()->constrained("users")->nullOnDelete()->comment("From user table");
            $table->foreignId("tenant_id")->constrained()->cascadeOnDelete();
            $table->string("title");
            $table->longText("description")->nullable();
            $table->date("due_date")->nullable();

            $table->foreignId("country_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("state_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("city_id")->nullable()->constrained()->nullOnDelete();

            $table->boolean("only_in_place")->default(false);
            $table->boolean("is_remote")->default(false);
            $table->boolean("offer_visa")->default(false);
            $table->boolean("is_published")->default(false);
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
        Schema::dropIfExists('vancacies');
    }
};
