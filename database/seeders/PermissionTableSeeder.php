<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list', // 1
            'role-create', // 2
            'role-edit', // 3
            'role-delete', // 4
            'user-list', // 5
            'user-create', // 6
            'user-edit', // 7
            'user-delete', // 8
            'main_category-list', // 9
            'main_category-create', // 10
            'main_category-edit', // 11
            'main_category-delete', // 12
            'sub_category-list', // 13
            'sub_category-create', // 14
            'sub_category-edit', // 15
            'sub_category-delete', // 16
            'product-list', // 17
            'product-create', // 18
            'product-edit', // 19
            'product-delete', // 20
            'send_notification-send', // 21
            'middleman-list', // 22
            'middleman-add', // 23
            'payments-list', // 24 ( If this permission was activated , the user will be able to see all other users payments )
            'payments-create', // 25
            'payments-edit', // 26
            'payments-delete', // 27
            'withdraw-list', // 28
            'withdraw-create', // 29
            'withdraw-edit', // 30
            'withdraw-delete', // 31 (Refund)
            'settings-list', // 32 (Include edit - delete)
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
