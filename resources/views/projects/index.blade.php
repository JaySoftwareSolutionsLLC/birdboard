@extends('layouts.app');
@section('content')
    <header class='flex items-center mb-3 mx-3 py-4 flex justify-between items-center'>
        <h2 class='text-gray-500 text-sm font-normal'>My Projects</h2>
        <a href="/projects/create" class='button'>New Project</a>
    </header>

    <main class='lg:flex lg:flex-wrap -px-3'>
        @forelse ($projects as $project)
        <div class='lg:w-1/3 px-3 pb-6'>
            <a href="{{ $project->path() }}" class='bg-white p-5 rounded-lg shadow block'>
                <h3 class='font-normal text-xl mb-5 py-3 -ml-5 border-l-4 border-blue-300 pl-4'>{{ $project->title }}</h3>
                <p class='text-sm text-gray-400'>{{ str_limit($project->description, 55) }}</p>
            </a>
        </div>
        @empty
        <h3>No projects yet.</h3>
        @endforelse
    </main>
    
    
@endsection