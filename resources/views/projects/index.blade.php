@extends('layouts.app')
@section('content')
    <header class='flex items-end mb-3 mx-3 py-4 flex justify-between items-center'>
        <h2 class='text-gray-500 text-sm font-normal'>My Projects</h2>
        <a href="/projects/create" class='button'>New Project</a>
    </header>

    <main class='lg:flex lg:flex-wrap -px-3'>
        @forelse ($projects as $project)
        <div class='lg:w-1/3 px-3 pb-6'>
            @include('projects.card')
        </div>
        @empty
        <h3>No projects yet.</h3>
        @endforelse
    </main>
    
    
@endsection