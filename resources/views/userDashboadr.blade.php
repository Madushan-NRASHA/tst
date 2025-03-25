@extends('layouts.user', ['main_page' => 'yes'])

@section('content')
    <style>
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0; }
            100% { opacity: 1; }
        }

        .blinking-alert {
            animation: blink 1s infinite;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1></h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        @if ($task = $expireTime->first())
            <div class="alert alert-danger blinking-alert alert-dismissible fade show" role="alert">
                <strong>Warning!</strong> Your task <b>{{ $task->task_name }}</b> has expired.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Main content -->
        <div class="container mt-4">
            <div class="row">
                <!-- Today's Tasks Table -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Today's Tasks</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Task</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $today = \Carbon\Carbon::today();
                                            $yesterday = \Carbon\Carbon::yesterday();
                                        @endphp

                                        @foreach($todayTasks->groupBy('user_id') as $userId => $tasks)
                                            @foreach($tasks as $task)
                                                @if(\Carbon\Carbon::parse($task->start_date)->isToday())
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $task->task_name }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($task->start_date)->format('Y-m-d') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($task->end_date)->format('Y-m-d') }}</td>
                                                        <td class="align-middle">
                                                            <span class="badge bg-primary">Ongoing</span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach

                                        @foreach($todayTasks->groupBy('user_id') as $userId => $tasks)
                                            @foreach($tasks as $task)
                                                @if(\Carbon\Carbon::parse($task->start_date)->isYesterday())
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $task->task_name }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($task->start_date)->format('Y-m-d') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($task->end_date)->format('Y-m-d') }}</td>
                                                        <td class="align-middle">
                                                            <span class="badge bg-warning">Yesterday</span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach

                                        @if($todayTasks->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center">No tasks for today</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expired Tasks Table -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">Pending Tasks</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Task</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($expiredTasks->groupBy('user_id') as $userId => $tasks)
                                            @foreach($tasks as $task)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $task->task_name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($task->start_date)->format('Y-m-d') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($task->end_date)->format('Y-m-d') }}</td>
                                                    <td class="align-middle">
                                                        <span class="badge bg-danger">Pending</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No pending tasks found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
