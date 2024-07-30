<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task Created</title>
</head>
<body>
<h1>A new task has been created</h1>
<p>Title: {{ $task->title }}</p>
<p>Description: {{ $task->description }}</p>
<p>Deadline: {{ $task->deadline }}</p>
</body>
</html>
