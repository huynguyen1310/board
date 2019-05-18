<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Http\Requests\ProjectInvitationRequest;

class ProjectIvitationsController extends Controller
{
    public function store(Project $project , ProjectInvitationRequest $request)
    {
        $user = User::whereEmail(request('email'))->first();
    
        $project->invite($user);

        return redirect($project->path());
    }
}
