<?php

namespace Tests\Feature;

use App\Filament\Pages\Auth\Login;
use App\Filament\Resources\UserResource\Pages\ManageUsers;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CmsUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_the_cms_users_module(): void
    {
        $this->seed();

        $admin = User::query()->where('email', 'admin@byphealthtek.com')->first();

        $this->actingAs($admin)
            ->get('/admin/users')
            ->assertOk()
            ->assertSee('CMS users');
    }

    public function test_admin_can_create_another_cms_admin_from_the_users_module(): void
    {
        $this->seed();

        $admin = User::query()->where('email', 'admin@byphealthtek.com')->first();
        $adminRoleId = Role::findByName('admin')->getKey();

        Livewire::actingAs($admin)
            ->test(ManageUsers::class)
            ->callAction('create', [
                'name' => 'Second Admin',
                'email' => 'second.admin@byphealthtek.com',
                'password' => 'password',
                'roles' => [$adminRoleId],
            ])
            ->assertHasNoActionErrors();

        $colleague = User::query()->where('email', 'second.admin@byphealthtek.com')->first();

        $this->assertNotNull($colleague);
        $this->assertTrue($colleague->hasRole('admin'));
    }

    public function test_a_newly_added_admin_can_sign_in_to_the_cms(): void
    {
        $this->seed();

        $colleague = User::factory()->create([
            'email' => 'cms.admin@byphealthtek.com',
            'password' => 'password',
        ]);
        $colleague->assignRole('admin');

        Livewire::test(Login::class)
            ->fillForm([
                'email' => 'cms.admin@byphealthtek.com',
                'password' => 'password',
            ])
            ->call('authenticate')
            ->assertHasNoErrors()
            ->assertRedirect('/admin');
    }

    public function test_user_without_a_cms_role_cannot_sign_in_to_the_cms(): void
    {
        $this->seed();

        $user = User::factory()->create([
            'email' => 'visitor@byphealthtek.com',
            'password' => 'password',
        ]);

        Livewire::test(Login::class)
            ->fillForm([
                'email' => $user->email,
                'password' => 'password',
            ])
            ->call('authenticate')
            ->assertHasErrors(['data.email']);
    }

    public function test_editor_cannot_open_the_cms_users_module(): void
    {
        $this->seed();

        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $this->actingAs($editor)
            ->get('/admin/pages')
            ->assertOk();

        $this->actingAs($editor)
            ->get('/admin/users')
            ->assertForbidden();
    }

    public function test_user_without_a_cms_role_cannot_open_the_admin_panel(): void
    {
        $this->seed();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin')
            ->assertForbidden();
    }
}
