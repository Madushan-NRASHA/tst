@extends('layouts.fronts', ['main_page' => 'yes'])
@section('content')

<style>
    /* Department card styling */
    .department-card .card-header {
        background: linear-gradient(45deg, var(--dept-color), var(--dept-color-light)) !important;
    }

    /* Add spacing */
    .row {
        margin-bottom: 20px;
    }

    .card {
        margin-bottom: 20px;
    }

    /* Table improvements */
    .table th {
        background-color: #f8f9fa;
    }

    .table td {
        vertical-align: middle;
    }

    /* Badge styling */
    .badge {
        padding: 8px 12px;
    }
    .task-section {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }

    .task-card {
        flex: 1;
        min-width: 300px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .task-header {
        padding: 15px;
        font-size: 18px;
        font-weight: bold;
        color: white;
    }

    .task-body {
        padding: 15px;
    }

    .task-list {
        list-style-position: inside;
        padding: 0;
        margin: 0;
    }

    .task-item {
        padding: 10px;
        border-bottom: 1px solid #eee;
        margin: 5px 0;
    }

    .task-item:last-child {
        border-bottom: none;
    }

    .task-details {
        margin-top: 5px;
        font-size: 0.9em;
        color: #666;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .task-user, .task-date {
        display: inline-block;
        margin-right: 10px;
    }

    .no-tasks {
        color: #666;
        font-style: italic;
        text-align: center;
        padding: 10px;
    }

    /* Department card colors */
    .department-card .card-header {
        background: linear-gradient(45deg, var(--dept-color), var(--dept-color-light)) !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .task-section {
            flex-direction: column;
        }

        .task-card {
            width: 100%;
        }
    }
    </style>


<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Task Management</h1>
                </div>
            </div>
        </div>
    </section>
    <div class="Today-Task">
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Post Table</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Task Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($todayAllTasks as $todayTask)
                                    <tr>
                                        <td>{{ $todayTask->user->name ?? 'N/A' }}</td>
                                        <td>{{ $todayTask->task_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($todayTask->start_date)->format('Y-m-d H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($todayTask->end_date)->format('Y-m-d H:i') }}</td>
                                        <td>
                                            @if($todayTask->status === 'Done')
                                                <button class="btn btn-success" disabled>
                                                    <i class="fa-solid fa-check me-2"></i> Task Completed
                                                </button>
                                            @elseif($todayTask->status === 'pending')
                                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $todayTask->id }}, {{ $todayTask->user_id }})">
                                                    Not Done
                                                </button>
                                            @else
                                                <button class="btn btn-warning" disabled>
                                                    <i class="fa-solid fa-clock me-2"></i> Task Pending
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No tasks found for today.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Task Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Pagination Controls -->
                        <div class="d-flex justify-content-center">
                        {{ $todayAllTasks->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


</div>
    <!-- Main content -->
    <div class="container-fluid">
        <!-- Current Date Display -->
        <div class="alert alert-info">
            Current Date: {{ $now->format('Y-m-d H:i:s') }}
        </div>

        <!-- Kanban Board -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Department Overview</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($departments as $department)
                                <div class="col-md-4 mb-4">
                                    <div class="card department-card">
                                        <div class="card-header text-white">
                                            {{ $department->get_Department }}
                                        </div>
                                        <div class="card-body">
                                            <h6 style="font-weight: bold;">Users</h6>
                                            <ul class="list-unstyled">
                                                @foreach($department->users as $user)
                                                    <li class="mb-2">{{ $user->name }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('coordinator.filter.tasks') }}" class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="user_name" class="form-control" placeholder="Filter by User Name">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="start_date" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="end_date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Task Tables -->
        <div class="task-section">

<div class="task-card">
<div class="task-header bg-primary">
    Today's Tasks ({{ $todayTasks->count() }})
</div>
<div class="task-body">
    <ol class="task-list" id="task-list">
        @forelse($todayTasks as $index => $task)
            <li class="task-item {{ $index >= 5 ? 'hidden-task' : '' }}">
                <strong>{{ $task->task_name }}</strong>
                <div class="task-details">
                    <span class="task-user">Assigned to: {{ $task->user->name ?? 'N/A' }}</span>
                    <span class="task-date">Created: {{ $task->created_at->format('Y-m-d H:i') }}</span>
                </div>
            </li>
        @empty
            <p class="no-tasks">No tasks for today</p>
        @endforelse
    </ol>
    
    @if($todayTasks->count() > 5)
        <div class="text-center mt-3">
            <button id="see-more-btn" class="btn btn-sm btn-outline-primary">See More</button>
            <button id="show-less-btn" class="btn btn-sm btn-outline-primary" style="display: none;">Show Less</button>
        </div>
    @endif
</div>
</div>

<style>
.hidden-task {
    display: none;
}
</style>


<!-- Pending Tasks -->
<div class="task-card">
<div class="task-header bg-danger">
    Pending Tasks ({{ $pendingTasks->count() }})
</div>
<div class="task-body">
    <ol class="task-list" id="pending-task-list">
        @forelse($pendingTasks as $index => $task)
            <li class="task-item {{ $index >= 5 ? 'hidden-pending-task' : '' }}">
                <strong>{{ $task->task_name }}</strong>
                <div class="task-details">
                    <span class="task-user">Assigned to: {{ $task->user->name ?? 'N/A' }}</span>
                    <span class="task-date">Due: {{ $task->end_date }}</span>
                </div>
            </li>
        @empty
            <p class="no-tasks">No pending tasks</p>
        @endforelse
    </ol>
    
    @if($pendingTasks->count() > 5)
        <div class="text-center mt-3">
            <button id="see-more-pending-btn" class="btn btn-sm btn-outline-danger">See More</button>
            <button id="show-less-pending-btn" class="btn btn-sm btn-outline-danger" style="display: none;">Show Less</button>
        </div>
    @endif
</div>
</div>

<style>
.hidden-pending-task {
    display: none;
}
</style>


<!-- Completed Tasks -->
<div class="task-card">
<div class="task-header bg-success">
    Completed Tasks ({{ $completedTasks->count() }})
</div>
<div class="task-body">
    <ol class="task-list" id="completed-task-list">
        @forelse($completedTasks as $index => $task)
            <li class="task-item {{ $index >= 5 ? 'hidden-completed-task' : '' }}">
                <strong>{{ $task->task_name }}</strong>
                <div class="task-details">
                    <span class="task-user">Completed by: {{ $task->user->name ?? 'N/A' }}</span>
                    <span class="task-date">Completed: {{ $task->updated_at->format('Y-m-d H:i') }}</span>
                </div>
            </li>
        @empty
            <p class="no-tasks">No completed tasks</p>
        @endforelse
    </ol>
    
    @if($completedTasks->count() > 5)
        <div class="text-center mt-3">
            <button id="see-more-completed-btn" class="btn btn-sm btn-outline-success">See More</button>
            <button id="show-less-completed-btn" class="btn btn-sm btn-outline-success" style="display: none;">Show Less</button>
        </div>
    @endif
</div>
</div>

<style>
.hidden-completed-task {
    display: none;
}
</style>


</div>
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.all.min.js"></script>

<!-- jQuery CDN (if you plan to use jQuery) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    document.querySelectorAll('.department-card').forEach((card, index) => {
        const colors = [
            { main: '#4e73df', light: '#6f8be8' },
            { main: '#1cc88a', light: '#2ed8a1' },
            { main: '#f6c23e', light: '#f8cd60' },
            { main: '#e74a3b', light: '#eb6b5f' },
            { main: '#36b9cc', light: '#4fc9d9' }
        ];
        const colorIndex = index % colors.length;
        card.style.setProperty('--dept-color', colors[colorIndex].main);
        card.style.setProperty('--dept-color-light', colors[colorIndex].light);
    });
    </script>
   <script>
    function confirmDelete(taskId, userId) {
        Swal.fire({
            title: 'Time Entry',
            html: `
                <div id="task-form-container">
                    <form id="popupForm" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="task_id" value="${taskId}">
                        <input type="hidden" name="user_id" value="${userId}">

                        <div class="row mb-5">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="start-date" class="form-label">Start Date</label>
                                    <input type="date" id="start-date" name="start_date" class="form-control" required>
                                </div>
                                  <div class="col-6">
                                        <label for="end-date" class="form-label" style="position: relative; left: -448px;">End Date</label>
                                        <input type="date" id="end-date" name="end_date" class="form-control" required>
                                    </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold">Start Time:</label>
                                <div class="d-flex mt-2">
                                    <input type="number" id="start-hour" min="1" max="12" placeholder="HH" class="form-control w-25 me-2" required>
                                    <input type="number" id="start-minute" min="0" max="59" placeholder="MM" class="form-control w-25 me-2" required>
                                    <select id="start-period" class="form-select w-auto" required>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold">End Time:</label>
                                <div class="d-flex mt-2">
                                    <input type="number" id="end-hour" min="1" max="12" placeholder="HH" class="form-control w-25 me-2" required>
                                    <input type="number" id="end-minute" min="0" max="59" placeholder="MM" class="form-control w-25 me-2" required>
                                    <select id="end-period" class="form-select w-auto" required>
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <label class="fw-bold">Total Duration:</label>
                                <input type="text" id="duration-hour" value="0 hours 0 mins" readonly class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Save Times',
            didOpen: () => {
                function calculateDuration() {
                    const startDate = document.getElementById('start-date').value;
                    const endDate = document.getElementById('end-date').value;

                    const startHour = parseInt(document.getElementById('start-hour').value);
                    const startMinute = parseInt(document.getElementById('start-minute').value);
                    const startPeriod = document.getElementById('start-period').value;

                    const endHour = parseInt(document.getElementById('end-hour').value);
                    const endMinute = parseInt(document.getElementById('end-minute').value);
                    const endPeriod = document.getElementById('end-period').value;

                    if (startDate && endDate && !isNaN(startHour) && !isNaN(startMinute) && !isNaN(endHour) && !isNaN(endMinute)) {
                        // Convert 12-hour format to 24-hour format
                        let startH = startHour % 12 + (startPeriod === "PM" ? 12 : 0);
                        let endH = endHour % 12 + (endPeriod === "PM" ? 12 : 0);

                        // Convert dates and times to minutes
                        const startDateTime = new Date(`${startDate} ${startH}:${startMinute}`);
                        const endDateTime = new Date(`${endDate} ${endH}:${endMinute}`);

                        // Calculate duration in minutes
                        let durationMinutes = (endDateTime - startDateTime) / 60000;

                        if (durationMinutes < 0) {
                            durationMinutes += 24 * 60; // Handle cases where the time spans past midnight
                        }

                        const durationHours = Math.floor(durationMinutes / 60);
                        const durationMins = durationMinutes % 60;

                        document.getElementById('duration-hour').value = `${durationHours} hours ${durationMins} mins`;
                    }
                }

                // Attach event listeners for automatic duration calculation
                ['start-date', 'end-date', 'start-hour', 'start-minute', 'start-period', 'end-hour', 'end-minute', 'end-period'].forEach(id => {
                    document.getElementById(id).addEventListener('input', calculateDuration);
                    document.getElementById(id).addEventListener('change', calculateDuration);
                });
            },
            preConfirm: () => {
                const startDate = document.getElementById('start-date').value;
                const endDate = document.getElementById('end-date').value;
                const startHour = document.getElementById('start-hour').value;
                const startMinute = document.getElementById('start-minute').value;
                const startPeriod = document.getElementById('start-period').value;
                const endHour = document.getElementById('end-hour').value;
                const endMinute = document.getElementById('end-minute').value;
                const endPeriod = document.getElementById('end-period').value;
                const duration = document.getElementById('duration-hour').value;

                if (!startDate || !endDate || !startHour || !startMinute || !endHour || !endMinute) {
                    Swal.showValidationMessage('Please fill all required fields');
                    return false;
                }

                return {
                    startDate: startDate,
                    endDate: endDate,
                    startTime: `${startHour}:${String(startMinute).padStart(2, '0')} ${startPeriod}`,
                    endTime: `${endHour}:${String(endMinute).padStart(2, '0')} ${endPeriod}`,
                    duration: duration
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById("popupForm");
                form.action = `{{ url('admin/extratime') }}/${taskId}`;

                ['startDate', 'endDate', 'startTime', 'endTime', 'duration'].forEach(field => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = field.toLowerCase();
                    input.value = result.value[field];
                    form.appendChild(input);
                });

                form.submit();
            }
        });
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const seeMoreBtn = document.getElementById('see-more-btn');
        const showLessBtn = document.getElementById('show-less-btn');
        const hiddenTasks = document.querySelectorAll('.hidden-task');
        
        if(seeMoreBtn) {
            seeMoreBtn.addEventListener('click', function() {
                hiddenTasks.forEach(task => {
                    task.style.display = 'block';
                });
                seeMoreBtn.style.display = 'none';
                showLessBtn.style.display = 'inline-block';
            });
        }
        
        if(showLessBtn) {
            showLessBtn.addEventListener('click', function() {
                hiddenTasks.forEach(task => {
                    task.style.display = 'none';
                });
                showLessBtn.style.display = 'none';
                seeMoreBtn.style.display = 'inline-block';
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const seeMorePendingBtn = document.getElementById('see-more-pending-btn');
        const showLessPendingBtn = document.getElementById('show-less-pending-btn');
        const hiddenPendingTasks = document.querySelectorAll('.hidden-pending-task');
        
        if(seeMorePendingBtn) {
            seeMorePendingBtn.addEventListener('click', function() {
                hiddenPendingTasks.forEach(task => {
                    task.style.display = 'block';
                });
                seeMorePendingBtn.style.display = 'none';
                showLessPendingBtn.style.display = 'inline-block';
            });
        }
        
        if(showLessPendingBtn) {
            showLessPendingBtn.addEventListener('click', function() {
                hiddenPendingTasks.forEach(task => {
                    task.style.display = 'none';
                });
                showLessPendingBtn.style.display = 'none';
                seeMorePendingBtn.style.display = 'inline-block';
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const seeMoreCompletedBtn = document.getElementById('see-more-completed-btn');
        const showLessCompletedBtn = document.getElementById('show-less-completed-btn');
        const hiddenCompletedTasks = document.querySelectorAll('.hidden-completed-task');
        
        if(seeMoreCompletedBtn) {
            seeMoreCompletedBtn.addEventListener('click', function() {
                hiddenCompletedTasks.forEach(task => {
                    task.style.display = 'block';
                });
                seeMoreCompletedBtn.style.display = 'none';
                showLessCompletedBtn.style.display = 'inline-block';
            });
        }
        
        if(showLessCompletedBtn) {
            showLessCompletedBtn.addEventListener('click', function() {
                hiddenCompletedTasks.forEach(task => {
                    task.style.display = 'none';
                });
                showLessCompletedBtn.style.display = 'none';
                seeMoreCompletedBtn.style.display = 'inline-block';
            });
        }
    });
</script>
    @endsection