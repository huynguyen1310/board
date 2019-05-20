@extends('layouts.app')
@section('content')
    <header class="flex item-center mb-3 py-4">
        <div class="flex justify-between w-full items-end">
            <p class="mr-auto text-default">
                <a href="/projects">My Projects</a>  / {{ $project->title }}
            </p>

            <div class="flex items-center">
                @foreach ($project->members as $member)
                    <img src="{{ gravatar_url($member->email) }}" alt="" class="rounded-full w-8 mr-2">
                @endforeach

                <img src="{{ gravatar_url($project->owner->email) }}" alt="" class="rounded-full w-8 mr-2">

                <a href="{{ $project->path() . '/edit' }}" class="btn ml-4">Edit Project</a>
            </div>
            

        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h1 class="mr-auto text-default text-lg mb-3">Task</h1>
                    
                    @foreach ($project->tasks as $task)
                        <div class="cards bg-card text-default mb-3">
                            <form action="{{ $task->path() }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="flex">
                                    <input type="text" name="body" value="{{ $task->body }}" class="w-full bg-card text-default {{ $task->completed ? 'line-through' : '' }}">
                                    <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>    
                                </div>
                                
                            </form>
                        </div> 
                    @endforeach

                    <div class="cards bg-card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                            @csrf
                            <input class="w-full text-default bg-card" placeholder="Add a new task" name="body"/>
                        </form>
                    </div>
                </div>
                
                <div>
                    <h1 class="mr-auto text-default text-lg mb-3">General Notes</h1>

                    {{-- General Notes --}}
                    <form action="{{ $project->path() }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <textarea name="notes" class="cards bg-card text-default w-full mb-4" placeholder="Anything special that you want to make a note of?" style="min-height:250px">{{ $project->notes }}</textarea>
                        <button type="submit" class="btn">Submit</button>
                    </form>

                    @include('errors')
                </div>
                

            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects.card')
                @include('projects.activity.card')

                @can('manage',$project) {{-- policy --}}
                    @include('projects.invite')
                @endcan
                    
            </div>

        </div>
    </main>



@endsection


