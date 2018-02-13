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
use App\Position;

class MemberControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    public function testCreateMemberHaveAvatar()
    {
        $stub = public_path().'/img/vnvd.jpg';
        $name = 'vnvd'.'.jpg';
        $path = public_path().'/img/test/'.$name;
        copy($stub, $path);
        $file = new UploadedFile($path, $name, 'image/jpg', filesize($path), null, true);
        $json = '{"information":"inter","name":"thu","phone_number":"0978716945",'.
            '"birthday":"1996-12-12","position_id":1,"gender":"female","avatar":"vnvd.jpg","id":2}';
        $position = Factory(Position::class)->create();
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
        $this->assertSame($json, $response->getContent());
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
        $name = 'testimg'.'.jpeg';
        $path = public_path().'/img/test/'.$name;
        copy($stub, $path);
        $file = new UploadedFile($path, $name, 'image/jpeg', filesize($path), null, true);
        $json = '{"message":"The given data was invalid.",'.'"errors":'.
            '{"avatar":["The avatar may not be greater than 10240 kilobytes."]}}';
        $newMember = Factory(Member::class)->create([
            'id'=>1,
            'name' => 'thu',
            'information' => 'inter',
            'phone_number' => '0978716945',
            'birthday' => '1996-12-12',
            'position_id' => 1,
            'gender' => 'female',
            'avatar' => $file,
        ])->toArray();
        $response = $this->json('POST', 'members/create', $newMember);
        $this->assertEquals(422, $response->status()) ;
        $this->assertSame($json, $response->getContent());
    }

    public function testCreateMemberHaveAvatarLessThan10MB()
    {
        $stub = public_path().'/img/vnvd.jpg';
        $name = 'imgtest'.'.jpg';
        $path = public_path().'/img/test/'.$name;
        copy($stub, $path);
        $file  = new UploadedFile($path, $name, 'image/jpg', filesize($path), null, true) ;
        $json = '{"information":"inter","name":"thu","phone_number":"0978716945",'.
            '"birthday":"1996-12-12","position_id":1,"gender":"female","avatar":"imgtest.jpg","id":2}';
        $position=Factory(Position::class)->create();
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
        $this->assertSame($json, $response->getContent());
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
        $name = 'imgtest'.'.txt';
        $path = public_path().'/img/test/'.$name;
        copy($stub, $path);
        $file = new UploadedFile($path, $name, 'image/jpg', filesize($path), null, true);
        $json = '{"message":"The given data was invalid.","errors":{"avatar":'.
            '["The avatar must be a file of type: gif, png, jpeg."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testEditMemberSuccessHaveImage()
    {
        $stub = public_path().'/img/vnvd.jpg';
        $name = 'imgtest'.'.jpg';
        $path = public_path().'/img/test/'.$name;
        copy($stub, $path);
        $file = new UploadedFile($path, $name, 'image/jpg', filesize($path), null, true);
        $json = '{"id":1,"name":"thu","information":"inter","phone_number":"0978716945",'.
            '"birthday":"1996-12-12","avatar":"imgtest.jpg","position_id":1,"gender":"female"}';
        $position=Factory(Position::class)->create();
        $newMember = Factory(Member::class)->create([
            'name' => 'thu',
            'information' => 'inter',
            'phone_number' => '0978716945',
            'birthday' => '1996-12-12',
            'position_id' => 1,
            'gender' => 'female',
            'avatar' => $file,
        ])->toArray();
        $array1 = Factory(Member::class)->create([
            'name' => 't',
            'information' => 'in',
            'phone_number' => '0945',
            'birthday' => '1996-12-08',
            'position_id' => 1,
            'gender' => 'male',
            'avatar' => 'uht.png',
        ]);
        $response = $this->json('PUT', 'members/update', $newMember);
        $this->assertSame($json, $response->getContent());
        $response->assertStatus(200, $response->status());
    }

    public function testEditMemberWithHaveImageNotImage()
    {
        $stub = public_path().'/img/aa.txt';
        $name = str_random(8).'.txt';
        $path = public_path().'/img/test/'.$name;
        copy($stub, $path);
        $file = new UploadedFile($path, $name, 'image/jpg', filesize($path), null, true);
        $json = '{"message":"The given data was invalid.","errors":{"avatar":'.
            '["The avatar must be a file of type: gif, png, jpeg."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testEditMemberWithHaveImageMax10MB()
    {
        $stub = public_path().'/img/nui.jpeg';
        $name = str_random(8).'.jpeg';
        $path = public_path().'/img/test/'.$name;
        copy($stub, $path);
        $file = new UploadedFile($path, $name, 'image/jpeg', filesize($path), null, true);
        $json = '{"message":"The given data was invalid.","errors":'.
            '{"avatar":["The avatar may not be greater than 10240 kilobytes."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testListMemberSuccess()
    {
        $project = factory(Member::class)->create();
        $response = $this->get('members');
        $response->assertStatus(200);
    }

    public function testDeleteMemberSuccess()
    {
        $json = '{"message":"Delete success Member 1"}';
        $array = Factory(Member::class)->create()->toArray();
        $response = $this->call('DELETE', 'members/destroy', $array);
        $this->assertEquals(200, $response->status());
        $this->assertSame($json, $response->getContent());
    }

    public function testAddMemberWithNameEmpty()
    {
        $json = '{"message":"The given data was invalid.","errors":'.
            '{"name":["The name field is required."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testAddMemberWithNotValidName()
    {
        $json = '{"message":"The given data was invalid.","errors":'.
            '{"name":["The name format is invalid."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testAddMemberWithNameMax50Character()
    {
        $json = '{"message":"The given data was invalid.","errors":{"name":'.
            '["The name format is invalid.","The name may not be greater than 50 characters."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testAddMemberWithInformationMax300Character()
    {
        $json = '{"message":"The given data was invalid.","errors":'.
            '{"information":["The information may not be greater than 300 characters."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testAddMemberWithPhoneNumberEmpty()
    {
        $json = '{"message":"The given data was invalid.","errors":'.
            '{"phone_number":["The phone number field is required."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testAddMemberWithPhoneNumberNotValid()
    {
        $json = '{"message":"The given data was invalid.","errors":'.
            '{"phone_number":["The phone number format is invalid."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testAddMemberWithPhoneNumberMax20()
    {
        $json = '{"message":"The given data was invalid.","errors":'.
            '{"phone_number":["The phone number may not be greater than 20 characters."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testAddMemberWithBirthdayEmpty()
    {
        $json = '{"message":"The given data was invalid.","errors":'.
            '{"birthday":["The birthday field is required."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testAddMemberWithBirthdayNotValidDate()
    {
        $json = '{"message":"The given data was invalid.","errors":{"birthday":'.
            '["The birthday is not a valid date.","The birthday must be a date before now."]}}';
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
         $this->assertSame($json, $response->getContent());
    }

    public function testAddMemberWithBirthdayNotValidBefore()
    {
        $json = '{"message":"The given data was invalid.","errors":{"birthday"'.
            ':["The birthday must be a date before now."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testAddMemberWithBirthdayNotValidDateAfter()
    {
        $json = '{"message":"The given data was invalid.","errors":{"birthday"'.
            ':["The birthday must be a date after 60 year ago."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testAddMemberWithPositionEmpty()
    {
        $json = '{"message":"The given data was invalid.","errors":'.
            '{"position_id":["The position id field is required."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testAddMemberWithPositionNotValid()
    {
        $json = '{"message":"The given data was invalid.","errors":'.
            '{"position_id":["The position id must be an integer."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testAddMemberWithGenderEmpty()
    {
        $json = '{"message":"The given data was invalid.","errors":{"gender":'.
            '["The gender field is required."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testAddMemberWithGenderNotValid()
    {
        $json = '{"message":"The given data was invalid.","errors":'.
            '{"position_id":["The position id must be an integer."],"gender":'.
            '["The selected gender is invalid."]}}';
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
         $this->assertSame($json, $response->getContent());
    }

    public function testEditMemberWithNotValidName()
    {
        $json = '{"message":"The given data was invalid.","errors":'.
            '{"name":["The name format is invalid."]}}';
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
         $this->assertSame($json, $response->getContent());
    }

    public function testEditMemberWithNameMax50()
    {
        $json = '{"message":"The given data was invalid.","errors":{"name":'.
            '["The name format is invalid.","The name may not be greater than 50 characters."]}}';
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
         $this->assertSame($json, $response->getContent());
    }

    public function testEditMemberWithInformationMax300()
    {
        $json = '{"message":"The given data was invalid.","errors":'.
            '{"information":["The information may not be greater than 300 characters."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testEditMemberWithPhoneNumberNotValid()
    {
        $json = '{"message":"The given data was invalid.","errors":{"phone_number"'.
            ':["The phone number format is invalid."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testEditMemberWithPhoneNumberMax20()
    {
        $json = '{"message":"The given data was invalid.","errors":'.
            '{"phone_number":["The phone number may not be greater than 20 characters."]}}';
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
         $this->assertSame($json, $response->getContent());
    }

    public function testEditMemberWithBirthdayNotValidDate()
    {
        $json = '{"message":"The given data was invalid.","errors":{"birthday":'.
            '["The birthday is not a valid date.","The birthday must be a date before now."]}}';
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
         $this->assertSame($json, $response->getContent());
    }

    public function testEditMemberWithBirthdayNotValidBefore()
    {
        $json = '{"message":"The given data was invalid.","errors":{"birthday"'.
            ':["The birthday must be a date before now."]}}';
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
         $this->assertSame($json, $response->getContent());
    }

    public function testEditMemberWithBirthdayNotValidDateAfter()
    {
        $json = '{"message":"The given data was invalid.","errors":'.
            '{"birthday":["The birthday must be a date after 60 year ago."]}}';
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
        $this->assertSame($json, $response->getContent());
    }

    public function testEditMemberWithPositionNotValid()
    {
        $json = '{"message":"The given data was invalid.","errors":'.
            '{"position_id":["The position id must be an integer."]}}';
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
         $this->assertSame($json, $response->getContent());
    }

    public function testEditMemberWithGenderNotValid()
    {
        $json = '{"message":"The given data was invalid.","errors":'.
            '{"position_id":["The position id must be an integer."],"gender":'.
            '["The selected gender is invalid."]}}';
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
        $this->assertSame($json, $response->getContent());
    }
}
