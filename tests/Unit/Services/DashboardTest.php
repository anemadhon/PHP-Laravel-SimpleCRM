<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Role;
use App\Services\DashboardService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_list_dashboard_for_admin()
    {
        $role = Role::factory(6)->create();

        $lists = (new DashboardService())->statistic($role->first()->id);
        
        $this->assertArrayHasKey('roles', $lists);
    }
    
    public function test_list_dashboard_for_manager()
    {
        Role::factory(6)->create();

        $lists = (new DashboardService())->statistic(2);
        
        $this->assertArrayNotHasKey('roles', $lists);
    }
    
    public function test_list_dashboard_for_pm()
    {
        Role::factory(6)->create();

        $lists = (new DashboardService())->statistic(3);
        
        $this->assertArrayNotHasKey('types', $lists);
    }
    
    public function test_list_dashboard_for_sales()
    {
        Role::factory(6)->create();

        $lists = (new DashboardService())->statistic(4);
        
        $this->assertArrayHasKey('types', $lists);
    }
    
    public function test_list_dashboard_for_developer_and_qa()
    {
        Role::factory(6)->create();

        $lists = (new DashboardService())->statistic(5);
        
        $this->assertEmpty($lists);
    }
}
