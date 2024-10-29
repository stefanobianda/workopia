@extends('layout')

@section('title')
List of Jobs
@endsection

@section('content')
    <h1>{{$title}}</h1>
    @if(!empty($jobs))
    <ul>
        @foreach ($jobs as $job)
        <li>
            {{$job}}
        </li>
        @endforeach
    </ul>
    @else
    <p>No jobs available</p>
    @endif
@endsection