<div class="cards mt-3 flex flex-col">
    <ul>
        @foreach ($project->activity as $activity)
            <li class="mb-1">
                @include("projects.activity.$activity->description")
                <span class="text-gray-500">{{ $activity->created_at->diffForHumans(null , true) }}</span>
            </li>
        @endforeach
    </ul>
</div>