<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('student_number');
            $table->string('name');
            $table->string('first_name');
            $table->string('middle_name')->nullable()->default('-');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignIdFor(Course::class)->constrained()->onDelete('cascade');
            $table->enum('year', ['First Year', 'Second Year', 'Third Year', 'Fourth Year']);
            $table->date('dob');
            $table->unsignedTinyInteger('age');
            $table->enum('sex', ['Male', 'Female']);
            $table->string('c_address');
            $table->string('h_address');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
