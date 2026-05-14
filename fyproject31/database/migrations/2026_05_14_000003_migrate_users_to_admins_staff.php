<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            $table = $user->role === 'admin' ? 'admins' : 'staff';
            DB::table($table)->insert([
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'password' => $user->password,
                'phone' => $user->phone,
                'status' => $user->status ?? 'active',
                'remember_token' => $user->remember_token,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]);
        }

        Schema::dropIfExists('users');
    }

    public function down(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->rememberToken();
            $table->timestamps();
        });

        $admins = DB::table('admins')->get();
        foreach ($admins as $admin) {
            DB::table('users')->insert([
                'name' => $admin->name,
                'username' => $admin->username,
                'email' => $admin->email,
                'password' => $admin->password,
                'phone' => $admin->phone,
                'status' => $admin->status,
                'role' => 'admin',
                'remember_token' => $admin->remember_token,
                'created_at' => $admin->created_at,
                'updated_at' => $admin->updated_at,
            ]);
        }

        $staff = DB::table('staff')->get();
        foreach ($staff as $s) {
            DB::table('users')->insert([
                'name' => $s->name,
                'username' => $s->username,
                'email' => $s->email,
                'password' => $s->password,
                'phone' => $s->phone,
                'status' => $s->status,
                'role' => 'staff',
                'remember_token' => $s->remember_token,
                'created_at' => $s->created_at,
                'updated_at' => $s->updated_at,
            ]);
        }
    }
};
