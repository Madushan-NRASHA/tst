@extends('layouts.fronts', ['main_page' => 'yes'])

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3>Filter Users by Department</h3>
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
                        <h5>User Task Details</h5>
                    </div>
                    <div class="card-footer text-end">
                        <button type="button" id="add-main-task" class="btn btn-primary">
                            <i class="fas fa-tasks"></i> Add Task
                        </button>
                     </div>
                     <!-- Add Task Form -->
                    <div class="modal-body">
                        <form id="main-task-form" method="post" action="{{ route('task.store') }}" style="display: none;">
                            @csrf
                            <div class="mb-3">
                                <label for="task-name" class="form-label">Task Name</label>
                                <input type="text" id="task-name" name="task_name" class="form-control" placeholder="Enter task name" required>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="start-date" class="form-label">Start Date</label>
                                    <input type="date" id="start-date" name="start_date" class="form-control" required>
                                </div>
                                <div class="col-6">
                                    <label for="end-date" class="form-label">End Date</label>
                                    <input type="date" id="end-date" name="end_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="number" id="user-id" name="user_id" hidden class="form-control" value="" required>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="priority" class="form-label">Priority</label>
                                    <select id="priority" name="priority" class="form-select" required>
                                        <option value="">Select priority</option>
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="allocation-hour" class="form-label">Allocation Hour</label>
                                    <input type="number" id="allocation-hour" name="allocation_hour" class="form-control" placeholder="Enter hours" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="allocated-by" class="form-label">Allocated By</label>
                                <input type="text" id="allocated-by" name="allocated_by" class="form-control" value="{{ Auth::user()->name }}" placeholder="Enter allocator's name" required disabled>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-success">Save Task</button>
                            <button type="button" class="btn btn-danger" id="main-task-cancel">Cancel</button>
                        </form>
                    </div>
                    <div class="card-body">
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

            
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">User Table</h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Emp No</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{ $user->Emp_id }}</td>
                                               <td> {{$user->name}}</td>
                                                <td>{{ $user->department->get_Department }}</td>
                                                <td>{{$user->userType}}</td>
                                                <td> <a href="{{ route('coordinator.view', ['id' => $user->id]) }}" class="text-warning">

                                                    <span class="btn btn-primary"><i class="far fa-eye"></i> View</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach



                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Emp No</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Role</th>
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

        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                                $('#user-department').text(user.department ? user.department.get_Department : 'No department assigned');

                                // Display tasks
                                if (response.tasks && response.tasks.length > 0) {
                                    let tasksHtml = '';
                                    response.tasks.forEach(task => {
                                        tasksHtml += `
    <div class="task-item shadow-sm p-4 mb-4 bg-white rounded">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h5 class="mb-1 text-primary">${task.task_name}</h5>
                <div class="text-muted small">
                    <i class="fas fa-calendar-alt me-1"></i> Start: ${task.start_date}
                    <span class="mx-2">|</span>
                    <i class="fas fa-flag-checkered me-1"></i> End: ${task.end_date}
                  <i class="fas fa-clock me-1 text-secondary"></i>
            <span class="fw-semibold">Start hour:${task.start_time} </span>
             <span class="mx-2">|</span>
             <span class="fw-semibold">End hour:${task.end_time} </span>
                </div>
            </div>
            <span class="badge ${task.status === 'Done' ? 'bg-success' : task.status === 'In Progress' ? 'bg-warning' : 'bg-secondary'} px-3 py-2">
                ${task.status || 'Not specified'}
            </span>
        </div>

        <div class="d-flex gap-2 mt-3">
            <form action="/Coodinatortask/${task.id}/update-status" method="POST" class="me-2">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="Done">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fas fa-check me-1"></i> Approve
                </button>
            </form>

            <form action="/Coodinatortask/${task.id}/update-status" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="pending">
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-times me-1"></i> Reject
                </button>
            </form>
        </div>

                                                            </div>
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
                    $('#main-task-form').toggle(); // Show or hide the form when the button is clicked
                });

                // Cancel task form
                $('#main-task-cancel').on('click', function () {
                    $('#main-task-form').hide().find('form')[0].reset(); // Hide the form and reset it
                });

                // Save task logic (example)
                $('#main-task-save').on('click', function () {
                    const taskName = $('#task_name').val();
                    const taskStatus = $('#task_status').val();

                    // Ensure user ID is set before saving task
                    const userId = $('#user-id').val();
                    if (!userId) {
                        alert('No user selected. Please select a user.');
                        return;
                    }

                    if (taskName && taskStatus !== "Not specified") {
                        // Submit form logic here (e.g., save the task)
                        console.log('Task saved:', taskName, taskStatus, 'User ID:', userId);

                        // Hide and reset the form after saving
                        $('#main-task-form').hide().find('form')[0].reset();
                    } else {
                        alert('Please enter a valid task name and status.');
                    }
                });
            });
        </script>


    </div>
@endsection
