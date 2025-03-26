@extends('layouts.fonts', ['main_page' => 'yes'])
@section('content')


    <div class="content-wrapper">


        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <div class="col-sm-12">
                            <h1 class="text-primary font-weight-bold text-md-left">User Details</h1>
                        </div>
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.viewUser') }}">User Details</a></li>
                            <li class="breadcrumb-item active">View</li>
                        </ol>
                    </div>
                </div>

            </div>
        </section>

        <div class="container">
            <div class="card shadow-lg mt-4 mb-4" style="border-radius: 12px;">
                <!-- Card Header -->
                <div class="card-header bg-gradient-primary text-white text-center" style="border-radius: 12px 12px 0 0;">
                    <h3 class="card-title font-weight-bold">{{ $user->name }}</h3>
                </div>

                <!-- Card Body -->
                <div class="card-body" style="background-color: #f9f9f9;">
                    <div class="row">
                        <!-- Main Content -->
                        <div class="col-md-8 mb-4">
                            <h4 class="text-dark font-weight-bold">User Details</h4>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Email:</strong> <span class="text-info">{{ $user->email }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Department:</strong> <span class="text-success">{{ $user->department->get_Department}}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>User Role:</strong>
                                    <span class="badge badge-pill badge-primary">{{ $user->userType }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Emp No:</strong>
                                    <span class="badge badge-pill badge-primary">{{ $user->Emp_id }}</span>
                                </li>
                            </ul>

                            <!-- Button to show/hide form -->
                            <div class="mt-4 mb-3">
                                <button type="button" id="add-main-task" class="btn btn-primary">
                                    <i class="fas fa-tasks"></i> Add Task
                                </button>
                            </div>

                            <!-- Task Form Container - Moved to top position -->
                            <div id="task-form-container" style="display: none; margin-bottom: 20px;">
                                <h5 class="text-center mb-3">Add New Task</h5>
                                <form id="main-task-form" method="post" action="{{ route('task.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label for="company-name" class="fw-bold">Company Name</label>
                                            <input type="text" id="company-name" name="task_site" class="form-control" required>
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
                                    <div class="mb-3">
                                        <input type="number"  name="user_id" hidden class="form-control" value="{{$user->id}}" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label for="start-date" class="fw-bold">Start Date</label>
                                            <input type="date" id="start-date" name="start_date" class="form-control" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="end-date" class="fw-bold">End Date</label>
                                            <input type="date" id="end-date" name="end_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="job-description" class="fw-bold">Job Description</label>
                                            <textarea id="job-description" name="task_name" class="form-control" rows="3" required></textarea>
                                        </div>
                                        <div class="col-6">
                                            <label for="allocated-by" class="fw-bold">Allocated By</label>
                                            <input type="text" id="allocated-by" name="allocated_by" value="{{ Auth::user()->name }}" class="form-control" readonly required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-6 ">
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
                                                <input type="number" id="end-hour" name="end-hour" min="1" max="12" placeholder="HH" class="form-control w-25 me-2">
                                                <input type="number" id="end-minute" name="end-minute" min="0" max="59" placeholder="MM" class="form-control w-25 me-2">
                                                <select id="end-period" name="end-period" class="form-select w-auto">
                                                    <option value="AM">AM</option>
                                                    <option value="PM">PM</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3" style="display: flex; align-items: center;">    
                                        <div class="col-6" style="display: flex; flex-direction: column; margin-left: 10px;">
                                            <label style="font-weight: bold;">Alocation Hour</label>
                                            <input type="number" name="enter_hour" id="enter-hour" placeholder="Enter Hour"
                                                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; outline: none;" required>
                                        </div>
                                        <div class="col-4" style="display: flex; flex-direction: column;">
                                            <label class="fw-bold">Duration:</label>
                                            <input type="number" id="duration-hour" name="getHour" readonly class="form-control" placeholder="hours"
                                                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; outline: none;" required>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success me-2">Save Task</button>
                                        <button type="button" class="btn btn-danger" id="main-task-cancel">Cancel</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Table -->
                            <h4 class="text-dark font-weight-bold mt-4">Recent Activities</h4>
                            <section class="content">
   
                        <h3 class="card-title">Task Table</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Activity</th>
                                    <th>Company Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Duration</th>
                                    <th>Extra Time</th>
                                    <th>Reason</th>
                                    <th>User Status</th>
                                    <th>Coodinator Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($user->tasks && $user->tasks->isNotEmpty())
                                    @foreach($tasks as $task)
                                        <tr>
                                            <td>{{ $task->task_name }}</td>
                                            <td>{{ $task->task_site }}</td>
                                            <td>{{ $task->start_date }}</td>
                                            <td>{{ $task->end_date }}</td>
                                            <td>{{ $task->start_time }}</td>
                                            <td>{{ $task->end_time }}</td>
                                            
                                            <td>{{ $task->Duration_time }}</td>
                                            <td>{{ $task->Extra_time }}</td>
                                            <td>{{ $task->task_reason }}</td>
                                            <td>
                                                @if($task->Coordinator_status == 'Done')
                                                    <button class="btn btn-success" disabled style="padding: 5px 10px; font-size: 12px;">
                                                        <i class="fa-solid fa-check me-2"></i> Task Completed
                                                    </button>
                                                @elseif($task->Coordinator_status == 'pending')
                                                    <a href="javascript:void(0)" class="btn btn-danger" style="background-color:red; padding: 5px 10px; font-size: 12px;" onclick="confirmDelete('{{ $task->id }}', '{{ $task->user_id }}')">
                                                        not done
                                                    </a>
                                                @else
                                                    <button class="btn btn-danger" disabled style="padding: 5px 10px; font-size: 12px;">
                                                        <i class="fa-solid fa-clock me-2"></i> Task Pending
                                                    </button>
                                                @endif
                                            </td>
                                            <td>
                                                @if($task->Coordinator_status == 'Done')
                                                    <button class="btn btn-success" disabled style="padding: 5px 10px; font-size: 12px;">
                                                        <i class="fa-solid fa-check me-2"></i> Task Completed
                                                    </button>
                                                @elseif($task->Coordinator_status == 'pending')
                                                    <a href="javascript:void(0)" class="btn btn-danger" style="background-color:red; padding: 5px 10px; font-size: 12px;" >
                                                        not done
                                                    </a>
                                                @else
                                                    <button class="btn btn-danger" disabled style="padding: 5px 10px; font-size: 12px;">
                                                        <i class="fa-solid fa-clock me-2"></i> Task Pending
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="10" class="text-center">No tasks available</td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Activity</th>
                                    <th>Company Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Duration</th>
                                    <th>Extra Time</th>
                                    <th>Reason</th>
                                    <th>User Status</th>
                                    <th>Coodinator Status</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
           
    </div>
</section>


<!-- <script>
function confirmDelete(taskId, userId) {
    if (confirm('Are you sure you want to delete this task?')) {
        window.location.href = '/delete-task/' + taskId + '/' + userId;
    }
}
</script> -->
                        </div>

                        <!-- Sidebar -->
                       
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="card-footer text-center" style="background-color: #e9ecef; border-radius: 0 0 12px 12px;">
                </div>
            </div>
        </div>
    </div>

<!-- SweetAlert2 CDN -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.all.min.js"></script>

<!-- jQuery CDN (if you plan to use jQuery) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script>
function confirmDelete(taskId, userId) {
    Swal.fire({
        title: 'Time Entry',
        html: `
            <div id="task-form-container">
                <form id="popupForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="${userId}">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label>Start Date</label>
                            <input type="date" id="swal-start-date" name="startdate" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label>End Date</label>
                            <input type="date" id="swal-end-date" name="enddate" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label>Start Time</label>
                            <div class="d-flex">
                                <input type="number" id="swal-start-hour" name="start_hour" min="1" max="12" placeholder="HH" class="form-control" required>
                                <input type="number" id="swal-start-minute" name="start_minute" min="0" max="59" placeholder="MM" class="form-control" required>
                                <select id="swal-start-period" name="start_period" class="form-select">
                                    <option>AM</option>
                                    <option>PM</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <label>End Time</label>
                            <div class="d-flex">
                                <input type="number" id="swal-end-hour" name="end_hour" min="1" max="12" placeholder="HH" class="form-control" required>
                                <input type="number" id="swal-end-minute" name="end_minute" min="0" max="59" placeholder="MM" class="form-control" required>
                                <select id="swal-end-period" name="end_period" class="form-select">
                                    <option>AM</option>
                                    <option>PM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label>Duration</label>
                            <input type="text" id="swal-duration-hour" name="duration" class="form-control" readonly>
                        </div>
                         
                    </div>
                </form>
            </div>
        `,
        didOpen: () => {
            const modal = Swal.getHtmlContainer();
            
            // Calculation function
            const calculateDuration = () => {
                const getValue = (id) => modal.querySelector(`#${id}`).value;
                const getNumber = (id) => parseInt(getValue(id)) || 0;

                const startDate = getValue('swal-start-date');
                const endDate = getValue('swal-end-date');
                const startHour = getNumber('swal-start-hour');
                const startMinute = getNumber('swal-start-minute');
                const startPeriod = getValue('swal-start-period');
                const endHour = getNumber('swal-end-hour');
                const endMinute = getNumber('swal-end-minute');
                const endPeriod = getValue('swal-end-period');

                if (startDate && endDate && startHour && endHour) {
                    // Convert to 24h format
                    const start24h = (startHour % 12) + (startPeriod === 'PM' ? 12 : 0);
                    const end24h = (endHour % 12) + (endPeriod === 'PM' ? 12 : 0);

                    // Create Date objects
                    const start = new Date(`${startDate}T${String(start24h).padStart(2, '0')}:${String(startMinute).padStart(2, '0')}:00`);
                    const end = new Date(`${endDate}T${String(end24h).padStart(2, '0')}:${String(endMinute).padStart(2, '0')}:00`);

                    // Calculate duration
                    let ms = end - start;
                    if (ms < 0) ms += 86400000; // Add 24h if negative

                    const minutes = Math.floor(ms / 60000);
                    const hours = Math.floor(minutes / 60);
                    const remainingMinutes = minutes % 60;

                    // Update duration field
                    modal.querySelector('#swal-duration-hour').value = 
                        `${hours} hours ${remainingMinutes} minutes`;
                }
            };

            // Attach events to all inputs
            const inputs = [
                'swal-start-date', 'swal-end-date',
                'swal-start-hour', 'swal-start-minute', 'swal-start-period',
                'swal-end-hour', 'swal-end-minute', 'swal-end-period'
            ];
            
            inputs.forEach(id => {
                modal.querySelector(`#${id}`).addEventListener('input', calculateDuration);
                modal.querySelector(`#${id}`).addEventListener('change', calculateDuration);
            });

            // Initial calculation
            calculateDuration();
        },
        preConfirm: () => {
            // Recalculate just before submission to ensure accuracy
            const modal = Swal.getHtmlContainer();
            const calculateDuration = () => { /* same logic as above */ };
            calculateDuration();

            return {
                startdate: modal.querySelector('#swal-start-date').value,
                enddate: modal.querySelector('#swal-end-date').value,
                starttime: `${modal.querySelector('#swal-start-hour').value}:${modal.querySelector('#swal-start-minute').value.padStart(2, '0')} ${modal.querySelector('#swal-start-period').value}`,
                endtime: `${modal.querySelector('#swal-end-hour').value}:${modal.querySelector('#swal-end-minute').value.padStart(2, '0')} ${modal.querySelector('#swal-end-period').value}`,
                duration: modal.querySelector('#swal-duration-hour').value,
                user_id: userId,
                _token: '{{ csrf_token() }}'
            };
        },
        showCancelButton: true,
        confirmButtonText: 'Save'
    }).then((result) => {
    if (result.isConfirmed) {
        fetch(`/admin/extratime2/${taskId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                ...result.value,
                // Add task_id separately if needed
                task_id: taskId
            })
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.message || 'Failed to update');
            }
            return data;
        })
        .then(data => {
            Swal.fire('Success!', data.message, 'success')
                .then(() => window.location.reload());
        })
        .catch(error => {
            Swal.fire('Error!', error.message, 'error');
        });
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
</script> -->

@endsection