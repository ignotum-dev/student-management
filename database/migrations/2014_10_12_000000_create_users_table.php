<?php

use App\Models\Role;
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

            $table->foreignIdFor(Role::class)
                ->constrained()
                ->onDelete('cascade');

            $table->foreignIdFor(Course::class)
                ->constrained()
                ->onDelete('cascade');

            $table->string('student_number')->unique();
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->default('-');
            $table->string('last_name',50);

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            $table->enum('year', ['First Year', 'Second Year', 'Third Year', 'Fourth Year']);
            
            $table->date('dob');
            $table->unsignedTinyInteger('age');
            $table->enum('sex', ['Male', 'Female']);

            $table->string('c_address', 255);
            $table->string('h_address', 255);

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
