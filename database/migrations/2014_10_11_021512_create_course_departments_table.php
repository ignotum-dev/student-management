<?php

use App\Models\Course;
use App\Models\Department;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Course::class)
                ->constrained()
                ->onDelete('cascade');
            $table->foreignIdFor(Department::class)
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_departments');
    }
};
