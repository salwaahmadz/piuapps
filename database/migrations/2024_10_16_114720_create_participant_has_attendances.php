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
        Schema::create('participant_has_attendances', function (Blueprint $table) {
            $table->foreignId('attendance_id')->constrained(table: 'attendances', indexName: 'pivot_attendance_id');
            $table->foreignId('participant_id')->constrained(table: 'participants', indexName: 'pivot_participant_id');
            $table->string('status');
            $table->tinyInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participant_has_attendances');
    }
};
