<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;
use Facades\Tests\Setup\ProjectFactory;

class ManageProjectsTest extends TestCase
{   
    use WithFaker , RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_project() 
    {   
        $this->withoutExceptionHandling();

        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'general notes'
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);


        $this->get($project->path())
        ->assertSee($attributes['title'])
        ->assertSee($attributes['description'])
        ->assertSee($attributes['notes']);

    }

    /** @test */
    public function a_user_can_update_a_project() {

        $project = ProjectFactory::ownedBy($this->signIn())->create();
        

        $this->patch($project->path() , $attributes = ['title'=> 'changed', 'description' => 'changed' ,'notes'=>'changed']);

        $this->get($project->path() . '/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes);

    }

    /** @test */
    public function unauthorize_cannot_delete_a_project() {

        $project = ProjectFactory::create();
        
        $this->delete($project->path())->assertRedirect('/login');

        $this->signIn();

        $this->delete($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_user_can_delete_a_project() {

        $project = ProjectFactory::ownedBy($this->signIn())->create();
        
        $this->delete($project->path())->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects' , $project->only('id'));
    }

    /** @test */
    public function a_project_require_a_title() 
    {   
        $this->signIn();

        $attribute = factory('App\Project')->raw(['title' => '']);

        $this->post('/projects',$attribute)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_require_a_description() 
    {
        $this->signIn();

        $attribute = factory('App\Project')->raw(['description' => '']);

        $this->post('/projects',$attribute)->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_user_can_view_their_project() 
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $this->get($project->path())->assertSee($project->title);
    }

    /** @test */
    public function an_authenticated_user_can_not_view_the_project_of_others() 
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
        
    }

    /** @test */
    public function an_authenticated_user_can_not_update_the_project_of_others() 
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->get($project->path() , [])->assertStatus(403);
        
    }

    /** @test */
    public function guests_cannot_manage_projects() 
    {
        $project = factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get($project->path() . '/edit/')->assertRedirect('login');        
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects',$project->toArray())->assertRedirect('login');

    }

    /** @test */
    public function a_user_can_update_general_note()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $this->patch($project->path() , $attributes = ['notes'=>'changed']);

        $this->assertDatabaseHas('projects', $attributes);
    }

}
