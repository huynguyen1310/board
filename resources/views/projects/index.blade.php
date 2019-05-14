@extends('layouts.app')
@section('content')

    <header class="flex item-center mb-3 py-4">
        <div class="flex justify-between w-full items-end">
            <h1 class="mr-auto text-grey-lighter">My Projects</h1>
            <a href="/projects/create" class="btn btn-blue">New Project</a>
        </div>
    </header>

    <main class="flex flex-wrap -mx-3">
        @forelse ($projects as $project)
            <div class="w-1/3 px-3 pb-6">
                @include('projects.card')
            </div>
        @empty
            <p>No record at this moment</p>
        @endforelse
    </main>

@endsection
