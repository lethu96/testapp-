<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Project;
use Faker\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ProjectControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    public function testListProjectSuccess()
    {
        $project = factory(Project::class)->create();
        $response = $this->get('project');
        $response->assertStatus(200);
    }

    public function testEditNotId(){
        $array1 = [
        'id' => '',
        'name' => 'test',
        'information' => 'tr',
        'deadline' => '2018-02-25',
        'type' => 'single',
        'status' => 'planned',
        ];
        $response = $this->json('DELETE', 'project/destroy', $array1);

        $response->assertStatus(404, $response->status());
    }

    public function testDeleteProjectSuccess()
    {
        $array = Factory(Project::class)->create()->toArray();
        $response = $this->call('DELETE', 'project/destroy', $array);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseMissing('projects', [
        'name' => $array['name'],
        'information' => $array['information'],
        'deadline' => $array['deadline'],
        'type' => $array['type'],
        'status' => $array['status']
        ]);
    }

    public function testEditProjectSuccess()
    {
        $json = '{"id":1,"name":"test","information":"tr",'.
        '"deadline":"2018-02-25","type":"single","status":"planned"}';
        $array1 = [
        'id' => 1,
        'name' => 'test',
        'information' => 'tr',
        'deadline' => '2018-02-25',
        'type' => 'single',
        'status' => 'planned',
        ];
        $array = Factory(Project::class)->create()->toArray();
        $response = $this->json('PUT', 'project/update', $array1);
        $this->assertSame($json, $response->getContent());
        $response->assertStatus(200, $response->status());
        $response->assertSuccessful();
    }

    public function testAddProjecSuccess()
    {
        $json = '{"name":"testapp","information":"traniing",'.
        '"deadline":"2018-02-25","type":"lab","status":"planned","id":1}';
        $array = [
            'name' => 'testapp',
            'information' => 'traniing',
            'deadline' => '2018-02-25',
            'type' => 'lab',
            'status' => 'planned',
        ];
        $response = $this->json('POST', 'project/create', $array);
        $this->assertSame($json, $response->getContent());
        $response->assertStatus(200, $response->status());
        $response->assertSuccessful();
    }

    public function testAddProjectFailWithNameNull()
    {
        $array = [
            'name' => '',
            'information' => 'traniing',
            'deadline' => '2018-01-22',
            'type' => 'lab',
            'status' => 'planned',
        ];
        $response = $this->json('POST', 'project/create', $array);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'name' => $array['name'],
            'information' => $array['information'],
            'deadline' => $array['deadline'],
            'type' => $array['type'],
            'status' => $array['status']
           ]);
    }

    public function testAddProjectWithNameMax10()
    {
        $array = [
            'name' => 'xinchaooooo',
            'information' => 'traniing',
            'deadline' => '2018-02-22',
            'type' => 'lab',
            'status' => 'planned',
        ];
        $response = $this->json('POST', 'project/create', $array);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'name' => $array['name'],
            'information' => $array['information'],
            'deadline' => $array['deadline'],
            'type' => $array['type'],
            'status' => $array['status']
           ]);
    }

    public function testAddProjectWithNameNotValid()
    {
        $array = [
            'name' => 'thu123$#%',
            'information' => 'traniing',
            'deadline' => '2018-01-22',
            'type' => 'lab',
            'status' => 'planned',
        ];
        $response = $this->json('POST', 'project/create', $array);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'name' => $array['name'],
            'information' => $array['information'],
            'deadline' => $array['deadline'],
            'type' => $array['type'],
            'status' => $array['status']
           ]);
    }

    public function testAddProjecInformationMax300()
    {
        $array = [
            'name' => 'thu',
            'information' => 'traniinggggggggggggggggggggggggggggggggggggggg
            gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg
            gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg
            gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg
            gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg
            gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg
            gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg
            gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg
            gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg
            gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg
            gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg
            gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg
            gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg',
            'deadline' => '2018-01-22',
            'type' => 'lab',
            'status' => 'planned',
        ];
        $response = $this->json('POST', 'project/create', $array);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'name' => $array['name'],
            'information' => $array['information'],
            'deadline' => $array['deadline'],
            'type' => $array['type'],
            'status' => $array['status']
           ]);
    }

    public function testAddProjectWithNotValidDeadline()
    {
        $array = [
            'name' => 'thu12',
            'information' => 'traniing',
            'deadline' => '2018',
            'type' => 'lab',
            'status' => 'planned',
        ];
        $response = $this->json('POST', 'project/create', $array);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'name' => $array['name'],
            'information' => $array['information'],
            'deadline' => $array['deadline'],
            'type' => $array['type'],
            'status' => $array['status']
           ]);
    }

    public function testAddProjecFailTypeRequired()
    {
        $array = [
            'name' => 'thu12',
            'information' => 'traniing',
            'deadline' => '2018',
            'type' => '',
            'status' => 'planned',
        ];
        $response = $this->json('POST', 'project/create', $array);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'name' => $array['name'],
            'information' => $array['information'],
            'deadline' => $array['deadline'],
            'type' => $array['type'],
            'status' => $array['status']
           ]);
    }

    public function testAddProjecWithNotValidType()
    {
        $array = [
            'name' => 'thu12',
            'information' => 'traniing',
            'deadline' => '2018',
            'type' => 'lap',
            'status' => 'planned',
        ];
        $response = $this->json('POST', 'project/create', $array);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'name' => $array['name'],
            'information' => $array['information'],
            'deadline' => $array['deadline'],
            'type' => $array['type'],
            'status' => $array['status']
           ]);
    }

    public function testAddProjectWithStatusRequired()
    {
        $array = [
            'name' => 'thu12',
            'information' => 'traniing',
            'deadline' => '2018',
            'type' => 'lab',
            'status' => ' ',
        ];
        $response = $this->json('POST', 'project/create', $array);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'name' => $array['name'],
            'information' => $array['information'],
            'deadline' => $array['deadline'],
            'type' => $array['type'],
            'status' => $array['status']
           ]);
    }

    public function testAddProjecWithNotValidStatus()
    {
        $array = [
            'name' => 'thu12',
            'information' => 'traniing',
            'deadline' => '2018',
            'type' => 'lap',
            'status' => 'plan',
        ];
        $response = $this->json('POST', 'project/create', $array);
        $response->assertStatus(422);
        $this->assertDatabaseMissing('projects', [
        'name' => $array['name'],
        'information' => $array['information'],
        'deadline' => $array['deadline'],
        'type' => $array['type'],
        'status' => $array['status']
        ]);
    }

    public function testEditProjectWithNotValidName()
    {
        $array1 = [
            'name' => 'thu123$#%',
            'information' => 'traniing',
            'deadline' => '2018-01-22',
            'type' => 'lab',
            'status' => 'planned',
        ];
        $array = Factory(Project::class)->create()->toArray();
        $response=$this->json('PUT', 'project/update', $array1);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'name' => $array1['name'],
            'information' => $array1['information'],
            'deadline' => $array1['deadline'],
            'type' => $array1['type'],
            'status' => $array1['status']
           ]);
    }

    public function testEditProjectWithNameMax10()
    {
        $array1 = [
        'name' => 'thuthuthuthuthuthu',
        'information' => 'traniing',
        'deadline' => '2018-01-22',
        'type' => 'lab',
        'status' => 'planned',
        ];
        $array = Factory(Project::class)->create()->toArray();
        $response = $this->json('PUT', 'project/update', $array1);
        $response->assertStatus(422, $response->status());
        $this->assertDatabaseMissing('projects', [
        'name' => $array1['name'],
        'information' => $array1['information'],
        'deadline' => $array1['deadline'],
        'type' => $array1['type'],
        'status' => $array1['status']
        ]);
    }

    public function testEidtProjectWithInformationMax300()
    {
        $array1 = [
            'name' => 'thu',
            'information' => 'traniingtraniingtraniingtraniingtraniingtraniing
            traniingtraniingtraniingtraniingtraniingtraniingtraniingtraniing
            traniingtraniingtraniingtraniingtraniingtraniingtraniingtraniing
            traniingtraniingtraniingtraniingtraniingtraniingtraniingtraniing
            traniingtraniingtraniingtraniingtraniingtraniingtraniingtraniing
            traniingtraniingtraniingtraniingtraniingtraniingtraniingtraniing
            traniingtraniingtraniingtraniingtraniingtraniingtraniingtraniing
            traniingtraniingtraniingtraniingtraniing',
            'deadline' => '2018-02-02',
            'type' => 'lab',
            'status' => 'planned',
        ];
        $array = Factory(Project::class)->create()->toArray() ;
        $response = $this->json('PUT', 'project/update', $array1);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'name' => $array1['name'],
            'information' => $array1['information'],
            'deadline' => $array1['deadline'],
            'type' => $array1['type'],
            'status' => $array1['status']
           ]);
    }

    public function testEditProjectWithNotValidDate()
    {
        $array1 = [
            'name' => 'thu',
            'information' => 'traniing',
            'deadline' => '2018',
            'type' => 'lab',
            'status' => 'planned',
        ];
        $array = Factory(Project::class)->create()->toArray();
        $response = $this->json('PUT', 'project/update', $array1);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'name' => $array1['name'],
            'information' => $array1['information'],
            'deadline' => $array1['deadline'],
            'type' => $array1['type'],
            'status' => $array1['status']
           ]);
    }

    public function testEidtProjectWithDateNotFeature()
    {
        $array1 = [
            'name' => 'thu',
            'information' => 'traniing',
            'deadline' => '2018-01-22',
            'type' => 'lab',
            'status' => 'planned',
        ];
        $array = Factory(Project::class)->create()->toArray();
        $response = $this->json('PUT', 'project/update', $array1);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'name' => $array1['name'],
            'information' => $array1['information'],
            'deadline' => $array1['deadline'],
            'type' => $array1['type'],
            'status' => $array1['status']
           ]);
    }

    public function testEditProjectWithNotValidType()
    {
        $array1 = [
            'name' => 'thu123$#%',
            'information' => 'traniing',
            'deadline' => '2018-01-22',
            'type' => 'lap',
            'status' => 'planned',
        ];
        $array = Factory(Project::class)->create()->toArray();
        $response = $this->json('PUT', 'project/update', $array1);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'name' => $array1['name'],
            'information' => $array1['information'],
            'deadline' => $array1['deadline'],
            'type' => $array1['type'],
            'status' => $array1['status']
           ]);
    }

    public function testEidtProjectWithNotValidStatus()
    {
        $array1 = [
            'name' => 'thu123$#%',
            'information' => 'traniing',
            'deadline' => '2018-01-22',
            'type' => 'lab',
            'status' => 'plan',
        ];
        $array = Factory(Project::class)->create()->toArray();
        $response = $this->json('PUT', 'project/update', $array1);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('projects', [
            'name' => $array1['name'],
            'information' => $array1['information'],
            'deadline' => $array1['deadline'],
            'type' => $array1['type'],
            'status' => $array1['status']
           ]);
    }
}
