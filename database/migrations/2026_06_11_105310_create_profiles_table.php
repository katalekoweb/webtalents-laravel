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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->uuid()->nullable();
            $table->foreignId("creator_id")->nullable()->constrained("users")->nullOnDelete()->comment("From user table");
            $table->foreignId("user_id")->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId("tenant_id")->nullable()->constrained()->cascadeOnDelete();
            $table->string("title");
            $table->text("about")->nullable();
            $table->string("photo")->nullable();
            $table->string("email")->nullable();
            $table->string("phone")->nullable();
            $table->string("website")->nullable();

            $table->foreignId("country_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("state_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("city_id")->nullable()->constrained()->nullOnDelete();
            $table->string("address")->nullable();

            $table->string("linkedin")->nullable();
            $table->string("whatsapp")->nullable();
            $table->string("lang")->default("pt");
            $table->integer("order")->default(1);
            $table->boolean("is_human")->default(true);

            $table->decimal("min_salary")->default(0);
            $table->boolean("iam_pwd")->default(false);
            $table->boolean("only_remote")->default(false);

            $table->boolean("is_default")->default(false);
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
        Schema::dropIfExists('profiles');
    }
};
