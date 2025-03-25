
@extends('layouts.fonts', ['main_page' => 'yes'])
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

/* Container */
.container {
    max-width: calc(100% - 250px); /* Adjust based on your sidebar width */
    margin-left: 250px; /* Should match your sidebar width */
    padding: 20px;
}

/* Add spacing between sections */
.filter-form {
    margin: 30px 0;
    padding: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Improve department card styling */
.kanban-board {
    margin-bottom: 30px;
}

.department-card {
    flex: 1;
    min-width: 300px;
    max-width: calc(33.333% - 20px); /* Ensures 3 cards per row with gap */
    margin-bottom: 20px;
}

/* Department color variations */
.department-header {
    background: linear-gradient(45deg, var(--dept-color), var(--dept-color-light)) !important;
}

/* Add these color variables in your blade template */


/* Kanban Board */
.kanban-board {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

/* Department Card */
.department-card {
    flex: 1;
    min-width: 300px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.department-header {
    padding: 15px;
    font-size: 18px;
    font-weight: bold;
    color: white;
}

.department-body {
    padding: 15px;
    background: #ffffff;
}

/* User List */
.user-list {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.user-list li {
    padding: 8px;
    border-bottom: 1px solid #ddd;
}

.user-list li:last-child {
    border-bottom: none;
}

/* Task Section */
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

/* Colors for Task Status */
.bg-primary {
    background-color: #007bff !important;
}

.bg-danger {
    background-color: #dc3545 !important;
}

.bg-success {
    background-color: #28a745 !important;
}

/* Filter Form */
.filter-form {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.filter-form input,
.filter-form select,
.filter-form button {
    padding: 8px;
    font-size: 14px;
    border-radius: 4px;
    border: 1px solid #ddd;
}

.filter-form button {
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
}

.filter-form button:hover {
    background-color: #0056b3;
}
.current-date {
    background: white;
    padding: 10px 15px;
    border-radius: 4px;
    margin: 20px 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    font-weight: bold;
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

.task-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* .abs{
    background-color: black;
} */
/* Responsive Design */
@media (max-width: 768px) {
    .kanban-board,
    .task-section {
        flex-direction: column;
    }

    .department-card,
    .task-card {
        width: 100%;
    }
}
</style>

<div class="container">
    <h1>Task Management</h1>

    @if(session('error'))
        <div class="alert alert-danger" style="text-align: center">
            {{ session('error') }}
        </div>
    @endif
   


    <!-- show to day Activity -->
    <div class="Today-Task">
    <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Task Table</h3>
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
                                        <td>{{ \Carbon\Carbon::parse($todayTask->start_date)->format('Y-m-d') }} {{ \Carbon\Carbon::parse($todayTask->start_time)->format('H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($todayTask->end_date)->format('Y-m-d') }} {{ \Carbon\Carbon::parse($todayTask->end_time)->format('H:i') }}</td>
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


    <!-- Kanban Board for Departments -->
    <div class="kanban-board">
        @foreach($departments as $department)
            <div class="department-card">
                <div class="department-header" style="background: {{ $department->color }};">
                    {{ $department->get_Department }}
                </div>
                <div class="department-body">
                    <h6 style="font-weight: bold;">Users</h6>
                    <ul class="user-list">
                        @foreach($department->users as $user)
                            <li>{{ $user->name }} ({{ $user->email }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Task Filter Form -->
    <form action="{{ route('filter.tasks') }}" class="filter-form" method="GET">
        <input type="text" name="user_name" placeholder="Filter by User Name">
        {{-- <input type="date" name="start_date">
        <input type="date" name="end_date"> --}}
        <select name="status">
            <option value="">All</option>
            <option value="pending">Pending</option>
            <option value="ongoing">Ongoing</option>
            <option value="done">Done</option>
        </select>
        <button type="submit">Filter</button>
    </form>
    <div class="current-date">
        Current Date: {{ $now->format('Y-m-d H:i:s') }}
    </div>

    <!-- Task Sections -->
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
                                <input type="number" id="start-hour" min="1" max="12" placeholder="HH" 
                                    class="form-control w-25 me-2" required>
                                <input type="number" id="start-minute" min="0" max="59" placeholder="MM" 
                                    class="form-control w-25 me-2" required>
                                <select id="start-period" class="form-select w-auto" required>
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">End Time:</label>
                            <div class="d-flex mt-2">
                                <input type="number" id="end-hour" min="1" max="12" placeholder="HH" 
                                    class="form-control w-25 me-2" required >
                                <input type="number" id="end-minute" min="0" max="59" placeholder="MM" 
                                    class="form-control w-25 me-2" required >
                                <select id="end-period" class="form-select w-auto" required>
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="fw-bold">Allocation Hours</label>
                            <input type="number" name="enter_hour" id="enter-hour" placeholder="Enter Hours"
                                class="form-control" step="0.5" min="0.5" required>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="fw-bold">Total Duration:</label>
                            <input type="text" id="duration-hour" value="0 hours 0 mins" 
                                class="form-control" readonly>
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
            function calculateEndTime() {
                const startDate = document.getElementById('start-date').value;
                const startHour = parseInt(document.getElementById('start-hour').value);
                const startMinute = parseInt(document.getElementById('start-minute').value);
                const startPeriod = document.getElementById('start-period').value;
                const enterHour = parseFloat(document.getElementById('enter-hour').value);

                if (!startDate || isNaN(startHour) || isNaN(startMinute) || isNaN(enterHour)) return;

                // Convert to 24-hour format
                let startHour24 = startHour;
                if (startPeriod === 'PM' && startHour !== 12) startHour24 += 12;
                if (startPeriod === 'AM' && startHour === 12) startHour24 = 0;

                // Create Date object
                const [year, month, day] = startDate.split('-');
                const startDateTime = new Date(year, month - 1, day, startHour24, startMinute);
                
                // Add duration hours
                const durationMs = enterHour * 60 * 60 * 1000;
                const endDateTime = new Date(startDateTime.getTime() + durationMs);

                // Format end date
                const endYear = endDateTime.getFullYear();
                const endMonth = String(endDateTime.getMonth() + 1).padStart(2, '0');
                const endDay = String(endDateTime.getDate()).padStart(2, '0');
                document.getElementById('end-date').value = `${endYear}-${endMonth}-${endDay}`;

                // Format end time
                const endHours24 = endDateTime.getHours();
                const endMinutes = String(endDateTime.getMinutes()).padStart(2, '0');
                const endPeriod = endHours24 >= 12 ? 'PM' : 'AM';
                const endHour12 = endHours24 % 12 || 12;

                document.getElementById('end-hour').value = endHour12;
                document.getElementById('end-minute').value = endMinutes;
                document.getElementById('end-period').value = endPeriod;

                // Update duration display
                const durationHours = Math.floor(enterHour);
                const durationMins = Math.round((enterHour - durationHours) * 60);
                document.getElementById('duration-hour').value = 
                    `${durationHours} hours ${durationMins} mins`;
            }

            // Attach event listeners
            ['start-date', 'start-hour', 'start-minute', 'start-period', 'enter-hour'].forEach(id => {
                document.getElementById(id).addEventListener('input', calculateEndTime);
                document.getElementById(id).addEventListener('change', calculateEndTime);
            });
        },
        preConfirm: () => {
            const requiredFields = [
                'start-date', 'start-hour', 'start-minute', 'enter-hour'
            ];
            
            const missing = requiredFields.find(id => !document.getElementById(id).value);
            if (missing) {
                Swal.showValidationMessage('Please fill all required fields');
                return false;
            }

            return {
                startDate: document.getElementById('start-date').value,
                endDate: document.getElementById('end-date').value,
                startTime: `${document.getElementById('start-hour').value}:${
                    String(document.getElementById('start-minute').value).padStart(2, '0')} ${
                    document.getElementById('start-period').value}`,
                endTime: `${document.getElementById('end-hour').value}:${
                    String(document.getElementById('end-minute').value).padStart(2, '0')} ${
                    document.getElementById('end-period').value}`,
                duration: document.getElementById('enter-hour').value
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById("popupForm");
            form.action = `{{ url('admin/extratime') }}/${taskId}`;

            // Add hidden inputs
            const fields = ['startDate', 'endDate', 'startTime', 'endTime', 'duration'];
            fields.forEach(field => {
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




