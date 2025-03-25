<table id="example1" class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>Name</th>
        <th>Task Name</th>
        <th>Status</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Start Time</th>
        <th>End Time</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($tasks as $task)
        @php
            $endDateTime = \Carbon\Carbon::parse($task->end_date . ' ' . $task->end_time);
            $now = \Carbon\Carbon::now();
        @endphp

        @if ($now->greaterThan($endDateTime)) <!-- Only show expired tasks -->
        <tr>
            <td>{{ $task->user->name ?? 'User Not Found' }}</td>
            <td>{{ $task->task_name }}</td>
            <td>
                <button class="btn btn-danger btn-sm">Pending</button> <!-- Replaced text with a button -->
            </td>
            <td>{{ $task->start_date }}</td>
            <td>{{ $task->end_date }}</td>
            <td>{{ $task->start_time }}</td>
            <td>{{ $task->end_time }}</td>
        </tr>
        @endif
    @endforeach
    </tbody>
</table>