<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Project</title>
</head>
<body>
    <h1>Create a Project</h1>
    <form method="POST" action="/projects">
        @csrf
        <input type="text" name="title" id="title-input">
        <textarea name="description" id="description-input" cols="30" rows="10" placeholder=""></textarea>
        <input type="submit" value="Submit">
    </form>
</body>
</html>