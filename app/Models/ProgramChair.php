<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramChair extends Model
{
    use HasFactory;

    public function user() {
        return $this->hasOne(User::class);
    }

    public function program() {
        return $this->hasOne(Program::class);
    }

    public function department() {
        return $this->hasOne(Department::class);
    }
}
