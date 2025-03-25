<!DOCTYPE html>
<html>
<head>
    <title>Task Assigned</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #2C3E50;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 10px;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
        }
        li {
            margin-bottom: 8px;
        }
        .task-details li {
            background-color: #f9f9f9;
            border-radius: 4px;
            padding: 8px;
            margin-bottom: 10px;
        }
        .task-details li strong {
            color: #2980B9;
        }
        .footer {
            font-size: 14px;
            color: #888;
            margin-top: 20px;
            text-align: center;
        }
        .footer a {
            color: #2980B9;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>New Task Assigned</h2>
    <p>Hello, {{ $task->user->name ?? 'User' }}</p>
    <p>A new task has been assigned to you:</p>
    <ul class="task-details">
        <li><strong>Task Name:</strong> {{ $task->task_name }}</li>
        <li><strong>Task Site:</strong> {{ $task->task_site }}</li>
       
        <li><strong>Start Date:</strong> {{ $task->start_date }}</li>
        <li><strong>End Date:</strong> {{ $task->end_date }}</li>
        <li><strong>Start Time:</strong> {{ $task->start_time }}</li>
        <li><strong>End Time:</strong> {{ $task->end_time }}</li>
    </ul>
    <p>Please log in to your dashboard to view details.</p>

    <div class="footer">
        <strong>Copyright &copy; 2025 <a href="https://adminlte.io" style="color: #0c84ff">Keen Rabbit</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.2.0
        </div>
    </div>
</div>

</body>
</html>



