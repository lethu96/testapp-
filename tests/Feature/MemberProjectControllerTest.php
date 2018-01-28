<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\MemberProject;
use Faker\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class MemberProjectControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testListMemberProjectSuccess()
    {
        $project = factory(MemberProject::class)->create();
        $response = $this->get('member_projects');
        $response->assertStatus(200);
    }

    public function testDeleteMemberProjectSuccess()
    {
        $array = Factory(MemberProject::class)->create()->toArray();
        $response = $this->call('DELETE', 'member_projects/destroy', $array);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseMissing('projects', [
            'meber_id'=>$array['meber_id'],
            'project_id'=>$array['project_id'],
            'role'=>$array['role'],
        ]);
    }

    public function testEditMemberProjectSuccess()
    {
        $json = '{"id":1,"meber_id":1,"project_id":1,"role":"haha"}';
        $array1 = [
            'id'=>1,
            'meber_id'=>1,
            'project_id'=>1,
            'role'=>'haha',
        ];
        $array = Factory(MemberProject::class)->create()->toArray();
        $response=$this->json('PUT', 'member_projects/update', $array1);
        $this->assertSame($json, $response->getContent());
        $response->assertStatus(200, $response->status());
        $response->assertSuccessful();
    }

    public function testAddMemberProjecSuccess()
    {
        $json = '{"meber_id":1,"project_id":1,"role":"haha","id":1}';
        $array1 = [
            'id'=>1,
            'meber_id'=>1,
            'project_id'=>1,
            'role'=>'haha',
        ];
        $response = $this->json('POST', 'member_projects/create', $array1);
        $this->assertSame($json, $response->getContent());
        $response->assertStatus(200, $response->status());
        $response->assertSuccessful();
    }

    public function testAddMemberProjecSuccessWithRoleNull()
    {
        $json = '{"meber_id":1,"project_id":1,"role":"","id":1}';
        $array1 = [
            'id'=>1,
            'meber_id'=>1,
            'project_id'=>1,
            'role'=>'',
        ];
        $response = $this->json('POST', 'member_projects/create', $array1);
        $this->assertSame($json, $response->getContent());
        $response->assertStatus(200, $response->status());
        $response->assertSuccessful();
    }

    public function testAddMemberProjectWithMemberIdRequired()
    {
        $array = [
            'meber_id'=>'',
            'project_id'=>1,
            'role'=>'haha',
        ];
        $response = $this->json('POST', 'member_projects/create', $array);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'meber_id'=>$array['meber_id'],
            'project_id'=>$array['project_id'],
            'role'=>$array['role'],
            ]);
    }

    public function testAddMemberProjectWithProjectIdRequired()
    {
        $array = [
        'meber_id'=>1,
        'project_id'=>'',
        'role'=>'haha',
        ];
        $response = $this->json('POST', 'member_projects/create', $array);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'meber_id'=>$array['meber_id'],
            'project_id'=>$array['project_id'],
            'role'=>$array['role'],
            ]);
    }

    public function testAddMemberProjectWithValidMemberId()
    {
        $array = [
            'meber_id'=>'eeee',
            'project_id'=>1,
            'role'=>'haha',
        ];
        $response=$this->json('POST', 'member_projects/create', $array);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'meber_id'=>$array['meber_id'],
            'project_id'=>$array['project_id'],
            'role'=>$array['role'],
           ]);
    }

    public function testAddMemberProjectWithValidProjectId()
    {
        $array = [
            'meber_id'=>1,
            'project_id'=>'ddd',
            'role'=>'haha',
        ];
        $response = $this->json('POST', 'member_projects/create', $array);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'meber_id'=>$array['meber_id'],
            'project_id'=>$array['project_id'],
            'role'=>$array['role'],
           ]);
    }

    public function testEditMemberProjectWithValidMemberId()
    {
        $array = [
            'meber_id'=>'eeee',
            'project_id'=>1,
            'role'=>'haha',
        ];
        $response = $this->json('PUT', 'member_projects/update', $array);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'meber_id'=>$array['meber_id'],
            'project_id'=>$array['project_id'],
            'role'=>$array['role'],
           ]);
    }

    public function testEditMemberProjectWithValidProjectId()
    {
        $array = [
            'meber_id'=>1,
            'project_id'=>'ddd',
            'role'=>'haha',
        ];
        $response = $this->json('PUT', 'member_projects/update', $array);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'meber_id'=>$array['meber_id'],
            'project_id'=>$array['project_id'],
            'role'=>$array['role'],
           ]);
    }
}
