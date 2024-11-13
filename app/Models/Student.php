<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'student_number',
        'course_department_id',
        'year',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function courseDepartment() {
        return $this->belongsTo(CourseDepartment::class);
    }
}
