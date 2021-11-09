<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Ahmed khan',
            'username' => 'developer_man',
            'email' => 'creativeband@hotmail.com',
            'password' => bcrypt('123456'),
            'balance' => 1250,
            'mobile' => '+966509735559',
            'roles_name' => ['Owner'],
            'status' => 1
        ]);

        $user2 = User::create([
            'name' => 'Vendor store',
            'username' => 'vendor',
            'email' => 'vendor@i3tmd.com',
            'password' => bcrypt('123456'),
            'balance' => 100,
            'mobile' => '+966509735512',
            'roles_name' => ['Owner'],
            'status' => 1
        ]);

        $user3 = User::create([
            'name' => 'Yassir',
            'username' => 'middleman',
            'email' => 'info@i3tmd.com',
            'password' => bcrypt('123456'),
            'balance' => 500,
            'mobile' => '+966509735551',
            'roles_name' => ['Owner'],
            'status' => 1
        ]);

        $role = Role::create(['name' => 'Owner']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);


        $user->assignRole([$role->id]);
        $user2->assignRole([$role->id]);
        $user3->assignRole([$role->id]);

    }
}
