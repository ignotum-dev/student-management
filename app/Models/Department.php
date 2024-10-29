<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function dean() {
        return $this->hasMany(Dean::class);
    }

    public function course() {
        return $this->hasMany(Course::class);
    }
}
