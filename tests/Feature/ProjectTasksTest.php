<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;
use App\Task;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->withOutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $this->post($project->path() . '/tasks' , ['body' => 'Test task']);

        $this->get($project->path())->assertSee('Test task');

    }

    // /** @test */
    // public function a_task_require_a_body()
    // {
    //     // $this->withOutExceptionHandling();

    //     $this->signIn();

    //     $project =  auth()->user()->projects()->create(
    //         factory(Project::class)->raw()
    //     );

    //     $task = factory(Task::class)->raw(['body' => '']) ;

    //     $this->post($project->path() . '/task', $task)->assertSessionHasErrors('body');

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
        
        $project = factory(Project::class)->create();

        $task = $project->addTask('Test task');

        $this->patch($project->path() . '/tasks/' . $task->id , ['body' => 'changed'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks' , ['body' => 'changed']);
    }

    /** @test */
    public function a_task_can_be_updated() {
        $this->signIn();
        
        $project =  auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $task = $project->addTask('Test task');

        $this->patch($project->path() . '/tasks/' . $task->id , [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks',[
            'body' => 'changed',
            'completed' => true
        ]);
    }
}
