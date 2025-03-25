@extends('layouts.fronts', ['main_page' => 'yes'])
<style>
    .btn{
        margin-left: 20px;
    }
</style>
@section('content')
    <div class="content-wrapper">
      
        
         <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>View User Status</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('editor.dashboard') }}">User Details</a></li>
                            <li class="breadcrumb-item active">View user</li>
                        </ol>
                    </div>
                </div>
                </div>
        </section>
        <div class="d-flex justify-content-start" style="margin-left: 20px">
            <div class="card text-white bg-primary mb-3" style="width: 20rem;">
                <div class="card-header text-center">
                    <h4>User Details</h4>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><strong>{{ $user->name }}</strong></h5>
                    <p class="card-text">
                        <strong>Department:</strong> {{ $user->department->get_Department ?? 'No department assigned' }}<br>
                        <strong>Role:</strong> {{ $user->userType }}<br>
                        <strong>Emp No:</strong> {{ $user->Emp_id }}
                    </p>
                </div>

            </div>
        </div>
        <div class="mt-4 mb-3" ">
    <button type="button" id="add-main-task" style="posion:margin-left:24px" class="btn btn-primary">
        <i class="fas fa-tasks"></i> Add Task
    </button>
</div>
<div class="card shadow-lg" id="task-form-container" style="display: none; margin-bottom: 20px;">
    <div class="card-header text-center bg-primary text-white">
        <h5 class="mb-0">Add New Task</h5>
    </div>
    <div class="card-body">
        <form id="main-task-form" method="post" action="{{ route('Coodinator.task.store') }}">
            @csrf

            <!-- Row 1: Company Name & Priority -->
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="company-name" class="fw-bold">Company Name</label>
                    <input type="text" id="company-name" name="task_site" class="form-control">
                </div>
                <div class="col-6 mb-3">
                    <label for="priority" class="fw-bold">Priority</label>
                    <select id="priority" name="priority" class="form-select" required>
                        <option value="">Select priority</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
            </div>

            <!-- Hidden User ID -->
            <input type="hidden" name="user_id" class="form-control" value="{{$user->id}}" required>

            <!-- Row 2: Start Date & End Date -->
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="start-date" class="fw-bold">Start Date</label>
                    <input type="date" id="start-date" name="start_date" class="form-control">
                </div>
                <div class="col-6 mb-3">
                    <label for="end-date" class="fw-bold">End Date</label>
                    <input type="date" id="end-date" name="end_date" class="form-control">
                </div>
            </div>

            <!-- Row 3: Job Description & Allocated By -->
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="job-description" class="fw-bold">Job Description</label>
                    <textarea id="job-description" name="task_name" class="form-control" rows="3"></textarea>
                </div>
                <div class="col-6 mb-3">
                    <label for="allocated-by" class="fw-bold">Allocated By</label>
                    <input type="text" id="allocated-by" name="allocated_by" value="{{ Auth::user()->name }}" class="form-control">
                </div>
            </div>

            <!-- Row 4: Start Time & End Time -->
            <div class="row mb-4">
                <div class="col-6">
                    <label class="fw-bold">Start Time:</label>
                    <div class="d-flex">
                        <input type="number" id="start-hour" name="start-hour" min="1" max="12" placeholder="HH" class="form-control w-25 me-2" required>
                        <input type="number" id="start-minute" name="start-minute" min="0" max="59" placeholder="MM" class="form-control w-25 me-2" required>
                        <select id="start-period" name="start-period" class="form-select w-auto" required>
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <label class="fw-bold">End Time:</label>
                    <div class="d-flex">
                        <input type="number" id="end-hour" name="end-hour" min="1" max="12" placeholder="HH" class="form-control w-25 me-2" required>
                        <input type="number" id="end-minute" name="end-minute" min="0" max="59" placeholder="MM" class="form-control w-25 me-2" required>
                        <select id="end-period" name="end-period" class="form-select w-auto" required>
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Row 5: Duration & Enter Hour -->
            <div class="row mb-3 align-items-center">
            <div class="col-6 ms-3">
                    <label class="fw-bold">Allocation Hour</label>
                    <input type="number" name="enter_hour" id="enter-hour" placeholder="Enter Hour" class="form-control">
                </div>
                <div class="col-4">
                    <label class="fw-bold">Duration:</label>
                    <input type="number" id="duration-hour" name="getHour" readonly class="form-control" placeholder="hours">
                </div>
               
            </div>

            <!-- Submit & Cancel Buttons -->
            <div class="text-center">
                <button type="submit" class="btn btn-success me-2">Save Task</button>
                <button type="button" class="btn btn-danger" id="main-task-cancel">Cancel</button>
            </div>
        </form>
    </div>
</div>


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"></h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Company Name</th>
                                        <th>Task Description</th>
                                        
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Allocation time</th>
                                        <th>Duration</th>
                                        <th>Extra Time</th>
                                        <th>Status</th>
                                        <th>Coordinator Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tasks as $task)
                                    <tr>

                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{$task->task_site}}</td>
                                            <td>{{ $task->task_name }}</td>
                                              <!--<td>{{$task->task_type}}</td>-->
                                              <!--<td>{{$task->qty}}</td>-->
                                            <td>{{ $task->start_date }}</td>
                                            <td>{{ $task->end_date }}</td>
                                        <td>{{$task->start_time}}::{{$task->end_time}}</td>
                                          <td>{{ $task->Duration_time }}</td>
                                        <td>{{$task->Extra_time}}</td>

                                        <td>
                                        <button class="btn 
        @if($task->status == 'Done')
    <button class="btn btn-success" disabled>
        <i class="fa-solid fa-check me-2"></i> Task Completed
    </button>
@elseif($task->status == 'pending')
   

    <button type="button" class="btn btn-danger" style="background-color:red;" onclick="confirmDelete({{ $task->id }},{{ $task->user_id}})">
  Not Done
    </button>


@else
    <button class="btn btn-danger" disabled>
        <i class="fa-solid fa-clock me-2"></i> Task Pending
    </button>
@endif

</button>

                                        </td>

                                        <td>
                                             <span class="badge
        @if($task->Coordinator_status === 'Done')
            bg-success
        @elseif($task->Coordinator_status === 'pending')
            bg-warning
        @else
            bg-secondary
        @endif
        px-3 py-2">
        {{$task->Coordinator_status ?? 'Not specified' }}
    </span>
                                        </td>
<td>
    <div class="d-flex gap-2 mt-3">
        <form action="{{ route('task.update.status', ['task' => $task->id]) }}" method="POST" class="me-2">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="Done">
            <button type="submit" class="btn btn-success btn-sm">
                <i class="fas fa-check me-1"></i> Done
            </button>
        </form>

        <form action="{{ route('task.update.status', ['task' => $task->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="Not Done">
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fas fa-times me-1"></i> Not Done
            </button>
        </form>
        <form action="{{ route('task.update.status', ['task' => $task->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="pending">
            <button type="submit" class="btn btn-warning btn-sm">
                <i class="fas fa-times me-1"></i> Pending
            </button>
        </form>
    </div>

</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>

                                        <th></th>
                                        <th>Company Name</th>
                                        <th>Task Description</th>
                                        
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Allocation time</th>
                                        <th>Duration</th>
                                        <th>Extra Time</th>
                                        <th>Status</th>
                                        <th>Coordinator Status</th>
                                        <th>Action</th>

                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- /.content -->
    </div>
<!-- SweetAlert2 CDN -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.all.min.js"></script>

<!-- jQuery CDN (if you plan to use jQuery) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show/hide form
        document.getElementById("add-main-task").addEventListener("click", function() {
            let formContainer = document.getElementById("task-form-container");
            if (formContainer.style.display === "none" || formContainer.style.display === "") {
                formContainer.style.display = "block";
            } else {
                formContainer.style.display = "none";
            }
        });
        
        // Cancel button functionality
        document.getElementById("main-task-cancel").addEventListener("click", function() {
            document.getElementById("task-form-container").style.display = "none";
        });
    });
</script>

<!-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        function calculateDuration() {
            let startHour = parseInt(document.getElementById("start-hour").value) || 0;
            let startMinute = parseInt(document.getElementById("start-minute").value) || 0;
            let startPeriod = document.getElementById("start-period").value;

            let endHour = parseInt(document.getElementById("end-hour").value) || 0;
            let endMinute = parseInt(document.getElementById("end-minute").value) || 0;
            let endPeriod = document.getElementById("end-period").value;

            let startDate = document.getElementById("start-date").value;
            let endDate = document.getElementById("end-date").value;

            // Ensure both start and end times are filled before calculating
            if (startHour === 0 || endHour === 0 || !startDate || !endDate) {
                document.getElementById("duration-hour").value = "";
                return;
            }

            // Convert to 24-hour format
            if (startPeriod === "PM" && startHour !== 12) startHour += 12;
            if (startPeriod === "AM" && startHour === 12) startHour = 0;
            if (endPeriod === "PM" && endHour !== 12) endHour += 12;
            if (endPeriod === "AM" && endHour === 12) endHour = 0;

            // Convert dates and times to Date objects
            let startDateTime = new Date(startDate);
            let endDateTime = new Date(endDate);

            startDateTime.setHours(startHour, startMinute, 0, 0);
            endDateTime.setHours(endHour, endMinute, 0, 0);

            // Calculate duration in milliseconds
            let durationMs = endDateTime - startDateTime;

            // Handle overnight shifts where end date is before start date
            if (durationMs < 0) {
                durationMs += 24 * 60 * 60 * 1000; // Add 24 hours
            }

            // Convert duration to hours and minutes
            let durationMinutes = Math.floor(durationMs / 60000);
            let durationHours = Math.floor(durationMinutes / 60);
            let durationMins = durationMinutes % 60;

            // Display in HH.MM format
            document.getElementById("duration-hour").value = durationHours + (durationMins > 0 ? "." + durationMins : "");
        }

        // Attach event listeners
        let inputs = ["start-hour", "start-minute", "start-period", "end-hour", "end-minute", "end-period", "start-date", "end-date"];
        inputs.forEach(id => {
            document.getElementById(id).addEventListener("input", calculateDuration);
            document.getElementById(id).addEventListener("change", calculateDuration);
        });
    });
</script> -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    function updateEndDateTime() {
        // Get start date
        const startDateStr = document.getElementById('start-date').value;
        if (!startDateStr) return;

        // Get start time components
        const startHour = parseInt(document.getElementById('start-hour').value);
        const startMinute = parseInt(document.getElementById('start-minute').value);
        const startPeriod = document.getElementById('start-period').value;

        // Validate inputs
        if (isNaN(startHour) || isNaN(startMinute)) return;

        // Convert to 24-hour format
        let startHour24 = startHour;
        if (startPeriod === 'PM' && startHour !== 12) {
            startHour24 += 12;
        } else if (startPeriod === 'AM' && startHour === 12) {
            startHour24 = 0;
        }

        // Get entered hours
        const enterHour = parseFloat(document.getElementById('enter-hour').value);
        if (isNaN(enterHour)) return;

        // Create Date object
        const [year, month, day] = startDateStr.split('-');
        const startDate = new Date(year, month - 1, day, startHour24, startMinute);
        const endDate = new Date(startDate.getTime() + (enterHour * 60 * 60 * 1000));

        // Format end date
        const endDateStr = endDate.toISOString().split('T')[0];
        
        // Get end time components
        const endHours24 = endDate.getHours();
        const endMinutes = endDate.getMinutes();

        // Convert to 12-hour format
        let endPeriod = endHours24 >= 12 ? 'PM' : 'AM';
        let endHour12 = endHours24 % 12;
        endHour12 = endHour12 === 0 ? 12 : endHour12;

        // Update end fields
        document.getElementById('end-date').value = endDateStr;
        document.getElementById('end-hour').value = endHour12;
        document.getElementById('end-minute').value = endMinutes;
        document.getElementById('end-period').value = endPeriod;
        document.getElementById('duration-hour').value = enterHour;
    }

    // Attach event listeners
    const inputs = ['start-date', 'start-hour', 'start-minute', 'start-period', 'enter-hour'];
    inputs.forEach(id => {
        document.getElementById(id).addEventListener('input', updateEndDateTime);
        document.getElementById(id).addEventListener('change', updateEndDateTime);
    });
});
</script>


<!-- <script>
    function confirmDelete(taskId, userId) {
    Swal.fire({
        title: 'Time Entry',
        html: `
            <div id="task-form-container">
                <form id="popupForm" method="POST">
                    <input type="hidden" id="csrf-token" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="task_id" name="task_id" value="${taskId}">
                    <input type="hidden" id="user_id" name="user_id" value="${userId}">

                    <div class="row mb-5">
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="start-date" class="form-label">Start Date</label>
                                <input type="date" id="start-date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label for="end-date" class="form-label">End Date</label>
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
            const popup = Swal.getPopup();
            
            function calculateDuration() {
                const startDate = popup.querySelector('#start-date').value;
                const endDate = popup.querySelector('#end-date').value;
                const startHour = parseInt(popup.querySelector('#start-hour').value) || 0;
                const startMinute = parseInt(popup.querySelector('#start-minute').value) || 0;
                const startPeriod = popup.querySelector('#start-period').value;
                const endHour = parseInt(popup.querySelector('#end-hour').value) || 0;
                const endMinute = parseInt(popup.querySelector('#end-minute').value) || 0;
                const endPeriod = popup.querySelector('#end-period').value;

                if (startDate && endDate && startHour && startMinute >= 0 && endHour && endMinute >= 0) {
                    let startH = startHour % 12 + (startPeriod === "PM" ? 12 : 0);
                    let endH = endHour % 12 + (endPeriod === "PM" ? 12 : 0);
                    let startDateTime = new Date(`${startDate}T${String(startH).padStart(2, '0')}:${String(startMinute).padStart(2, '0')}:00`);
                    let endDateTime = new Date(`${endDate}T${String(endH).padStart(2, '0')}:${String(endMinute).padStart(2, '0')}:00`);

                    if (endDateTime < startDateTime) {
                        endDateTime.setDate(endDateTime.getDate() + 1);
                    }

                    let durationMinutes = (endDateTime - startDateTime) / 60000;
                    const durationHours = Math.floor(durationMinutes / 60);
                    const durationMins = durationMinutes % 60;
                    popup.querySelector('#duration-hour').value = `${durationHours} hours ${durationMins} mins`;
                }
            }

            ['start-date', 'end-date', 'start-hour', 'start-minute', 'start-period', 'end-hour', 'end-minute', 'end-period'].forEach(id => {
                popup.querySelector(`#${id}`).addEventListener('input', calculateDuration);
                popup.querySelector(`#${id}`).addEventListener('change', calculateDuration);
            });
        },
        preConfirm: () => {
            const popup = Swal.getPopup();

            const startDate = popup.querySelector('#start-date').value;
            const endDate = popup.querySelector('#end-date').value;
            const startHour = popup.querySelector('#start-hour').value;
            const startMinute = popup.querySelector('#start-minute').value;
            const startPeriod = popup.querySelector('#start-period').value;
            const endHour = popup.querySelector('#end-hour').value;
            const endMinute = popup.querySelector('#end-minute').value;
            const endPeriod = popup.querySelector('#end-period').value;
            const duration = popup.querySelector('#duration-hour').value;

            if (!startDate || !endDate || !startHour || !startMinute || !endHour || !endMinute) {
                Swal.showValidationMessage('Please fill all required fields');
                return false;
            }

            return {
                taskId,
                userId,
                startDate,
                endDate,
                startTime: `${startHour}:${String(startMinute).padStart(2, '0')} ${startPeriod}`,
                endTime: `${endHour}:${String(endMinute).padStart(2, '0')} ${endPeriod}`,
                duration
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = "POST";
            form.action = `{{ url('admin/extratime') }}/${result.value.taskId}`;

            ['taskId', 'userId', 'startDate', 'endDate', 'startTime', 'endTime', 'duration'].forEach(field => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = field.toLowerCase();
                input.value = result.value[field];
                form.appendChild(input);
            });

            const csrfTokenInput = document.createElement('input');
            csrfTokenInput.type = 'hidden';
            csrfTokenInput.name = '_token';
            csrfTokenInput.value = document.getElementById('csrf-token').value;
            form.appendChild(csrfTokenInput);

            document.body.appendChild(form);
            form.submit();
        }
    });
}

</script> -->
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
                                <label for="end-date" class="form-label">End Date</label>
                                <input type="date" id="end-date" name="end_date" class="form-control" required readonly>
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
                                    class="form-control w-25 me-2" required readonly>
                                <input type="number" id="end-minute" min="0" max="59" placeholder="MM" 
                                    class="form-control w-25 me-2" required readonly>
                                <select id="end-period" class="form-select w-auto" required readonly>
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
@endsection
