@extends('layouts.fonts', ['main_page' => 'yes'])

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Task</h1>
                    </div>
                </div>
            </div>
        </section>

        <div class="container">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Edit Task</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.taskUpdateSAVE', ['id' => $task->id]) }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-6">
                                <label for="task-site" class="form-label">Company Name</label>
                                <input type="text" id="task-site" name="task_site" value="{{$task->task_site}}" class="form-control" placeholder="Enter task site" required>
                            </div>
                            <div class="col-6">
                                <label for="priority" class="form-label">Priority</label>
                                <select id="priority" name="priority" class="form-select" required>
                                    <option value="{{$task->priority}}">{{$task->priority}}</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="start-date" class="form-label">Start Date</label>
                                <input type="date" id="start-date" value="{{$task->start_date}}" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label for="end-date" class="form-label">End Date</label>
                                <input type="date" id="end-date" value="{{$task->end_date}}" name="end_date" class="form-control" required>
                            </div>
                        </div>

                        <input type="hidden" id="user-id" name="user_id" value="{{$task->user_id}}">

                        <div class="row mt-3">
                            <div class="col-6">
                                <label for="task-name" class="form-label">Job Description</label>
                                <textarea id="task-name" name="task_name" class="form-control" rows="4" placeholder="Enter task details" required>{{ old('task_name', $task->task_name ?? '') }}</textarea>
                            </div>
                            <div class="col-6">
                                <label for="allocated-by" class="form-label">Allocated By</label>
                                <input type="text" id="allocated-by" name="allocated_by" class="form-control" value="{{ Auth::user()->name }}" disabled>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <label class="form-label"><strong>Time Allocation</strong></label>
                                <div class="d-flex gap-3">
                                    <div>
                                        <label for="start-hour">Start Time:</label>
                                        <div class="d-flex gap-2">
                                            <input type="number" id="start-hour" name="start-hour" min="1" max="12" value="{{ $hour }}" class="form-control" style="width: 70px;" required>
                                            <span>:</span>
                                            <input type="number" id="start-minute" name="start-minute" min="0" max="59" value="{{ $minute }}" class="form-control" style="width: 70px;" required>
                                            <select id="start_period" name="start_period" class="form-select" required>
                                                <option value="AM" {{ old('start_period', $period) == 'AM' ? 'selected' : '' }}>AM</option>
                                                <option value="PM" {{ old('start_period', $period) == 'PM' ? 'selected' : '' }}>PM</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="end-hour">End Time:</label>
                                        <div class="d-flex gap-2">
                                            <input type="number" id="end-hour" name="end-hour" min="1" max="12" value="{{ $end_hour }}" class="form-control" style="width: 70px;" required>
                                            <span>:</span>
                                            <input type="number" id="end-minute" name="end-minute" min="0" max="59" value="{{ $end_minute }}" class="form-control" style="width: 70px;" required>
                                            <select id="end_period" name="end_period" class="form-select" required>
                                                <option value="AM" {{ old('end_period', $end_period) == 'AM' ? 'selected' : '' }}>AM</option>
                                                <option value="PM" {{ old('end_period', $end_period) == 'PM' ? 'selected' : '' }}>PM</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="duration-hour">Duration:</label>
                                        <input type="number" id="duration-hour" value="{{$task->Duration_time}}" name="getHour" readonly class="form-control w-50">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Update Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                function calculateDuration() {
                    let startDate = document.getElementById("start-date").value;
                    let endDate = document.getElementById("end-date").value;

                    let startHour = Number(document.getElementById("start-hour").value) || 0;
                    let startMinute = Number(document.getElementById("start-minute").value) || 0;
                    let startPeriod = document.getElementById("start_period").value;

                    let endHour = Number(document.getElementById("end-hour").value) || 0;
                    let endMinute = Number(document.getElementById("end-minute").value) || 0;
                    let endPeriod = document.getElementById("end_period").value;

                    if (!startDate || !endDate || startHour === 0 || endHour === 0) {
                        document.getElementById("duration-hour").value = "";
                        return;
                    }

                    if (startPeriod === "PM" && startHour !== 12) startHour += 12;
                    if (startPeriod === "AM" && startHour === 12) startHour = 0;
                    if (endPeriod === "PM" && endHour !== 12) endHour += 12;
                    if (endPeriod === "AM" && endHour === 12) endHour = 0;

                    let startDateTime = new Date(`${startDate}T${String(startHour).padStart(2, '0')}:${String(startMinute).padStart(2, '0')}:00`);
                    let endDateTime = new Date(`${endDate}T${String(endHour).padStart(2, '0')}:${String(endMinute).padStart(2, '0')}:00`);

                    let durationMilliseconds = endDateTime - startDateTime;

                    if (durationMilliseconds < 0) {
                        endDateTime.setDate(endDateTime.getDate() + 1);
                        durationMilliseconds = endDateTime - startDateTime;
                    }

                    let durationMinutes = Math.floor(durationMilliseconds / 60000);
                    let durationHours = Math.floor(durationMinutes / 60);
                    let remainingMinutes = durationMinutes % 60;

                    document.getElementById("duration-hour").value = durationHours + (remainingMinutes > 0 ? "." + remainingMinutes : ".00");
                }

                document.querySelectorAll("input, select").forEach(element => {
                    element.addEventListener("input", calculateDuration);
                });

                calculateDuration();
            });
        </script>
    </div>
@endsection
