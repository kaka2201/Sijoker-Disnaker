<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inisialisasi Faker
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 100; $i++) {
            DB::table('profile')->insert([
                'user_id' => $i,  // Pastikan user_id sesuai dengan yang ada di tabel users
                'name' => $faker->name,
                'nik' => $faker->numerify('################'), // 16 digit random NIK
                'ttl' => $faker->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'),
                'gender' => $faker->randomElement(['pria', 'wanita']),
                'kecamatan' => $faker->city,
                'desa' => $faker->streetName,
                'jalan' => $faker->address,
                'pendidikan' => $faker->randomElement(['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2']),
                'nomor' => substr($faker->phoneNumber, 0, 15),
                'foto' => null, // Dapat diisi dengan path gambar jika diperlukan
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
