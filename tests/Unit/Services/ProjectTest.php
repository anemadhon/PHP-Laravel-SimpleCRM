<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Level;
use App\Models\Client;
use App\Models\Project;
use App\Models\ClientType;
use App\Models\ProjectState;
use App\Services\ProjectService;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_project_lists()
    {
        Role::factory(6)->create();

        $pm = User::factory()->pm()->create();

        $state = ProjectState::create([
            'name' => 'Development',
            'description' => 'On Development',
            'for' => 'dev',
            'slug' => 'development',
        ]);

        $level = Level::create([
            'name' => 'Low',
            'slug' => 'low'
        ]);

        $type = ClientType::create([
            'name' => 'Company',
            'description' => 'For Company',
            'criteria' => 'PT, Custom',
            'slug' => 'company',
        ]);

        $client = Client::create([
            'name' => 'BTN',
            'description' => 'Bank Tabungan Indonesia',
            'slug' => 'low',
            'type_id' => $type->id
        ]);

        Project::create([
            'name' => 'Apps',
            'description' => 'Application',
            'started_at' => '2022-01-01',
            'ended_at' => '2022-04-30',
            'slug' => 'apps',
            'state_id' => $state->id,
            'level_id' => $level->id,
            'client_id' => $client->id
        ]);

        $lists = (new ProjectService())->lists($pm);

        $this->assertIsObject($lists);
    }

    public function test_get_extension_file()
    {
        $extension = (new ProjectService())->extensionFile('userguide.pdf');
        
        $this->assertEquals('pdf', $extension);
    }
    
    public function test_get_formatted_path()
    {
        $path = 'project/attachments/project-test/userguide.pdf';
        $formattedPath = (new ProjectService())->formatPath($path);

        $this->assertEquals('app\\public\\project\\attachments\\project-test\\userguide.pdf', $formattedPath);
    }

    public function test_get_team()
    {
        Role::factory(6)->create();

        $pm = User::factory()->pm()->create();
        $dev = User::factory(6)->developer()->create();
        $qa = User::factory(2)->qa()->create();

        $pm = [
            'pm' => $pm->id,
        ];

        $devTeam = [
            'dev' => $dev->pluck('id')
        ];

        $qa = [
            'qa' => $qa->first()->id
        ];

        $team = (new ProjectService())->team(($pm + $devTeam + $qa));

        $this->assertEquals([1,2,3,4,5,6,7,8], $team);
    }

    public function test_can_add_idle_user_to_team()
    {
        Role::factory(6)->create();

        $pm = User::factory()->pm()->create();
        $dev = User::factory(6)->developer()->create();
        $qa = User::factory(2)->qa()->create();

        $state = ProjectState::create([
            'name' => 'Development',
            'description' => 'On Development',
            'for' => 'dev',
            'slug' => 'development',
        ]);

        $level = Level::create([
            'name' => 'Low',
            'slug' => 'low'
        ]);

        $type = ClientType::create([
            'name' => 'Company',
            'description' => 'For Company',
            'criteria' => 'PT, Custom',
            'slug' => 'company',
        ]);

        $client = Client::create([
            'name' => 'BTN',
            'description' => 'Bank Tabungan Indonesia',
            'slug' => 'low',
            'type_id' => $type->id
        ]);
        
        $project = Project::create([
            'name' => 'Apps',
            'description' => 'Application',
            'started_at' => '2022-01-01',
            'ended_at' => '2022-04-30',
            'slug' => 'apps',
            'state_id' => $state->id,
            'level_id' => $level->id,
            'client_id' => $client->id
        ]);

        DB::table('project_user')->insert([
            'project_id' => $project->id,
            'user_id' => $pm->id,
            'pm_id' => $pm->id,
            'status' => 1 
        ]);

        $devTeam = [
            'dev' => $dev->pluck('id')
        ];

        $qa = [
            'qa' => $qa->first()->id
        ];

        $availability = (new ProjectService())->availabilityStatusCheck(($devTeam + $qa));;
        
        $this->assertEquals('available', $availability['status']);
    }

    public function test_cannot_add_user_on_project_to_team()
    {
        Role::factory(6)->create();

        $pm = User::factory()->pm()->create();
        $dev = User::factory(6)->developer()->create();
        $qa = User::factory(2)->qa()->create();

        $state = ProjectState::create([
            'name' => 'Development',
            'description' => 'On Development',
            'for' => 'dev',
            'slug' => 'development',
        ]);

        $level = Level::create([
            'name' => 'Low',
            'slug' => 'low'
        ]);

        $type = ClientType::create([
            'name' => 'Company',
            'description' => 'For Company',
            'criteria' => 'PT, Custom',
            'slug' => 'company',
        ]);

        $client = Client::create([
            'name' => 'BTN',
            'description' => 'Bank Tabungan Indonesia',
            'slug' => 'low',
            'type_id' => $type->id
        ]);

        $project = Project::create([
            'name' => 'Apps',
            'description' => 'Application',
            'started_at' => '2022-01-01',
            'ended_at' => '2022-04-30',
            'slug' => 'apps',
            'state_id' => $state->id,
            'level_id' => $level->id,
            'client_id' => $client->id
        ]);

        DB::table('project_user')->insert([
            'project_id' => $project->id,
            'user_id' => $pm->id,
            'pm_id' => $pm->id,
            'status' => 1 
        ]);

        $devTeam = [
            'dev' => [$pm->id] + $dev->pluck('id')->toArray()
        ];

        $qa = [
            'qa' => $qa->last()->id
        ];

        $availability = (new ProjectService())->availabilityStatusCheck(($devTeam + $qa));;
        
        $this->assertEquals('on_project', $availability['status']);
    }

    public function test_formatted_errors()
    {
        $ids = [];

        $role = Role::factory()->create();

        $user = User::factory()->create([
            'role_id' => $role->id
        ]);

        $ids[] = $user->id;

        $errors = (new ProjectService())->formatErrors($ids);;
        
        $this->assertStringContainsString('has assigned on others Project', $errors[0]);
    }
}
