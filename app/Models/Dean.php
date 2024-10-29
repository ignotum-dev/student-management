<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dean extends Model
{
    use HasFactory;

    public function user() {
        return $this->hasOne(User::class);
    }

    public function department() {
        return $this->hasOne(Department::class);
    }
}
