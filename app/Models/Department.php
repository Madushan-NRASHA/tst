<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments'; // Ensure this matches your database table name
    protected $fillable = ['get_Department']; // Update this to match the fields in your table

    /**
     * Define the relationship to the User model.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'department_id', 'id');
    }
    public function task()
    {
        return $this->hasMany(Task::class, 'department_id', 'id');
    }
    public function UserActivity()
    {
        return $this->belongsTo(Activity::class, 'user_id', 'id');
    }
}
