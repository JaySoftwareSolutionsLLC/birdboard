@extends('layouts.app')
@section('content')
    <header class='flex items-end mb-3 mx-3 py-4 flex justify-between items-center'>
        <h2 class='text-gray-500 text-sm font-normal'><a href="/projects" class='underline text-blue-400'>My Projects</a> / {{ $project->title }}</h2>
    </header>
    <main>
        <div class='lg:flex'>
            <div class='lg:w-3/4 px-3'>
                <div class='mb-8'>
                    <h2 class='text-gray-500 font-normal text-lg'>Tasks</h2>
                    @forelse ($project->tasks as $task)
                    <div class='card mb-3'>{{ $task->body }}</div>
                    @empty
                    @endforelse
                    <div class='card mb-3'>
                            <form action="{{ $project->path() . '/tasks' }}" method="post">
                                @csrf
                                <input class='w-full' name='body' placeholder="Add new task..." />
                            </form>
                        </div>               
                    </div>
                <div class='mb-8'>
                    <h2 class='text-gray-500 font-normal text-lg'>General Notes</h2>
                    <textarea class='card w-full' style='min-height: 200px;'>Lorem ipsum.</textarea>
                </div>
            </div>
            <div class='lg:w-1/4 px-3'>
                @include('projects.card')
            </div>
        </div>
    </main>
@endsection