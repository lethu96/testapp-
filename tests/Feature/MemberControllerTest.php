<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Member;
use Faker\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Response;
use Lang;
use File;

class MemberControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateMemberHaveAvatar()
    {
        $stub = public_path().'/img/aaa.jpg';
        $name = str_random(8).'.jpg';
        $path = public_path().'/img/test/'.$name;
        copy($stub, $path);
        $file = new UploadedFile($path, $name, 'image/jpg', filesize($path), null, true);
        $newMember = Factory(Member::class)->create([
        'name' => 'thu',
        'information' => 'inter',
        'phone_number' => '0978716945',
        'birthday' => '1996-12-12',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => $file,
        ])->toArray();
        $response = $this->json('POST', 'members/create', $newMember);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members', [
            'name' => $newMember['name'],
            'information' => $newMember['information'],
            'phone_number' => $newMember['phone_number'],
            'birthday' => $newMember['birthday'],
            'position_id' => $newMember['position_id'],
            'gender' => $newMember['gender']
            ]);
    }

    public function testCreateMemberHaveAvatarMorethan10MB()
    {
        $stub = public_path().'/img/nui.jpeg';
        $name = str_random(8).'.jpeg';
        $path = public_path().'/img/test/'.$name;
        copy($stub, $path);
        $file = new UploadedFile($path, $name, 'image/jpeg', filesize($path), null, true);
        $newMember = [
        'name' => 'thuuu',
        'information' => 'interu',
        'phone_number' => '09716945',
        'birthday' => '1996-12-10',
        'position_id' => 3,
        'gender' => 'female',
        'avatar' => $file,
        ];
        $response = $this->json('POST', 'members/create', $newMember);
        $this->assertEquals(422, $response->status()) ;
        $this->assertDatabaseMissing('members', [
            'name' => $newMember['name'],
            'information' => $newMember['information'],
            'phone_number' => $newMember['phone_number'],
            'birthday' => $newMember['birthday'],
            'position_id' => $newMember['position_id'],
            'gender' => $newMember['gender']
            ]);
    }

    public function testCreateMemberHaveAvatarLessThan10MB()
    {
        $stub = public_path().'/img/vnvd.jpg';
        $name = str_random(8).'.jpg';
        $path = public_path().'/img/test/'.$name;
        copy($stub, $path);
        $file  = new UploadedFile($path, $name, 'image/jpg', filesize($path), null, true) ;
        $newMember = [
        'name' => 'thuuu',
        'information' => 'interu',
        'phone_number' => '09716945',
        'birthday' => '1996-12-10',
        'position_id' => 3,
        'gender' => 'female',
        'avatar' => $file,
        ];
        $response = $this->json('POST', 'members/create', $newMember);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members', [
            'name' => $newMember['name'],
            'information' => $newMember['information'],
            'phone_number' => $newMember['phone_number'],
            'birthday' => $newMember['birthday'],
            'position_id' => $newMember['position_id'],
            'gender' => $newMember['gender']
            ]);
    }

    public function testCreateMemberHaveAvatarNotImage()
    {
        $stub = public_path().'/img/aa.txt';
        $name = str_random(8).'.txt';
        $path = public_path().'/img/test/'.$name;
        copy($stub, $path);
        $file = new UploadedFile($path, $name, 'image/jpg', filesize($path), null, true);
        $newMember = [
        'name' => 'thuuu',
        'information' => 'interu',
        'phone_number' => '09716945',
        'birthday' => '1996-12-10',
        'position_id' => 3,
        'gender' => 'female',
        'avatar' => $file,
        ];
        $response = $this->json('POST', 'members/create', $newMember);
        $this->assertEquals(422, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $newMember['name'],
            'information' => $newMember['information'],
            'phone_number' => $newMember['phone_number'],
            'birthday' => $newMember['birthday'],
            'position_id' => $newMember['position_id'],
            'gender' => $newMember['gender']
            ]);
    }

    public function testEditMemberSuccessHaveImage()
    {
        $stub = public_path().'/img/vnvd.jpg';
        $name = str_random(8).'.jpg';
        $path = public_path().'/img/test/'.$name;
        copy($stub, $path);
        $file = new UploadedFile($path, $name, 'image/jpg', filesize($path), null, true);
        $array = [
        'id' => 1,
        'name' => 'thuuu',
        'information' => 'interu',
        'phone_number' => '09716945',
        'birthday' => '1996-12-10',
        'position_id' => 3,
        'gender' => 'female',
        'avatar' => $file,
        ];

        $array1 = Factory(Member::class)->create([
        'name' => 't',
        'information' => 'in',
        'phone_number' => '0945',
        'birthday' => '1996-12-08',
        'position_id' => 1,
        'gender' => 'male',
        'avatar' => 'uht.png',
        ]);
        $response = $this->json('PUT', 'members/update', $array);
        $response->assertStatus(200, $response->status());
        $this->assertDatabaseHas('members', [
        'name' => $array['name'],
        'information' => $array['information'],
        'phone_number' => $array['phone_number'],
        'birthday' => $array['birthday'],
        'position_id' => $array['position_id'],
        'gender' => $array['gender'],
        ]);
    }

    public function testEditMemberWithHaveImageNotImage()
    {
        $stub = public_path().'/img/aa.txt';
        $name = str_random(8).'.txt';
        $path = public_path().'/img/test/'.$name;
        copy($stub, $path);
        $file = new UploadedFile($path, $name, 'image/jpg', filesize($path), null, true);
        $array = [
        'id' => 1,
        'name' => 'thuuu',
        'information' => 'interu',
        'phone_number' => '09716945',
        'birthday' => '1996-12-10',
        'position_id' => 3,
        'gender' => 'female',
        'avatar' => $file,
        ];

        $array1 = Factory(Member::class)->create([
        'name' => 't',
        'information' => 'in',
        'phone_number' => '0945',
        'birthday' => '1996-12-08',
        'position_id' => 1,
        'gender' => 'male',
        'avatar' => 'uht.png',
        ]);
        $response = $this->json('PUT', 'members/update', $array);
        $response->assertStatus(422, $response->status());
        $this->assertDatabaseMissing('members', [
        'name' => $array['name'],
        'information' => $array['information'],
        'phone_number' => $array['phone_number'],
        'birthday' => $array['birthday'],
        'position_id' => $array['position_id'],
        'gender' => $array['gender'],
        ]);
    }

    public function testEditMemberWithHaveImageMax10MB()
    {
        $stub = public_path().'/img/nui.jpeg';
        $name = str_random(8).'.jpeg';
        $path = public_path().'/img/test/'.$name;
        copy($stub, $path);
        $file = new UploadedFile($path, $name, 'image/jpeg', filesize($path), null, true);
        $array = [
        'id' => 1,
        'name' => 'thuuu',
        'information' => 'interu',
        'phone_number' => '09716945',
        'birthday' => '1996-12-10',
        'position_id' => 3,
        'gender' => 'female',
        'avatar' => $file,
        ];
        $array1 = Factory(Member::class)->create([
        'name' => 't',
        'information' => 'in',
        'phone_number' => '0945',
        'birthday' => '1996-12-08',
        'position_id' => 1,
        'gender' => 'male',
        'avatar' => 'uht.png',
        ]);
        $response = $this->json('PUT', 'members/update', $array);
        $response->assertStatus(422, $response->status());
        $this->assertDatabaseMissing('members', [
        'name' => $array['name'],
        'information' => $array['information'],
        'phone_number' => $array['phone_number'],
        'birthday' => $array['birthday'],
        'position_id' => $array['position_id'],
        'gender' => $array['gender'],
        ]);
    }

    public function testListMemberSuccess()
    {
        $project = factory(Member::class)->create();
        $response = $this->get('members');
        $response->assertStatus(200);
    }

    public function testDeleteMemberSuccess()
    {
        $array = Factory(Member::class)->create()->toArray();
        $response = $this->call('DELETE', 'members/destroy', $array);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            'avatar' => $array['avatar']
            ]);
    }

    public function testAddMemberWithNameRequire()
    {
        $array = [
        'name' => '',
        'information' => 'inter',
        'phone_number' => '0978716945',
        'birthday' => '1996-12-12',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
        ];
        $response = $this->json('POST', 'members/create', $array);
        $response->assertStatus(422, $response->status());
        $this->assertDatabaseMissing('members', [
        'name' => $array['name'],
        'information' => $array['information'],
        'phone_number' => $array['phone_number'],
        'birthday' => $array['birthday'],
        'position_id' => $array['position_id'],
        'gender' => $array['gender'],
        ]);
    }

    public function testAddMemberWithValidName()
    {
        $array = [
        'name' => 'xincha+_)',
        'information' => 'inter',
        'phone_number' => '0978716945',
        'birthday' => '1996-12-12',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
        ];
        $response = $this->json('POST', 'members/create', $array);
        $response->assertStatus(422, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testAddMemberWithNameMax50()
    {
        $array = [
        'name' => 'xinchaodaylathuxinchaodaylathuxinchaodaylathuxinchaodaylathu
        xinchaodaylathuxinchaodaylathu',
        'information' => 'inter',
        'phone_number' => '0978716945',
        'birthday' => '1996-12-12',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
        ];
        $response = $this->json('POST', 'members/create', $array);
        $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testAddMemberWithInformationMax300()
    {
        $array = [
        'name' => 'xinchao',
        'information' => 'interinterinterinterinterinterinterinterinterinterinter
        interinterinterinterinterinterinterinterinterinterinterinterinterinter
        interinterinterinterinterinterinterinterinterinterinterinterinterinter
        interinterinterinterinterinterinterinterinterinterinterinterinterinter
        interinterinterinterinterinterinterinterinterinterinterinterinterinter
        interinterinterinterinterinterinterinterinterinter',
        'phone_number' => '0978716945',
        'birthday' => '1996-12-12',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
        ];
        $response = $this->json('POST', 'members/create', $array);
        $response->assertStatus(422, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testAddMemberWithPhoneNumberRequired()
    {
        $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '',
        'birthday' => '1996-12-12',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
        ];
        $response = $this->json('POST', 'members/create', $array);
        $response->assertStatus(422, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testAddMemberWithPhoneNumberValid()
    {
        $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '098273%',
        'birthday' => '1996-12-12',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
        ];
        $response = $this->json('POST', 'members/create', $array);
        $response->assertStatus(422, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testAddMemberWithPhoneNumberMax20()
    {
        $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '012345678909876543212',
        'birthday' => '1996-12-12',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
        ];
        $response = $this->json('POST', 'members/create', $array);
        $response->assertStatus(422, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testAddMemberWithBirthdayRequired()
    {
        $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '0123456',
        'birthday' => '',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
         ];
         $response = $this->json('POST', 'members/create', $array);
         $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testAddMemberWithBirthdayValidDate()
    {
        $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '0123456',
        'birthday' => '2017h',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
         ];
         $response = $this->json('POST', 'members/create', $array);
         $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testAddMemberWithBirthdayValidBefore()
    {
        $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '0123456',
        'birthday' => '2018-02-02',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
         ];
         $response = $this->json('POST', 'members/create', $array);
         $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testAddMemberWithBirthdayValidDateAfter()
    {
        $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '0123456',
        'birthday' => '1957-10-10',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
        ];
        $response = $this->json('POST', 'members/create', $array);
        $response->assertStatus(422, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testAddMemberWithPositionRequired()
    {
        $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '0123456',
        'birthday' => '1996-12-12',
        'position_id' => '',
        'gender' => 'female',
        'avatar' => '',
        ];
        $response = $this->json('POST', 'members/create', $array);
        $response->assertStatus(422, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testAddMemberWithPositionValid()
    {
        $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '0123456',
        'birthday' => '1996-12-12',
        'position_id' => 'ha',
        'gender' => 'female',
        'avatar' => '',
        ];
        $response = $this->json('POST', 'members/create', $array);
        $response->assertStatus(422, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testAddMemberWithGenderRequired()
    {
        $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '0123456',
        'birthday' => '1996-12-12',
        'position_id' => 1,
        'gender' => '',
        'avatar' => '',
         ];
         $response = $this->json('POST', 'members/create', $array);
         $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testAddMemberWithGenderValid()
    {
        $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '0123456',
        'birthday' => '1996-12-12',
        'position_id' => 'ha',
        'gender' => 'emale',
        'avatar' => '',
         ];
         $response = $this->json('POST', 'members/create', $array);
         $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testEditMemberWithValidName()
    {
         $array = [
        'name' => 'xincha+_)',
        'information' => 'inter',
        'phone_number' => '0978716945',
        'birthday' => '1996-12-12',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
         ];
         $array1 = Factory(Member::class)->create()->toArray();
         $response = $this->json('PUT', 'members/update', $array);
         $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testEditMemberWithNameMax50()
    {
         $array = [
        'name' => 'xinchaodaylathuxinchaodaylathuxinchaodaylathuxinchaodaylathu
         xinchaodaylathuxinchaodaylathu',
        'information' => 'inter',
        'phone_number' => '0978716945',
        'birthday' => '1996-12-12',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
         ];
         $array1 = Factory(Member::class)->create()->toArray();
         $response = $this->json('PUT', 'members/update', $array);
         $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testEditMemberWithInformationMax300()
    {
        $array = [
        'name' => 'xinchao',
        'information' => 'interinterinterinterinterinterinterinterinterinterinter
        interinterinterinterinterinterinterinterinterinterinterinterinterinter
        interinterinterinterinterinterinterinterinterinterinterinterinterinter
        interinterinterinterinterinterinterinterinterinterinterinterinterinter
        interinterinterinterinterinterinterinterinterinterinterinterinterinter
        interinterinterinterinterinterinterinterinterinter',
        'phone_number' => '0978716945',
        'birthday' => '1996-12-12',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
        ];
        $array1 = Factory(Member::class)->create()->toArray();
        $response = $this->json('PUT', 'members/update', $array);
        $response->assertStatus(422, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testEditMemberWithPhoneNumberValid()
    {
        $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '098273%',
        'birthday' => '1996-12-12',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
        ];
        $array1 = Factory(Member::class)->create()->toArray();
        $response = $this->json('PUT', 'members/update', $array);
        $response->assertStatus(422, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testEditMemberWithPhoneNumberMax20()
    {
        $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '012345678909876543212',
        'birthday' => '1996-12-12',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
        ];
         $array1 = Factory(Member::class)->create()->toArray();
         $response = $this->json('PUT', 'members/update', $array);
         $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testEditMemberWithBirthdayValidDate()
    {
        $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '0123456',
        'birthday' => '2017h',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
        ];
         $array1 = Factory(Member::class)->create()->toArray();
         $response = $this->json('PUT', 'members/update', $array);
         $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testEditMemberWithBirthdayValidBefore()
    {
         $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '0123456',
        'birthday' => '2018-02-02',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
         ];
         $array1 = Factory(Member::class)->create()->toArray();
         $response = $this->json('PUT', 'members/update', $array);
         $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testEditMemberWithBirthdayValidDateAfter()
    {
        $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '0123456',
        'birthday' => '1957-10-10',
        'position_id' => 1,
        'gender' => 'female',
        'avatar' => '',
        ];
        $array1 = Factory(Member::class)->create()->toArray();
        $response = $this->json('PUT', 'members/update', $array);
        $response->assertStatus(422, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testEditMemberWithPositionValid()
    {
         $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '0123456',
        'birthday' => '1996-12-12',
        'position_id' => 'ha',
        'gender' => 'female',
        'avatar' => '',
         ];
         $array1 = Factory(Member::class)->create()->toArray();
         $response = $this->json('PUT', 'members/update', $array);
         $response->assertStatus(422, $response->status());
         $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }

    public function testEditMemberWithGenderValid()
    {
        $array = [
        'name' => 'halo',
        'information' => 'inter',
        'phone_number' => '0123456',
        'birthday' => '1996-12-12',
        'position_id' => 'ha',
        'gender' => 'emale',
        'avatar' => '',
        ];
        $array1 = Factory(Member::class)->create()->toArray();
        $response = $this->json('PUT', 'members/update', $array);
        $response->assertStatus(422, $response->status());
        $this->assertDatabaseMissing('members', [
            'name' => $array['name'],
            'information' => $array['information'],
            'phone_number' => $array['phone_number'],
            'birthday' => $array['birthday'],
            'position_id' => $array['position_id'],
            'gender' => $array['gender'],
            ]);
    }
}
