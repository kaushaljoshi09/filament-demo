<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $adminUser = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        $roles = [
            'admin' => 'admin',
            'editor' => 'editor',
            'author' => 'author',
            'user' => 'user',
        ];

        foreach ($roles as $roleName => $roleSlug) {
            Role::create(['name' => $roleName]);
        }

        $permissions = [
            'View Posts',
            'Create Posts',
            'Edit Posts',
            'Delete Posts',
        ];

        foreach ($permissions as $permissionName ) {
            Permission::create(['name' => $permissionName]);
        }

        $user = User::factory()->create([
            'name' => 'John',
            'email' => 'john@example.com',
        ]);

        /**
         * Assign role admin to the user.
         * Reference: https://spatie.be/docs/laravel-permission/v6/basic-usage/role-permissions
         */

        $adminUser->assignRole('admin');
        $user->assignRole('user');

        $role = Role::findByName('user');
        $role->givePermissionTo('View Posts');
    }
}
