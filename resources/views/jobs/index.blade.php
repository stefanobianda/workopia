<x-layout>
    <h1>Available Jobs</h1>
    <ul>
        @forelse($jobs as $job)
        <li>{{$job->title}} - {{$job->description}}</li>
        @empty
        <li>No job available</li>
        @endforelse
    </ul>
</x-layout>
