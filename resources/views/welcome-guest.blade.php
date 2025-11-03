@extends('layouts.app')

@section('content')
    <div class="container text-center py-5">
        <h1>Welcome to Note-Nest</h1>
        <p class="lead">A note-sharing platform for GIATMARA Muadzam Shah.</p>
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        <a href="#about" class="btn btn-outline-secondary ms-2">About</a>
    </div>

    <div id="about" class="py-5">
        <div class="container">
            <h2>About</h2>
            <p>Teachers can create subject folders, upload notes, and build quizzes. Students can download materials and
                take quizzes.</p>
        </div>
    </div>
@endsection
