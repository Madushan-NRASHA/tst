

@extends('layouts.fronts', ['main_page' => 'yes'])

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3>Filter Users by Department and Assign Tasks</h3>
                    </div>
                </div>
            </div>
        </section>

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
                        <div class="modal-body">
                            <form id="main-task-form" method="post" action="{{ route('Coodinator.task.store') }}" style="display: none;">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <label for="task-site" class="form-label" style="position: relative; left: -400px;">Company Name</label>
                                        <input type="text" id="task-site" name="task_site" class="form-control"  placeholder="Enter task site" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="priority" class="form-label" style="position: relative; left: -455px;">Priority</label>
                                        <select id="priority" name="priority" class="form-select" required>
                                            <option value="">Select priority</option>
                                            <option value="low">Low</option>
                                            <option value="medium">Medium</option>
                                            <option value="high">High</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <label for="start-date" class="form-label" style="position: relative; left: -440px;">Start Date</label>
                                        <input type="date" id="start-date" name="start_date" class="form-control" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="end-date" class="form-label" style="position: relative; left: -448px;">End Date</label>
                                        <input type="date" id="end-date" name="end_date" class="form-control">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input type="number" id="user-id" name="user_id" hidden class="form-control" value="" required>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="task-name" class="form-label"  style="position: relative; left: -400px;">Job Description</label>

                                        <textarea id="task-name" name="task_name" class="form-control" rows="4" placeholder="Enter task details" required></textarea>
                                    </div>
                                    <div class="col-6">
                                        <label for="allocated-by" class="form-label" style="position: relative; left: -425px;">Allocated By</label>
                                        <input type="text" id="allocated-by" name="allocated_by" class="form-control" value="{{ Auth::user()->name }}" placeholder="Enter allocator's name" required disabled>
                                    </div>
                                </div>
                              <!-- Added attributes to make time inputs more user-friendly -->
                                <div class="row" style="width: 700px;">
                                    <div class="col-6">
                                        <label for="start-time" class="form-label fw-bold" style="position: absolute;left: 12px">Start Time:</label>
                                        <div class="d-flex" style="position: absolute; top: 30px" >
                                            <input type="number" id="start-hour" name="start-hour" min="1" max="12" placeholder="HH" class="form-control w-25 me-2" required>
                                            <input type="number" id="start-minute" name="start-minute" min="0" max="59" placeholder="MM" class="form-control w-25 me-2" required>
                                            <select id="start-period" name="start-period" class="form-select w-auto" required>
                                                <option value="AM">AM</option>
                                                <option value="PM">PM</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <label for="end-time" class="form-label fw-bold" style="position: absolute;left: 10px">End Time:</label>
                                        <div class="d-flex" style="position: absolute; top: 30px">
                                            <input type="number" id="end-hour" name="end-hour" min="1" max="12" placeholder="HH" class="form-control w-25 me-2">
                                            <input type="number" id="end-minute" name="end-minute" min="0" max="59" placeholder="MM" class="form-control w-25 me-2">
                                            <select id="end-period" name="end-period" class="form-select w-auto">
                                                <option value="AM">AM</option>
                                                <option value="PM">PM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-auto ms-auto d-flex align-items-center" style="position: relative;top: 28px;left: 350px">
                                        <p class="fw-bold mb-0 me-2">Duration Hour:</p>
                                        <input type="number" id="duration-hour" value="hh" name="getHour" readonly class="form-control w-25" placeholder="hours">
                                    </div>
                                   </div>

                                   <div class="row" style="position:relative;top: 50px; left:-430px">
                                    <div class="col-8">
                                    <label>Enter Hour</label>
                                    <input type="number" ame="enter_hour" id="enter-hour"  placeholder="Enter Hour" required>
                                    </div>
                                </div>
                                
                                 <!-- <div class="row" style="position:relative;top: 50px; left:-400px">
                                 <div class="row mt-3">
                                    <div class="col-8">
                                        <label class="form-label">Enter Duration Hours</label>
                                        <input type="number" name="enter_hour" id="enter-hour" 
                                            placeholder="Enter Hours" class="form-control">
                                    </div>
                                -->


                                <div id="time-output" style="margin-top: 16px; font-weight: bold; color: #333;"></div>





                                <br>

                                <br>
                                <br>
                                <button type="submit"  id="submit-time" class="btn btn-success">Save Task</button>
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

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
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
                        // Fixed: Added proper template literal syntax with backticks
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

        // Set the selected user's ID to the hidden input field
        $('#user-id').val(userId);

        $.ajax({
            url: "{{ route('user.details') }}",
            type: "GET",
            data: { user_id: userId },
            success: function (response) {
                if (response.success) {
                    const user = response.user;

                    $('#user-name').text(user.name);
                    // Fixed: Corrected the department property access
                    $('#user-department').text(user.department ? user.department.get_Department: 'No department assigned');

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

                                <!-- Action Buttons -->
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
    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
    
    <!-- Link to trigger confirmation and reason entry modal -->
    <a href="#" class="text-danger" onclick="event.preventDefault(); confirmDeleteWithReason(this);" style="text-decoration: none;">
        <span class="btn btn-success" style="display: flex; align-items: center;">
            <i class="fa-solid fa-paper-plane" style="margin-right: 5px;"></i> Enter Reason
        </span>
    </a>
</form>
    ` : ''}
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

    // Add task form toggle
    $('#add-main-task').on('click', function () {
        $('#main-task-form').toggle();
    });

    // Cancel task form
    $('#main-task-cancel').on('click', function () {
        $('#main-task-form').hide().find('form')[0].reset();
    });

    // Save task logic
    $('#main-task-save').on('click', function () {
        const taskName = $('#task_name').val();
        const taskStatus = $('#task_status').val();

        const userId = $('#user-id').val();
        if (!userId) {
            alert('No user selected. Please select a user.');
            return;
        }

        if (taskName && taskStatus !== "Not specified") {
            console.log('Task saved:', taskName, taskStatus, 'User ID:', userId);
            $('#main-task-form').hide().find('form')[0].reset();
        } else {
            alert('Please enter a valid task name and status.');
        }
    });
});

// $('#main-task-form').on('submit', function(e) {
//     e.preventDefault();

//     // Log form data before submission
//     console.log('Form Data:', $(this).serialize());

//     // Submit the form
//     this.submit();
// });
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

    </div>
@endsection
