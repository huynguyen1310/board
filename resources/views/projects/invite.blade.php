<div class="cards bg-card flex flex-col mt-3">
    <h1 class="font-normal text-xl py-4 mb-2 -ml-5 border-l-4 border-blue-lighter pl-4">
        Invite a user
    </h1>

    <form action="{{ $project->path() . '/invitations' }}" method="POST">
        @csrf
        <input type="email" name="email" class="border border-grey rounded" placeholder="Email address">
        <button type="submit" class="text-xs btn">Invite</button>
    </form>

    @include('errors', ['bag' => 'invitations'])

</div>