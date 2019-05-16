<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;
    

    /** @test */
    public function creating_project()
    {
        $project = ProjectFactory::create();
    
        $this->assertCount(1,$project->activity);
        $this->assertEquals('created' , $project->activity[0]->description);
    }

    /** @test */
    public function updating_a_project()
    {
        $project = ProjectFactory::create();

        $project->update(['title'=>'changed']);

        $this->assertCount(2 , $project->activity);
        $this->assertEquals('updated' , $project->activity->last()->description);
    }

    /** @test */
    public function creating_a_new_task()
    {
        $project = ProjectFactory::create();

        $project->addTask('Task');

        $this->assertCount(2 , $project->activity);
        $this->assertEquals('created_task' , $project->activity->last()->description);

    }

    /** @test */
    public function completing_a_new_task()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->withTask(1)->create();

        $this->patch($project->tasks[0]->path() , [
            'body' => 'foobar',
            'completed' => true
        ]);

        $this->assertCount(3 , $project->activity);
        $this->assertEquals('completed_task' , $project->activity->last()->description);
    }

    /** @test */
    public function incomplete_a_new_task()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->withTask(1)->create();

        $this->patch($project->tasks[0]->path() , [
            'body' => 'foobar',
            'completed' => true
        ]);

        $this->assertCount(3 , $project->activity);

        $this->patch($project->tasks[0]->path() , [
            'body' => 'foobar',
            'completed' => false
        ]);

        $this->assertCount(4 , $project->fresh()->activity);

        $this->assertEquals('incompleted_task' , $project->fresh()->activity->last()->description);
    }
    
    /** @test */
    public function deleting_a_task()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->withTask(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3 , $project->fresh()->activity);


    }
}