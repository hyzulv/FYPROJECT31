<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Staff;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        Admin::truncate();
        Staff::truncate();

        $users = [
            ['model' => Admin::class, 'name' => 'Admin User', 'username' => 'admin', 'email' => 'matrock.admin@gmail.com', 'password' => '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa', 'phone' => '+60 11-123 4567', 'status' => 'active'],
            ['model' => Staff::class, 'name' => 'Ahmad Faizal', 'username' => 'ahmad', 'email' => 'ahmad.faizal@gmail.com', 'password' => '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa', 'phone' => '+60 12-345 6789', 'status' => 'active'],
            ['model' => Staff::class, 'name' => 'Nurul Aisyah', 'username' => 'nurul', 'email' => 'nurul.aisyah@gmail.com', 'password' => '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa', 'phone' => '+60 13-456 7890', 'status' => 'active'],
            ['model' => Staff::class, 'name' => 'Raj Kumar', 'username' => 'raj', 'email' => 'raj.kumar@gmail.com', 'password' => '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa', 'phone' => '+60 14-567 8901', 'status' => 'active'],
            ['model' => Staff::class, 'name' => 'Lim Wei Jie', 'username' => 'lim', 'email' => 'lim.weijie@gmail.com', 'password' => '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa', 'phone' => '+60 16-678 9012', 'status' => 'active'],
            ['model' => Staff::class, 'name' => 'Sarah Tan', 'username' => 'sarah', 'email' => 'sarah.tan@gmail.com', 'password' => '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa', 'phone' => '+60 17-789 0123', 'status' => 'inactive'],
            ['model' => Staff::class, 'name' => 'Zulkifli Hassan', 'username' => 'zulkifli', 'email' => 'zulkifli.h@gmail.com', 'password' => '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa', 'phone' => '+60 18-890 1234', 'status' => 'active'],
            ['model' => Staff::class, 'name' => 'Farah Diana', 'username' => 'farah', 'email' => 'farah.diana@gmail.com', 'password' => '$2y$12$nshNMRB0RgxQMfSSuiFLKeQvG28MxgFMYflay7u/BJMjQAmKtN/pa', 'phone' => '+60 19-901 2345', 'status' => 'active'],
        ];

        foreach ($users as $user) {
            $model = $user['model'];
            unset($user['model']);
            $model::create($user);
        }
    }
}
