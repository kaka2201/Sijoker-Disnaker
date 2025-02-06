<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'super_admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        $super = User::create([
            'name'=>'super',
            'email'=>'super@gmail.com',
            'password'=>Hash::make('12345678')
        ]);
        $super->assignRole('super_admin');
        $admin = User::create([
            'name'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('12345678')
        ]);
        $admin->assignRole('admin');
        $user = User::create([
            'name'=>'user',
            'email'=>'user@gmail.com',
            'password'=>Hash::make('12345678')
        ]);
        $user->assignRole('user');
    }
}
