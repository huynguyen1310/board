<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use App\User;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function non_owner_cannot_invite_a_user()
    {   
        $user = factory(User::class)->create();
        $project = ProjectFactory::create();

        $this->actingAs($user)
            ->post($project->path() . '/invitations')
            ->assertStatus(403);

        $project->invite($user);

        $this->actingAs($user)
            ->post($project->path() . '/invitations')
            ->assertStatus(403);
    }


    /** @test */
    function a_project_owner_can_invite_a_user()
    {
        $project = ProjectFactory::create();

        $userToInvite = factory(User::class)->create();

        $this->actingAs($project->owner)->post($project->path() . '/invitations' , [
            'email' => $userToInvite->email
        ])
            ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    /** @test */
    function the_invited_email_address_must_be_a_valid_account()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->post($project->path() . '/invitations' , [
            'email' => 'notauser@gmail.com'
        ])
        ->assertSessionHasErrors([
            'email' => 'The user you are inviting is not exists.'
        ], null , 'invitations');
    }

    /** @test */
    function a_project_can_invite_a_user_details()
    {
        $project = ProjectFactory::create();

        $project->invite($newUser = factory(User::class)->create());
    
        $this->signIn($newUser);
        $this->post(action('ProjectTasksController@store' ,$project), $task =  ['body'=>'Foo']);
    
        $this->assertDatabaseHas('tasks' , $task);
    }
}
