<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'userType', 'department_id', 'Emp_id', 'user_img'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'two_factor_expires_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id', 'id');
    }

    public function subTask()
    {
        return $this->belongsTo(SubTask::class, 'user_id', 'id');
    }

    public function taskActivity()
    {
        return $this->hasMany(Activity::class, 'user_id', 'id');
    }

    public function generateOtp()
    {
        $otp = rand(100000, 999999);
        $this->two_factor_otp = bcrypt($otp);
        $this->two_factor_expires_at = now()->addMinutes(5);
        $this->save();

        return $otp;
    }
    // User model relationships

public function generalTasks()
{
    return $this->hasMany(GeneralTask::class, 'user_id');
}

public function allocatedTasks()
{
    return $this->hasMany(GeneralTask::class, 'allocated_by');
}


    public function verifyOtp($otp)
    {
        $isValid = Hash::check($otp, $this->two_factor_otp) && now()->lt($this->two_factor_expires_at);

        if ($isValid) {
            $this->two_factor_otp = null;
            $this->two_factor_expires_at = null;
            $this->save();
        }

        return $isValid;
    }
}


