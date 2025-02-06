<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profile::create([
            'user_id'=>User::find(1)->id,
            'name'=>User::find(1)->name,
        ]);
        Profile::create([
            'user_id'=>User::find(2)->id,
            'name'=>User::find(2)->name,
        ]);
        Profile::create([
            'user_id'=>User::find(3)->id,
            'name'=>User::find(3)->name,
        ]);
    }
}
