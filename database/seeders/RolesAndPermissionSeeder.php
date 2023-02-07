<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
          'manage_users',

          'manage_categories',

          'manage_products',

          'manage_grocerys',
          'grocery_create',
          'grocery_show',
          'grocery_edit',
          'grocery_delete',



        ];

        foreach ($permissions as $permission) {
          Permission::create([
            'name' => $permission,
          ]);
        }

        $role = Role::create(['name' => 'Guest']);

        $guestPermissions = [
          'grocery_create',

        ];

        foreach ($guestPermissions as $guestPermission) {
          $role->givePermissionTo($guestPermission);
        }

        $role = Role::create(['name' => 'Owner']);

        $ownerPermissions = [
          'grocery_show',
          'grocery_edit',
          'grocery_delete',

          'manage_categories',
          'manage_products'
        ];

        foreach ($ownerPermissions as $ownerPermission) {
          $role->givePermissionTo($ownerPermission);
        }
        $role = Role::create(['name' => 'SuperAdmin']);

        $adminPermissions = [
          'grocery_create',

        ];

        foreach ($adminPermissions as $adminPermission) {
          $role->givePermissionTo($adminPermission);
        }




    }
}
