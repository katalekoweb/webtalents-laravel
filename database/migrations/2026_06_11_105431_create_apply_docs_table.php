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
        Schema::create('apply_docs', function (Blueprint $table) {
            $table->id();
            $table->uuid()->nullable();
            $table->foreignId("creator_id")->nullable()->constrained("users")->nullOnDelete()->comment("From user table");
            $table->foreignId("tenant_id")->constrained()->cascadeOnDelete();
            $table->foreignId("vacancy_id")->constrained()->cascadeOnDelete();
            $table->foreignId("apply_id")->constrained()->cascadeOnDelete();
            $table->foreignId("vacancy_doc_id")->constrained()->cascadeOnDelete();
            $table->string("doc_path");
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
        Schema::dropIfExists('apply_docs');
    }
};
