<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ExpiringTaskMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tasks;

    /**
     * Create a new message instance.
     */
    public function __construct($tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Tasks Expiring Soon')
            ->view('expiring-tasks');
    }
}

