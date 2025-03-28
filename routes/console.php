<?php

use App\Console\Commands\CheckDueTasks;
use Illuminate\Support\Facades\Schedule;


Schedule::command(CheckDueTasks::class)->dailyAt('15:14');
