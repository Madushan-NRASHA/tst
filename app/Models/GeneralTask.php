<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralTask extends Model
{
    use HasFactory;

    // Define the table name if it's different from the default 'general_tasks'
    protected $table = 'general_task';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'userType',
        'task_site',
        'task_name',
        'qty',
        'task_type',
        'status',
        'Coordinator_status',
        'priority',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'allocated_by',
        'department_id',
        'time_range',
        'general_task_type'
    ];

    // Define the relationship between GeneralTask and User
    // A task belongs to a user (assigned user)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the relationship between GeneralTask and User for allocated_by (who allocated the task)
    public function allocatedBy()
    {
        return $this->belongsTo(User::class, 'allocated_by');
    }

    // Define the relationship between GeneralTask and Department (optional if you use departments)
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}