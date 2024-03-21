<?php

use Codelab\Teams\Enums\Status;
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
        Schema::create('member_team', function (Blueprint $table) {
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
            $table->string('memberable_type');
            $table->integer('memberable_id')->primary();
            $table->integer('status')->default(Status::ACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_team');
    }
};
