<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task Deadline Warning</title>
</head>
<body>
<h1>Task Deadline Approaching</h1>
<p>Your task "{{ $task->title }}" is nearing its deadline.</p>
<p>Deadline: {{ $task->deadline }}</p>
<p>Please make sure to complete it on time.</p>
</body>
</html>
