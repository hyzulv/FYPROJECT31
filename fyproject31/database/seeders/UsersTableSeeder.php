<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $users = [
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'email' => 'matrock.admin@gmail.com',
                'password' => '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa',
                'role' => 'admin',
                'phone' => '+60 11-123 4567',
                'status' => 'active',
            ],
            [
                'name' => 'Ahmad Faizal',
                'username' => 'ahmad',
                'email' => 'ahmad.faizal@gmail.com',
                'password' => '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa',
                'role' => 'staff',
                'phone' => '+60 12-345 6789',
                'status' => 'active',
            ],
            [
                'name' => 'Nurul Aisyah',
                'username' => 'nurul',
                'email' => 'nurul.aisyah@gmail.com',
                'password' => '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa',
                'role' => 'staff',
                'phone' => '+60 13-456 7890',
                'status' => 'active',
            ],
            [
                'name' => 'Raj Kumar',
                'username' => 'raj',
                'email' => 'raj.kumar@gmail.com',
                'password' => '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa',
                'role' => 'staff',
                'phone' => '+60 14-567 8901',
                'status' => 'active',
            ],
            [
                'name' => 'Lim Wei Jie',
                'username' => 'lim',
                'email' => 'lim.weijie@gmail.com',
                'password' => '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa',
                'role' => 'staff',
                'phone' => '+60 16-678 9012',
                'status' => 'active',
            ],
            [
                'name' => 'Sarah Tan',
                'username' => 'sarah',
                'email' => 'sarah.tan@gmail.com',
                'password' => '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa',
                'role' => 'staff',
                'phone' => '+60 17-789 0123',
                'status' => 'inactive',
            ],
            [
                'name' => 'Zulkifli Hassan',
                'username' => 'zulkifli',
                'email' => 'zulkifli.h@gmail.com',
                'password' => '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa',
                'role' => 'staff',
                'phone' => '+60 18-890 1234',
                'status' => 'active',
            ],
            [
                'name' => 'Farah Diana',
                'username' => 'farah',
                'email' => 'farah.diana@gmail.com',
                'password' => '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa',
                'role' => 'staff',
                'phone' => '+60 19-901 2345',
                'status' => 'active',
            ],
            [
                'name' => 'Ali',
                'username' => 'Ali',
                'email' => 'ali@staff.com',
                'password' => '$2y$12$UU8WpQrdj0lG4UQbiWdYUuhF.wmICeFn1.ubwdAAYEoI5kDOmD7xy',
                'role' => 'staff',
                'phone' => null,
                'status' => 'active',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
