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
                            <h3 class="card-title">Pending Tasks</h3>
                        </div>
                        <div class="card-body">
                            <!-- Show a message if there are no pending tasks -->
                            @if($tasks->isEmpty())
                                <div class="text-center py-4">
                                    <h5 class="text-muted">No pending tasks available.</h5>
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
                                            <th>Status</th>
                                            <th>Action</th>
                                            <th>Coordinator Status</th>
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
                                                <td>
                                                    <span class="badge bg-warning">Pending</span>
                                                </td>
                                                <td>
                                                    <!-- Mark as Done -->
                                                    <form action="{{ route('userTask', ['task' => $task->id]) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="Done">
                                                        <button type="submit" class="btn btn-success btn-sm">Mark Done</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $task->Coordinator_status == 'Done' ? 'success' : ($task->Coordinator_status == 'pending' ? 'warning' : 'secondary') }}">
                                                        {{ ucfirst($task->Coordinator_status) }}
                                                    </span>
                                                </td>
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
