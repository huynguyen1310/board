<div class="cards flex flex-col" style="height:200px">
    <h1 class="font-normal text-xl py-4 mb-2 -ml-5 border-l-4 border-blue-lighter pl-4">
        <a href="{{ $project->path() }}">{{ $project->title }}</a>
    </h1>
    <div class="text-grey-lighter mb-4">{{ str_limit($project->description) }}</div>

    @can('manage',$project)
        <footer>
            <form action="{{ $project->path() }}" method="POST" class="text-right">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs">Deleted</button>
            </form>
        </footer>
    @endcan
    
</div>
