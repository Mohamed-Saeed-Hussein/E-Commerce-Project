@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<section>
    <h1>404 - Page Not Found</h1>
    <p>The page you are looking for could not be found.</p>
    <p><a href="{{ url('/') }}">Go Home</a></p>
</section>
@endsection


