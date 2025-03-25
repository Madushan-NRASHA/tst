<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subTask extends Model
{
    use HasFactory;

    public function task(){
        return $this->belongsTo(task::class);
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
