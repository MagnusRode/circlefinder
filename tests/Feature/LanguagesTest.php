<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\UsersAdmins;
use Illuminate\Support\Facades\Hash;

/**
 * @group languages
 */
class LanguagesTest extends TestCase
{
    use DatabaseMigrations;
    use UsersAdmins;

    public function test_guest_cannot_acess_languages()
    {
        $response = $this->get(route('admin.languages.index'));
        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');

        $response = $this->get(route('admin.languages.show', ['id' => 5]));
        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');

        $response = $this->get(route('admin.languages.create'));
        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');
        
        $response = $this->get(route('admin.languages.edit', ['id' => 5]));
        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');

        $response = $this->post(route('admin.languages.store'));
        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');

        $response = $this->put(route('admin.languages.update', ['id' => 5]));
        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');

        $response = $this->delete(route('admin.languages.destroy', ['id' => 5]));
        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');
    }

    public function test_get_languages_index()
    {
        $admin = $this->fetchAdmin();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.languages.index'));
        
        $response->assertStatus(200);
    }


    public function test_create_language()
    {
        $admin = $this->fetchAdmin();

        $response = $this->actingAs($admin, 'admin')
                         ->get(route('admin.languages.create'));

        $response->assertStatus(200);
    }

    public function test_show_language()
    {
        $admin = $this->fetchAdmin();
        $language = $this->fetchLanguage();

        $response = $this->actingAs($admin, 'admin')
                         ->get(route('admin.languages.show', ['id' => 5]));

        $response->assertStatus(404);

        $response = $this->actingAs($admin, 'admin')
                         ->get(route('admin.languages.show', ['id' => $language->id]));

        $response->assertStatus(200);
    }

    public function test_edit_language()
    {
        $admin = $this->fetchAdmin();
        $language = $this->fetchLanguage();

        $response = $this->actingAs($admin, 'admin')
                         ->get(route('admin.languages.edit', ['id' => 5]));

        $response->assertStatus(404);

        $response = $this->actingAs($admin, 'admin')
                         ->get(route('admin.languages.edit', ['id' => $language->id]));

        $response->assertStatus(200);
    }

    public function test_store_language()
    {
        $admin = $this->fetchAdmin();
        $faker = $this->fetchFaker();

        $new_code = $faker->languageCode;
        $new_title = "Language" . $new_code;

        $response = $this->actingAs($admin, 'admin')
                         ->post(route('admin.languages.store'), [
            'code' => $new_code,
            'title' => $new_title
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $language = \App\Language::where('code', $new_code)->get()->first();

        $this->assertEquals($language->title, $new_title);
    }


    public function test_update_language()
    {
        $admin = $this->fetchAdmin();
        $language = $this->fetchLanguage();
        $faker = $this->fetchFaker();

        $new_code = $faker->languageCode;
        $new_title = "Language" . $new_code;

        $response = $this->actingAs($admin, 'admin')
                         ->put(route('admin.languages.update', ['id' => $language->id]), [
            'code' => $new_code,
            'title' => $new_title
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $language = $this->fetchLanguage($language->id);

        $this->assertEquals($language->code, $new_code);           
        $this->assertEquals($language->title, $new_title);
    }
}
