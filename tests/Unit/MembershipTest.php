<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\UsersAdmins;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * @group membership
 */
class MembershipTest extends TestCase
{
    use DatabaseMigrations;
    use UsersAdmins;

    public function test_create_new_membership_without_circle()
    {
        $user = $this->fetchUser();
        $faker = $this->fetchFaker();

        $data = [
            'type' => 'both',
            'begin' => $faker->date
        ];

        $membership = $user->memberships()->create($data);
        $membership = $user->memberships()->create($data);
        $membership = $user->memberships()->create($data);
        
        $this->assertDatabaseHas('memberships', [
            'user_id' => $user->id
        ]);

        $this->assertEquals(3, count($user->memberships));

        $this->assertEquals($user->id, $membership->user->id);
        $this->assertEquals($data['type'], $membership->type);
        $this->assertEquals($data['begin'], $membership->begin);
    }

    public function test_removing_user_removes_memberships()
    {
        $user = $this->fetchUser();
        $faker = $this->fetchFaker();

        $data = [
            'type' => 'both',
            'begin' => $faker->date
        ];

        $membership = $user->memberships()->create($data);

        $this->assertDatabaseHas('memberships', [
            'user_id' => $user->id
        ]);

        $user->delete();

        $this->assertDatabaseMissing('memberships', [
            'user_id' => $user->id
        ]);
    }

    public function test_attach_detach_language_to_membership()
    {
        $user = $this->fetchUser();
        $faker = $this->fetchFaker();

        $lang = factory(\App\Language::class)->create();
        $lang2 = factory(\App\Language::class)->create();

        $data = [
            'type' => 'both',
            'begin' => $faker->date
        ];

        $membership = $user->memberships()->create($data);

        $membership->languages()->attach($lang);
        $membership->languages()->attach($lang2);

        $this->assertDatabaseHas('language_membership', [
            'membership_id' => $membership->id
        ]);

        $this->assertDatabaseHas('language_membership', [
            'language_id' => $lang->id
        ]);

        $this->assertDatabaseHas('language_membership', [
            'language_id' => $lang2->id
        ]);

        $membership->languages()->detach();

        $this->assertDatabaseMissing('language_membership', [
            'membership_id' => $membership->id
        ]);
    }
}
