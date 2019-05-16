@extends('layouts.app')
@section('content')
    <header class="flex item-center mb-3 py-4">
        <div class="flex justify-between w-full items-end">
            <p class="mr-auto text-grey-lighter">
                <a href="/projects">My Projects</a>  / {{ $project->title }}
            </p>
            <a href="{{ $project->path() . '/edit' }}" class="btn btn-blue">Edit Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h1 class="mr-auto text-grey-lighter text-lg mb-3">Task</h1>
                    
                    @foreach ($project->tasks as $task)
                        <div class="cards mb-3">
                            <form action="{{ $task->path() }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="flex">
                                    <input type="text" name="body" value="{{ $task->body }}" class="w-full {{ $task->completed ? 'line-through' : '' }}">
                                    <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>    
                                </div>
                                
                            </form>
                        </div> 
                    @endforeach

                    <div class="cards mb-3">
                            <form action="{{ $project->path() . '/tasks' }}" method="POST">
                                @csrf
                                <input class="w-full" placeholder="Add a new task" name="body"/>
                            </form>
                    </div>
                </div>
                
                <div>
                    <h1 class="mr-auto text-grey-lighter text-lg mb-3">General Notes</h1>

                    {{-- General Notes --}}
                    <form action="{{ $project->path() }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <textarea name="notes" class="cards w-full mb-4" style="min-height:250px">{{ $project->notes }}</textarea>
                        <button type="submit" class="btn btn-blue">Submit</button>
                    </form>

                    @if ($errors->any())
                        <div class="field mt-6">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm text-red">{{ $error }}</li>
                            @endforeach
                        </div>        
                    @endif

                </div>
                

            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects.card')

                @include('projects.activity.card')
            </div>

        </div>
    </main>



@endsection


