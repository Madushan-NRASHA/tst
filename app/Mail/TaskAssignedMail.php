<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class TaskAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    
    
    public function build()
// {
//     return $this->from(env('MAIL_FROM_ADDRESS'))
//         ->subject('New Task Assigned')
//         ->view('task_assigned')
//         ->with('task', $this->task);
// }

 {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('New Task Assigned - Keen Rabbit Task System')
            ->view('task_assigned')
            ->with([
                'task' => $this->task,
                'userName' => $this->task->user->name ?? 'User'
            ]);
    }
}