<div class="cards bg-card flex flex-col">
    <h1 class="font-normal text-xl py-4 mb-2 -ml-5 border-l-4 border-blue-lighter pl-4 text-default">
        <a href="{{ $project->path() }}">{{ $project->title }}</a>
    </h1>
    <div class="text-default mb-4 h-10">{{ str_limit($project->description) }}</div>

    @can('manage',$project)
        <footer class="mt-4">
            <form action="{{ $project->path() }}" method="POST" class="text-right">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs">Delete</button>
            </form>
        </footer>
    @endcan
    
</div>
