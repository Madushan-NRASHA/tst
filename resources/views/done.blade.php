@extends('layouts.user', ['main_page' => 'yes'])

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Task Dashboard</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Display Warning Message (if exists) -->
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Completed Tasks</h3>
                        </div>
                        <div class="card-body">
                            <!-- Show a message if there are no completed tasks -->
                            @if($tasks->isEmpty())
                                <div class="alert alert-info">
                                    No completed tasks found.
                                </div>
                            @else
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Task Description</th>
                                            <th>Priority</th>
                                            <th>Allocated By</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Duration</th>
                                            <th>Extra Time</th>
                                            <th>Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tasks as $task)
                                            <tr>
                                                <td>{{ $task->task_site }}</td>
                                                <td>{{ $task->task_name }}</td>
                                                <td>{{ $task->priority }}</td>
                                                <td>{{ $task->allocatedBy->name ?? 'Not specified' }}</td>
                                                <td>{{ $task->start_date }}</td>
                                                <td>{{ $task->end_date }}</td>
                                                <td>{{ $task->start_time }}</td>
                                                <td>{{ $task->end_time }}</td>
                                                <td>{{ $task->Duration_time }}</td>
                                                <td>{{ $task->Extra_time }}</td>
                                                <td>{{ $task->reason ?? $task->task_reason }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
