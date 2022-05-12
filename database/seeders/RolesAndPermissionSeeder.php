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

          'manage_restorants',
          'restorant_create',
          'restorant_show',
          'restorant_edit',
          'restorant_delete',



        ];

        foreach ($permissions as $permission) {
          Permission::create([
            'name' => $permission,
          ]);
        }

        $role = Role::create(['name' => 'Guest']);

        $guestPermissions = [
          'restorant_create',

        ];

        foreach ($guestPermissions as $guestPermission) {
          $role->givePermissionTo($guestPermission);
        }

        $role = Role::create(['name' => 'Owner']);

        $ownerPermissions = [
          'restorant_show',
          'restorant_edit',
          'restorant_delete',

          'manage_categories',
          'manage_products'
        ];

        foreach ($ownerPermissions as $ownerPermission) {
          $role->givePermissionTo($ownerPermission);
        }




    }
}
