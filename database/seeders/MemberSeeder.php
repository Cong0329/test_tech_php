<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i <5 ; $i++) { 
            DB::table('members')->insert([
                'name' => Str::random(10),
                'email' => Str::random(10).'@example.com',
                'phone' => $this->generateRandomPhoneNumber(),
            ]);
            # code...
        }
    }

    private function generateRandomPhoneNumber()
    {
        return '0' . rand(100000000, 999999999);
    }
}
