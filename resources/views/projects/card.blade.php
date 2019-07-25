<a href="{{ /* T&V LU&R pg 39 URL::temporarySignedRoute('projects.show', now()->addHours(1), ['id' => $project->id]) */ 
            /* T&V LU&R pg 39 URL::signedRoute('projects.show', ['id' => $project->id]) */
            /* T&V LU&R pg 31 */ route('projects.show', ['slug' => $project->id]) 
            /* Laracast method $project->path()*/ }}" class='card'>
    <h3 class='font-normal text-xl mb-5 py-3 -ml-5 border-l-4 border-blue-300 pl-4'>{{ $project->title }}</h3>
    <p class='text-sm text-gray-400'>{{ str_limit($project->description, 55) }}</p>
</a>