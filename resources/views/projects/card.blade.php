<div class="cards" style="height:200px">
    <h1 class="font-normal text-xl py-4 mb-2 -ml-5 border-l-4 border-blue-lighter pl-4">
        <a href="{{ $project->path() }}">{{ $project->title }}</a>
    </h1>
    <div class="text-grey-lighter">{{ str_limit($project->description) }}</div>
</div>
