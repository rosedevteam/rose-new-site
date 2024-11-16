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
        //
        Permission::create(['name' => 'edit-posts']);
        Permission::create(['name' => 'create-posts']);
        Permission::create(['name' => 'delete-posts']);
        //
        Permission::create(['name' => 'edit-comments']);
        Permission::create(['name' => 'delete-comments']);
        //
        Permission::create(['name' => 'edit-products']);
        Permission::create(['name' => 'create-products']);
        Permission::create(['name' => 'delete-products']);
        //
        Permission::create(['name' => 'edit-billing']);

        $superAdmin = Role::create(['name' => 'super-admin']);
        $writer = Role::create(['name' => 'writer']);
        $customer = Role::create(['name' => 'customer']);

        $writer->givePermissionTo([
            'edit-dailyReports',
            'edit-posts',
            'create-posts',
            'delete-posts',
            'edit-products',
            'create-products',
            'delete-products',
        ]);

        User::factory()->create([
            'first_name' => 'admin',
            'password' => bcrypt('admin'),
            'phone' => '0123456789',
            'last_name' => 'admin',
            'email' => null,
            'birthday' => null,
            'avatar' => null,
        ]);

        User::all()->first()->assignRole($superAdmin);
    }
}
