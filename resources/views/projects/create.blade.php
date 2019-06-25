@extends('layouts.app');
@section('content')
    <h1>Create a Project</h1>
    <form method="POST" action="/projects">
        @csrf
        <input type="text" name="title" id="title-input">
        <textarea name="description" id="description-input" cols="30" rows="10" placeholder=""></textarea>
        <input type="submit" value="Submit">
        <a href='/projects'>Cancel</a>
    </form>
@endsection