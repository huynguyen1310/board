@extends('layouts.app')
@section('content')

    <div class="flex item-center mb-3">
        <h1 class="mr-auto">Board</h1>
        <a href="/projects/create">New Project</a>
    </div>

    <div class="flex">
        @forelse ($projects as $project)
            <div class="bg-white mr-4 rounded shadow w-1/3 p-5" style="height:200px">
                <h1 class="font-normal text-xl py-4">{{ $project->title }}</h1>
                <div class="text-grey-lighter">{{ str_limit($project->description) }}</div>
            </div>
        @empty
            <p>No record at this moment</p>
        @endforelse
    </div>

@endsection
