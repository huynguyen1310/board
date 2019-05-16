<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;
use App\Task;
use Facades\Tests\Setup\ProjectFactory;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->withOutExceptionHandling();

        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $this->post($project->path() . '/tasks' , ['body' => 'Test task']);

        $this->get($project->path())->assertSee('Test task');

    }

    // /** @test */
    // public function a_task_require_a_body()
    // {
    //     $project = ProjectFactory::ownedBy($this->signIn())->create();

    //     $attribute = factory('App\Task')->raw(['body' => '']) ;

    //     $this->post($project->path() . '/task', $attribute)->assertSessionHasErrors("body");

    // }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks() {
        $this->signIn();
        
        $project = factory(Project::class)->create();

        $this->post($project->path() . '/tasks' , ['body' => 'Test task'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks' , ['body' => 'Test task']);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_tasks() {
        $this->signIn();

        $project = ProjectFactory::withTask(1)
            ->create();

        $this->patch($project->tasks->first()->path() , ['body' => 'changed'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks' , ['body' => 'changed']);
    }

    /** @test */
    public function a_task_can_be_updated() {

        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTask(1)
            ->create();

        $this->patch($project->tasks->first()->path() , [
            'body' => 'changed',
        ]);

        $this->assertDatabaseHas('tasks',[
            'body' => 'changed',
        ]);
    }

    /** @test */
    public function a_task_can_be_completed() {

        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTask(1)
            ->create();

        $this->patch($project->tasks->first()->path() , [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks',[
            'body' => 'changed',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_task_can_mark_as_incomplete() {

        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTask(1)
            ->create();

        $this->patch($project->tasks->first()->path() , [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->patch($project->tasks->first()->path() , [
            'body' => 'changed',
            'completed' => false
        ]);

        $this->assertDatabaseHas('tasks',[
            'body' => 'changed',
            'completed' => false
        ]);
    }
}
