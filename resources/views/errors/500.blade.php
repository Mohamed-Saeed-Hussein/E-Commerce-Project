@extends('layouts.app')

@section('title', 'Server Error')

@section('content')
<section>
    <h1>500 - Server Error</h1>
    <p>Something went wrong on our end. Please try again later.</p>
    <p><a href="{{ url('/') }}">Go Home</a></p>
</section>
@endsection


