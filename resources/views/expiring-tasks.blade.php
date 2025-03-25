<!--<!DOCTYPE html>-->
<!--<html>-->
<!--<head>-->
<!--    <title>Task Expiry Notification</title>-->
    
<!--     <style>-->
<!--        .warning {-->
<!--            color: red;-->
<!--            font-weight: bold;-->
<!--        }-->
<!--    </style>-->
    


<!--</head>-->

<!--<body>-->
    

<!--    <h2 class="warning">Warning! Your Task(s) Will Expire in 5 Minutes</h2>-->

<!--    <ul>-->
<!--        @foreach ($tasks as $task)-->
<!--            <li><strong>{{ $task->task_name }}</strong> - Expires at: {{ $task->end_time }}</li>-->
<!--        @endforeach-->
<!--    </ul>-->

<!--    <p>Please take necessary action immediately.</p>-->
    
<!--</body>-->
<!--</html>-->
<!DOCTYPE html>
<html>
<head>
    <title>Task Expiry Warning</title>
    <style>
        .warning {
            color: #dc3545;
            font-weight: bold;
        }
        .task-list {
            margin: 20px 0;
        }
        .task-item {
            margin: 10px 0;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .task-name {
            color: #495057;
            font-weight: bold;
        }
        .expiry-time {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <h2 class="warning">⚠️ Warning: Tasks Expiring in Less Than 5 Minutes!</h2>
   
    
    <div class="task-list">
        @foreach ($tasks as $task)
        <div class="task-item">
            <span class="task-name">{{ $task->task_name }}</span>
            <br>
            <span class="expiry-time">Expires at: {{ date('h:i A', strtotime($task->end_time)) }}</span>
        </div>
        @endforeach
    </div>

    <p>Please take immediate action to complete these tasks before they expire.</p>
</body>
</html>