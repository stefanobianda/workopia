<x-layout>
    <div class="bg-blue-900 h-24 px-4 mb-4 flex justify-center items-center rounded">
        <x-search />
    </div>
    <h1 class="text-2xl">All Jobs</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @forelse($jobs as $job)
        <x-job-card :job="$job" />
        @empty
        <li>No job available</li>
        @endforelse

    </div>

    {{-- Pagination Links--}}
    {{$jobs->links()}}
</x-layout>
