<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        @if (Auth::user()->userType == 'General Manager' || Auth::user()->userType == 'admin')
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('adminView.Dashboard') }}" class="nav-link">Home</a>
        </li>
        @else
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('adminView.Dashboard') }}" class="nav-link">Homes</a>
        </li>
        @endif
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge" id="notificationBadge">{{ $tasks->count() }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notificationDropdown" style="width: 800px;">
                <span class="dropdown-item dropdown-header">
                    {{ $tasks->count() }} Notifications
                </span>

                <div class="dropdown-divider"></div>

                <div id="taskContainer">
                    @foreach ($tasks->take(5) as $task)
                        <a href="#" class="dropdown-item task-item">
                            <p class="text-truncate" style="max-width: 1000px;">
                                <i class="fas fa-tasks mr-2"></i> {{ Str::limit($task->task_name, 50) }}
                            </p>
                            <span class="float-right text-muted text-sm">
                                {{ \Carbon\Carbon::parse($task->end_date . ' ' . $task->end_time)->diffForHumans() }}
                            </span>
                        </a>
                        <div class="dropdown-divider"></div>
                    @endforeach
                </div>

                @if ($tasks->count() > 5)
                    <a href="javascript:void(0);" id="toggleTasks" class="dropdown-item text-center text-primary">
                        See More
                    </a>
                @endif

                <!-- Task Summary -->
                <div class="dropdown-item text-center">
                    <strong>Expired:</strong> <span class="text-danger">{{ $expiredTaskCount ?? 0 }}</span> |
                    <strong>Expiring Soon:</strong> <span class="text-warning">{{ $soonToExpireTaskCount ?? 0 }}</span>
                </div>

                <div class="dropdown-divider"></div>

                <!-- Footer link -->
                <a href="{{ route('pendingTask') }}" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
    </ul>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let toggleButton = document.getElementById("toggleTasks");
        let taskContainer = document.getElementById("taskContainer");
        let allTasks = @json($tasks);
        let isExpanded = false;

        toggleButton.addEventListener("click", function() {
            if (!isExpanded) {
                taskContainer.innerHTML = allTasks.map(task => `
                    <a href="#" class="dropdown-item task-item">
                        <p class="text-truncate" style="max-width: 1000px;">
                            <i class="fas fa-tasks mr-2"></i> ${task.task_name.substring(0, 50)}
                        </p>
                        <span class="float-right text-muted text-sm">
                            ${task.end_date} ${task.end_time}
                        </span>
                    </a>
                    <div class="dropdown-divider"></div>
                `).join("");
                toggleButton.textContent = "Show Less";
            } else {
                taskContainer.innerHTML = allTasks.slice(0, 5).map(task => `
                    <a href="#" class="dropdown-item task-item">
                        <p class="text-truncate" style="max-width: 1000px;">
                            <i class="fas fa-tasks mr-2"></i> ${task.task_name.substring(0, 50)}
                        </p>
                        <span class="float-right text-muted text-sm">
                            ${task.end_date} ${task.end_time}
                        </span>
                    </a>
                    <div class="dropdown-divider"></div>
                `).join("");
                toggleButton.textContent = "See More";
            }
            isExpanded = !isExpanded;
        });
    });
</script>