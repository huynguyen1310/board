<div class="cards mt-3">
    <ul>
        @foreach ($project->activity as $activity)
            <li class="mb-1">
                @include("projects.activity.$activity->description")
                <span class="text-gray-500">{{ $activity->created_at->diffForHumans(null , true) }}</span>
            </li>
        @endforeach
    </ul>
</div>