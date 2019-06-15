<!DOCTYPE html>

<html>
<head>
    <title></title>
</head>

<body>
    <h1>BirdBoard</h1>

    <ul>
        @forelse ($projects as $project) //For else allows coalesce of info. If array is populated show this:
            <li><a href="{{ $project->path() }}">{{ $project->title }}</a></li>
        @empty // Otherwise, if array is empty show this:
            <li>No projects yet.</li>
        @endforelse
    </ul>

</body>


</html>