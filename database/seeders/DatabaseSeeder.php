<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'delete-users']);
        //
        Permission::create(['name' => 'edit-dailyReports']);
        Permission::create(['name' => 'create-dailyReports']);
        Permission::create(['name' => 'delete-dailyReports']);
        //
        Permission::create(['name' => 'edit-posts']);
        Permission::create(['name' => 'create-posts']);
        Permission::create(['name' => 'delete-posts']);
        //
        Permission::create(['name' => 'edit-comments']);
        Permission::create(['name' => 'create-comments']);
        Permission::create(['name' => 'delete-comments']);
        //
        Permission::create(['name' => 'edit-products']);
        Permission::create(['name' => 'create-products']);
        Permission::create(['name' => 'delete-products']);

        $customer = Role::create(['name' => 'customer']);
        $admin = Role::create(['name' => 'admin']);
        $writer = Role::create(['name' => 'writer']);

        $admin->givePermissionTo(Permission::all());

        $writer->givePermissionTo([
            'edit-dailyReports',
            'delete-dailyReports',
            'edit-posts',
            'create-posts',
            'delete-posts',
            'edit-comments',
            'create-comments',
            'delete-comments',
            'edit-products',
            'create-products',
            'delete-products',
        ]);

        $user = User::factory()->create([
            'first_name' => 'admin',
            'password' => 'admin',
            'phone' => '0123456789',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'birthday' => '1990-01-01',
            'avatar' => 'avatar.png',
        ]);

        $user->assignRole($admin);
    }
}
