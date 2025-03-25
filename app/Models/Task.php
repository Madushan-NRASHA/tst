<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'user_id',
        'task_name',
        'status',
        'Coordinator_status',
        'priority',
        'allocated_by',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'department_id',
        'task_site',   
        'Duration_time',
        'Extra_time',
        'task_reason'
        //  'remarks'
        // 'qty',
        // 'task_type'       
    ];

//  protected $casts = [
//         'extra_time' => 'string',
//         'start_date' => 'date',
//         'end_date' => 'date',
//     ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function allocatedBy()
    {
        return $this->belongsTo(User::class, 'allocated_by');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
