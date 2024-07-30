<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task Inactive Notification</title>
</head>
<body>
<h1>Task Status Changed to Inactive</h1>
<p>Your task "{{ $task->title }}" has been marked as inactive due to the deadline passing.</p>
<p>Deadline: {{ $task->deadline }}</p>
<p>Please review the task and take necessary actions.</p>
</body>
</html>
