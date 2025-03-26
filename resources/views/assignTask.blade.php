@extends('layouts.fonts', ['main_page' => 'yes'])

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3>Task Assing Section</h3>
                    </div>
                </div>
            </div>
        </section>

        <div class="container mt-5">
            {{-- <label for="department" class="form-label">Select Department</label>
            <select id="department" name="department" class="form-select">
                <option value="">-- Select a Department --</option>
                @foreach($department as $dep) -->
                    <option value="{{ $dep->id }}">{{ $dep->get_Department }}</option>
                @endforeach
            </select> --}}
            <label for="General Task" style="font-weight:bold; font-size:30px">General Task</label><br>
            <label for="users" class="form-label">Select User</label>
            
            <select id="getusers" name="user" class="form-select">
                <option value="">-- Select a User --</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <label for="department" class="form-label">General Task</label>
            <select id="department2" name="department2" class="form-select">
                <option value="">-- Select Task Type--</option>
                <option value="One Time Task">One Time Task</option>
                <option value="Recurrent Task">Recurrent Task</option>
            </select>
        </div>
  

        <!-- One Time Task Form -->
        <div class="container mt-4" id="one-time-task-form" style="display: none;">
            <!-- <h5>One Time Task Form</h5> -->
            <form action="{{ route('general.store') }}" method="POST">
                @csrf 

                <!-- Second Row: Task Name & Priority -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="task_name" class="form-label">Task Name</label>
                        <input type="text" name="task_name" id="task_name" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="priority" class="form-label">Priority</label>
                        <select id="priority" name="priority" class="form-select" required>
                            <option value="">Select priority</option>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                </div>

                <!-- Hidden User ID -->
                <input type="hidden" id="user-id" name="user_id">


                <!-- Date Selection -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="start-date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" id="start-date" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="end-date" class="form-label">End Date</label>
                        <input type="date" name="end_date" id="end-date" class="form-control">
                    </div>
                </div>

                <!-- Job Description & Allocated By -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="task-details" class="form-label">Job Description</label>
                        <textarea id="task-details" name="task_details" class="form-control" rows="4" placeholder="Enter task details" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="allocated-by" class="form-label">Allocated By</label>
                        <input type="text" id="allocated-by" name="allocated_by" class="form-control" value="{{ Auth::user()->name }}" placeholder="Enter allocator's name" required disabled>
                    </div>
                </div>

                <div class="hideClass2" style="display:none">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="time-range" class="form-label">Time Range</label>
                            <select id="time-range" name="time_range" class="form-select" >
                                <option value="">Select Time Range</option>
                                <option value="Day">Day</option>
                                <option value="Week">Week</option>
                                <option value="Month">Month</option>
                                <option value="Year">Year</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Time Selection -->
                <div class="hideClass1" style="display:none;"> 
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="start-time" class="form-label fw-bold">Start Time:</label>
                            <div class="d-flex">
                                <input type="number" id="start-hour" name="start_hour" min="1" max="12" placeholder="HH" class="form-control w-25 me-2" >
                                <input type="number" id="start-minute" name="start_minute" min="0" max="59" placeholder="MM" class="form-control w-25 me-2" >
                                <select id="start-period" name="start_period" class="form-select w-auto">
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="end-time" class="form-label fw-bold">End Time:</label>
                            <div class="d-flex">
                                <input type="number" id="end-hour" name="end_hour" min="1" max="12" placeholder="HH" class="form-control w-25 me-2" >
                                <input type="number" id="end-minute" name="end_minute" min="0" max="59" placeholder="MM" class="form-control w-25 me-2" >
                                <select id="end-period" name="end_period" class="form-select w-auto" >
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                            </div>               
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="fw-bold mb-0 me-2">Enter Hour</label>
                            <input type="number" name="enter_hour" id="enter-hour" class="form-control" placeholder="Enter Hour">
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold mb-0 me-2">Duration Hour:</label>
                            <input type="number" id="duration-hour" value="hh" name="getHour" readonly class="form-control" placeholder="hours">
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="row mt-3">
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                    <div class="col-md-3" style="margin-left: -170px;">
                        <button type="button" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </form>
        </div> 
        <label for="normal-task" style="position:relative; left:80px;top:20px;font-size:30px">Normal Task</label>
        <div class="container mt-5">
            <form id="filter-form" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label for="department" class="form-label">Select Department</label>
                    <select id="department" name="department" class="form-select">
                        <option value="">-- Select a Department --</option>
                        @foreach($department as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->get_Department }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="users" class="form-label">Select User</label>
                    <select id="users" name="user" class="form-select" disabled>
                        <option value="">-- Select a User --</option>
                    </select>
                </div>
            </form>

            <div id="user-details" class="mt-4">
                <div class="card" id="user-details-card" style="display: none;">
                    <div class="card-header bg-primary text-white">
                        <h5>User Information</h5>
                    </div>

                    <div class="card-footer text-end" style="padding-bottom: 100px">
                        <button type="button" id="add-main-task" class="btn btn-primary">
                            <i class="fas fa-tasks"></i> Add Task
                        </button>
                        <div id="task-form-container" style="display: none; margin-bottom: 20px;">
    <form id="main-task-form" method="post" action="{{ route('task.store') }}">
        @csrf
        <div class="row">
            <div class="col-6">
                <label for="task-site" class="form-label" style="position: relative; left: -400px;">Company Name</label>
                <input type="text" id="task-site" name="task_site" class="form-control" placeholder="Enter task site">
            </div>
            <div class="col-6">
                <label for="priority" class="form-label" style="position: relative; left: -455px;">Priority</label>
                <select id="priority" name="priority" class="form-select">
                    <option value="">Select priority</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <label for="start-date-main" class="form-label">Start Date</label>
                <input type="date" id="start-date-main" name="start_date" class="form-control">
            </div>
            <div class="col-6">
                <label for="end-date-main" class="form-label">End Date</label>
                <input type="date" id="end-date-main" name="end_date" class="form-control" readonly>
            </div>
        </div>
        <div class="mb-3">
            <input type="number" id="user-id1" name="user_id" hidden class="form-control" value="">
        </div>

        <div class="row">
            <div class="col-6">
                <label for="task-name" class="form-label" style="position: relative; left: -400px;">Job Description</label>
                <textarea id="task-name" name="task_name" class="form-control" rows="4" placeholder="Enter task details"></textarea>
            </div>
            <div class="col-6">
                <label for="allocated-by" class="form-label" style="position: relative; left: -425px;">Allocated By</label>
                <input type="text" id="allocated-by" name="allocated_by" class="form-control" value="{{ Auth::user()->name }}" placeholder="Enter allocator's name" disabled>
            </div>
        </div>

        <div class="row" style="width: 700px;">
            <div class="col-6">
                <label for="start-time" class="form-label fw-bold">Start Time:</label>
                <div class="d-flex">
                    <input type="number" id="start-hour-main" name="start-hour" min="1" max="12" placeholder="HH" class="form-control w-25 me-2">
                    <input type="number" id="start-minute-main" name="start-minute" min="0" max="59" placeholder="MM" class="form-control w-25 me-2">
                    <select id="start-period" name="start-period-main" class="form-select w-auto">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </div>
            </div>

            <div class="col-6">
                <label for="end-time" class="form-label fw-bold">End Time:</label>
                <div class="d-flex">
                    <input type="number" id="end-hour-main" name="end-hour" min="1" max="12" placeholder="HH" class="form-control w-25 me-2" readonly>
                    <input type="number" id="end-minute-main" name="end-minute" min="0" max="59" placeholder="MM" class="form-control w-25 me-2" readonly>
                    <select id="end-period" name="end-period-main" class="form-select w-auto" disabled>
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </div>
            </div>

            <div class="col-6">
                <label for="enter-hour-main" class="form-label">Enter Hour</label>
                <input type="number" name="enter_hour" id="enter-hour-main" placeholder="Enter Hour" class="form-control">
            </div>
        </div>

        <div class="row" style="position:relative;top: 50px; left:-430px">
            <div class="col-6 d-flex align-items-center">
                <label class="fw-bold me-2">Duration Hour:</label>
                <input type="number" id="duration-hour-main" name="getHour" class="form-control w-25" placeholder="hours" readonly>
            </div>
        </div>

        <div id="time-output" style="margin-top: 16px; font-weight: bold; color: #333;"></div>

        <br><br><br>

        <button type="submit" id="submit-time" class="btn btn-success">Save Task</button>
        <button type="button" class="btn btn-danger" id="main-task-cancel">Cancel</button>
    </form>
</div>


                    </div>

                    <div class="card-body" style="margin-top: 10px">
                        <p><strong>Name:</strong> <span id="user-name"></span></p>
                        <p><strong>Department:</strong> <span id="user-department"></span></p>
                        <div id="user-tasks" class="mt-3" style="display: none;">
                            <!-- Tasks will be dynamically loaded here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error Alert (if no users found) -->
            <div id="user-error" class="alert alert-danger mt-4" style="display: none;">
                <strong>Error:</strong> No users found in this department.
            </div>

            <!-- Add Task Form -->

        </div>
    </div>





    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        const startDateStr = document.getElementById('start-date-main').value;
        if (!startDateStr) return;

        // Get start time components
        const startHour = parseInt(document.getElementById('start-hour-main').value) || 0;
        const startMinute = parseInt(document.getElementById('start-minute-main').value) || 0;
        const startPeriod = document.getElementById('start-period').value;

        // Validate inputs
        if (startHour === 0) return;

        // Convert to 24-hour format
        let startHour24 = startHour;
        if (startPeriod === 'PM' && startHour !== 12) {
            startHour24 += 12;
        } else if (startPeriod === 'AM' && startHour === 12) {
            startHour24 = 0;
        }

        // Get entered hours (duration)
        const enterHour = parseFloat(document.getElementById('enter-hour-main').value) || 0;
        if (enterHour === 0) return;

        // Create Date object (proper parsing)
        const startDate = new Date(startDateStr);
        startDate.setHours(startHour24);
        startDate.setMinutes(startMinute);

        // Calculate end time
        const endDate = new Date(startDate.getTime() + (enterHour * 60 * 60 * 1000));

        // Format end date
        const endDateStr = endDate.toISOString().split('T')[0];

        // Get end time components
        let endHour24 = endDate.getHours();
        let endMinutes = endDate.getMinutes();

        // Convert to 12-hour format
        let endPeriod = endHour24 >= 12 ? 'PM' : 'AM';
        let endHour12 = endHour24 % 12 || 12;

        // Update end fields
        document.getElementById('end-date-main').value = endDateStr;
        document.getElementById('end-hour-main').value = endHour12;
        document.getElementById('end-minute-main').value = endMinutes;
        document.getElementById('end-period').value = endPeriod;

        // Enable the end period field after setting the value
        document.getElementById('end-period').disabled = false;

        // Update duration field
        document.getElementById('duration-hour-main').value = enterHour;
    }

    // Attach event listeners
    const inputFields = ['start-date-main', 'start-hour-main', 'start-minute-main', 'start-period', 'enter-hour-main'];
    inputFields.forEach(id => {
        document.getElementById(id).addEventListener('input', updateEndDateTime);
        document.getElementById(id).addEventListener('change', updateEndDateTime);
    });
});
</script>
<!-- <script>
        $(document).ready(function () {
    // Handle department change
    $('#department').on('change', function () {
        const departmentId = $(this).val();

        // Reset user selection and details
        $('#users').prop('disabled', true).html('<option value="">-- Select a User --</option>');
        $('#user-details-card').hide();
        $('#user-error').hide();

        if (!departmentId) return;

        $.ajax({
            url: "{{ route('users.by.department') }}",
            type: "GET",
            data: { department_id: departmentId },
            success: function (response) {
                const usersDropdown = $('#users');
                usersDropdown.prop('disabled', false).html('<option value="">-- Select a User --</option>');

                if (response.users && response.users.length > 0) {
                    response.users.forEach(user => {
                        usersDropdown.append(`<option value="${user.id}">${user.name}</option>`);
                    });
                } else {
                    $('#user-error').show();
                }
            },
            error: function (xhr) {
                console.error("Error fetching users:", xhr.responseText);
            }
        });
    });

    // Handle user selection
    $('#users').on('change', function () {
        const userId = $(this).val();

        if (!userId) {
            $('#user-details-card').hide();
            return;
        }

        // ✅ Set the selected user's ID to the hidden input field inside the form
        $('#user-id').val(userId);

        $.ajax({
            url: "{{ route('user.details') }}",
            type: "GET",
            data: { user_id: userId },
            success: function (response) {
                if (response.success) {
                    const user = response.user;

                    $('#user-name').text(user.name);
                    $('#user-department').text(user.department ? user.department.get_Department : 'No department assigned');

                    // Display tasks
                    if (response.tasks && response.tasks.length > 0) {
                        let tasksHtml = '';
                        response.tasks.forEach(task => {
                            tasksHtml += `
                                <div class="task-item" style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                                    <strong style="font-size: 1.2rem; color: #333;">Task: ${task.task_name}</strong><br>
                                    Status:
                                    <span class="badge ${task.status === 'Completed' ? 'bg-success' : task.status === 'In Progress' ? 'bg-warning' : 'bg-secondary'}" style="font-size: 0.9rem;">
                                        ${task.status || 'Not specified'}
                                    </span>
                                    <span><p>Start Date: ${task.start_date}</p><p>End Date: ${task.end_date}</p></span>
                                </div>
                                <hr style="border-top: 1px solid #ddd; margin-top: 15px;">
                            `;
                        });
                        $('#user-tasks').html(tasksHtml).show();
                    } else {
                        $('#user-tasks').html('<p>No tasks found for this user.</p>').show();
                    }

                    $('#user-details-card').show();
                } else {
                    console.warn("No user found:", response.message);
                    $('#user-details-card').hide();
                }
            },
            error: function (xhr) {
                console.error("Error fetching user details:", xhr.responseText);
                $('#user-details-card').hide();
            }
        });
    });

    // Handle form submission
    $('form').on('submit', function (e) {
        const userId = $('#user-id').val();
        if (!userId) {
            e.preventDefault();
            alert("Please select a user before submitting the form.");
        }
    });
});
</script> -->
<script>$(document).ready(function () {
    // Handle department change
    $('#department').on('change', function () {
        const departmentId = $(this).val();

        // Reset user selection and details
        $('#users').prop('disabled', true).html('<option value="">-- Select a User --</option>');
        $('#user-details-card').hide();
        $('#user-error').hide();

        if (!departmentId) return;

        $.ajax({
            url: "{{ route('users.by.department') }}",
            type: "GET",
            data: { department_id: departmentId },
            success: function (response) {
                const usersDropdown = $('#users');
                usersDropdown.prop('disabled', false).html('<option value="">-- Select a User --</option>');

                if (response.users && response.users.length > 0) {
                    response.users.forEach(user => {
                        usersDropdown.append(`<option value="${user.id}">${user.name}</option>`);
                    });
                } else {
                    $('#user-error').show();
                }
            },
            error: function (xhr) {
                console.error("Error fetching users:", xhr.responseText);
            }
        });
    });

    // Handle user selection
    $('#users').on('change', function () {
        const userId = $(this).val();

        if (!userId) {
            $('#user-details-card').hide();
            return;
        }

        // ✅ Set the selected user's ID to the hidden input field inside the form
        $('#user-id').val(userId);

        $.ajax({
            url: "{{ route('user.details') }}",
            type: "GET",
            data: { user_id: userId },
            success: function (response) {
                if (response.success) {
                    const user = response.user;

                    $('#user-name').text(user.name);
                    $('#user-department').text(user.department ? user.department.get_Department : 'No department assigned');

                    // Display tasks
                    if (response.tasks && response.tasks.length > 0) {
                        let tasksHtml = '';
                        response.tasks.forEach(task => {
                            tasksHtml += `
                                <div class="task-item" style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                                    <strong style="font-size: 1.2rem; color: #333;">Task: ${task.task_name}</strong><br>
                                    Status:
                                    <span class="badge ${task.status === 'Completed' ? 'bg-success' : task.status === 'In Progress' ? 'bg-warning' : 'bg-secondary'}" style="font-size: 0.9rem;">
                                        ${task.status || 'Not specified'}
                                    </span>
                                    <span><p>Start Date: ${task.start_date}</p><p>End Date: ${task.end_date}</p></span>
                                    
                                    <div style="display: flex; gap: 10px; margin-top: 10px;">
                                        ${task.Coordinator_status !== 'Done' ? `
                                            <a href="/admin/taskUpdateView/${task.id}" class="text-warning" style="text-decoration: none;">
                                                <span class="btn btn-warning" style="display: flex; align-items: center;">
                                                    <i class="fas fa-edit" style="margin-right: 5px;"></i> Edit
                                                </span>
                                            </a>

                                            <a href="/admin/deleteTask/${task.id}" class="text-danger" onclick="confirmDelete(event)" style="text-decoration: none;">
                                                <span class="btn btn-danger" style="display: flex; align-items: center;">
                                                    <i class="fas fa-trash" style="margin-right: 5px;"></i> Delete
                                                </span>
                                            </a>
                                            <form action="/user/reason/${task.id}" method="POST" class="d-inline delete-form">
                                                <input type="hidden" name="_token" value="${document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content')}">
                                                
                                                <!-- Link to trigger confirmation and reason entry modal -->
                                                <a href="#" class="text-danger" onclick="event.preventDefault(); confirmDeleteWithReason(this);" style="text-decoration: none;">
                                                    <span class="btn btn-success" style="display: flex; align-items: center;">
                                                        <i class="fa-solid fa-paper-plane" style="margin-right: 5px;"></i> Enter Reason
                                                    </span>
                                                </a>
                                            </form>` : ''}
                                    </div>
                                </div>
                                <hr style="border-top: 1px solid #ddd; margin-top: 15px;">
                            `;
                        });
                        $('#user-tasks').html(tasksHtml).show();
                    } else {
                        $('#user-tasks').html('<p>No tasks found for this user.</p>').show();
                    }

                    $('#user-details-card').show();
                } else {
                    console.warn("No user found:", response.message);
                    $('#user-details-card').hide();
                }
            },
            error: function (xhr) {
                console.error("Error fetching user details:", xhr.responseText);
                $('#user-details-card').hide();
            }
        });
    });

    // Handle form submission
    $('form').on('submit', function (e) {
        const userId = $('#user-id').val();
        if (!userId) {
            e.preventDefault();
            alert("Please select a user before submitting the form.");
        }
    });
});
</script>

        <script>
            document.getElementById("submit-time").addEventListener("click", function () {
                // Get Start Time
                const startHour = document.getElementById("start-hour").value;
                const startMinute = document.getElementById("start-minute").value;
                const startPeriod = document.getElementById("start-period").value;

                // Get End Time
                const endHour = document.getElementById("end-hour").value;
                const endMinute = document.getElementById("end-minute").value;
                const endPeriod = document.getElementById("end-period").value;

                // Validate Inputs
                if (!startHour || !startMinute || !endHour || !endMinute) {
                    alert("Please fill out all fields.");
                    return;
                }

                if (startHour < 1 || startHour > 12 || endHour < 1 || endHour > 12) {
                    alert("Hours must be between 1 and 12.");
                    return;
                }

                if (startMinute < 0 || startMinute > 59 || endMinute < 0 || endMinute > 59) {
                    alert("Minutes must be between 0 and 59.");
                    return;
                }

                // Display Selected Time
                const output = `
            Start Time: ${startHour}:${startMinute.padStart(2, '0')} ${startPeriod} <br>
            End Time: ${endHour}:${endMinute.padStart(2, '0')} ${endPeriod}
            `;

                document.getElementById("time-output").innerHTML = output;
            });
        </script>

        <script>
            function confirmDelete(event) {
                event.preventDefault();

                const deleteUrl = event.currentTarget.href; // Ensure we get the correct URL

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            }

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





    <script>
        function confirmDeleteWithReason(button) {
                        const form = button.closest('form');

                        Swal.fire({
                            title: 'Enter Reason',
                            html: `
                        <input type="text" id="delete-reason" class="swal2-input" placeholder="Enter reason ">
                    `,
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Submit',
                            cancelButtonText: 'Cancel',
                            focusConfirm: false,
                            preConfirm: () => {
                                const reason = document.getElementById('delete-reason').value;
                                if (!reason) {
                                    Swal.showValidationMessage('Please enter a reason');
                                    return false;
                                }
                                return reason;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Create hidden input for the reason
                                const reasonInput = document.createElement('input');
                                reasonInput.type = 'hidden';
                                reasonInput.name = 'delete_reason';
                                reasonInput.value = result.value;

                                // Add to form and submit
                                form.appendChild(reasonInput);
                                form.submit();
                            }
                        });
                    }
        </script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var departmentSelect = document.getElementById("department2");
    
    if (departmentSelect) {
        departmentSelect.addEventListener("change", function() {
            var oneTimeForm = document.getElementById("one-time-task-form");
            var oneTimeFields = document.querySelector(".hideClass1"); // One Time Task fields
            var recurrentForm = document.querySelector(".hideClass2"); // Recurrent Task fields

            if (this.value === "One Time Task") {
                if (oneTimeForm) oneTimeForm.style.display = "block"; // Show One Time Task form
                if (oneTimeFields) oneTimeFields.style.display = "block"; // Show additional One Time fields
                if (recurrentForm) recurrentForm.style.display = "none"; // Hide Recurrent Task fields
            } else if (this.value === "Recurrent Task") {
                if (oneTimeForm) oneTimeForm.style.display = "block"; // Hide One Time Task form
                if (oneTimeFields) oneTimeFields.style.display = "none"; // Hide additional One Time fields
                if (recurrentForm) recurrentForm.style.display = "block"; // Show Recurrent Task fields
            } else {
                if (oneTimeForm) oneTimeForm.style.display = "none";
                if (oneTimeFields) oneTimeFields.style.display = "none";
                if (recurrentForm) recurrentForm.style.display = "none";
            }
        });
    } else {
        console.error("Element with id 'department2' not found!");
    }
});
;
</script>
<script>
    $(document).ready(function () {
    $('#start-date, #time-range').on('change', function () {
        let startDate = $('#start-date').val();
        let timeRange = $('#time-range').val();

        if (!startDate || !timeRange) return; // Exit if fields are empty

        let startDateObj = new Date(startDate);

        // Add time based on the selected range
        switch (timeRange) {
            case 'Day':
                startDateObj.setDate(startDateObj.getDate() + 1);
                break;
            case 'Week':
                startDateObj.setDate(startDateObj.getDate() + 7);
                break;
            case 'Month':
                startDateObj.setMonth(startDateObj.getMonth() + 1);
                break;
            case 'Year':
                startDateObj.setFullYear(startDateObj.getFullYear() + 1);
                break;
        }

        // Format the updated date as YYYY-MM-DD
        let formattedEndDate = startDateObj.toISOString().split('T')[0];

        // Update the end-date input field
        $('#end-date').val(formattedEndDate);
    });
});
</script>

<script>
    // Listen for the change event on the select element
    $('#getusers').change(function() {
        // Get the selected user ID from the select dropdown
        var userId = $(this).val();

        // Set the value of the hidden input field with the selected user ID
        $('#user-id').val(userId);
    });
</script>
    


@endsection