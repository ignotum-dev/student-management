<?php

use App\Models\CourseDepartment;
use App\Models\Role;
use App\Models\User;
use App\Models\Course;
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->unique()
                ->constrained()
                ->onDelete('cascade');
            $table->string('student_number')->unique();
            $table->foreignIdFor(CourseDepartment::class)
                ->constrained()
                ->onDelete('cascade');
            $table->enum('year', ['First Year', 'Second Year', 'Third Year', 'Fourth Year']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
