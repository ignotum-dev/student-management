<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseDepartment extends Model
{
    use HasFactory;

    public function students() {
        return $this->hasMany(Student::class);
    }

    public function programChair() {
        return $this->hasMany(ProgramChair::class);
    }

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }
}
