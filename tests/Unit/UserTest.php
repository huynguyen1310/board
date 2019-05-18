<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Facades\Tests\Setup\ProjectFactory;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function has_projects() 
    {
        $user = factory('App\User')->create();
        
        $this->assertInstanceOf(Collection::class , $user->projects) ;
    }

    /** @test */
    public function has_accesible_projects() 
    {
        $john = $this->signIn();

        $project = ProjectFactory::ownedBy($john)->create();
    
        $this->assertCount(1,$john->accesibleProjects());

        $sally = factory(User::class)->create();
        $nick = factory(User::class)->create();


        $sallyProject = ProjectFactory::ownedBy($sally)->create();
        $sallyProject->invite($nick);

        $this->assertCount(1,$john->accesibleProjects());

        $sallyProject->invite($john);
        
        $this->assertCount(2,$john->accesibleProjects());

    }
}
