<?php

namespace Database\Seeders;

use App\Models\Constant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create Admin User
        // User::create([
        //     'name' => 'Alsaeyd J Alakhras',
        //     'email' => 'alsaeydjalkhras@gmail.com',
        //     'password'  => '20051118Jamal',
        //     'username'  => 'saeyd_jamal',
        //     'last_activity'  => now(),
        //     'avatar'  => null,
        //     'super_admin'  => 1,
        // ]);

        $constants = [
            'advance_payment_rate' => 10,
            'advance_payment_permanent' => 10,
            'advance_payment_non_permanent' => 10,
            'advance_payment_riyadh' => 10,
            'state_effectiveness' => 'فعال',
            'state_effectiveness' => 'شهيد',
            'termination_employee' => 5,
            'health_bachelor' => 900,
            'health_diploma' => 800,
            'health_secondary' => 700,
        ];
        foreach ($constants as $key => $value) {
            Constant::create([  
                'key' => $key,
                'value' => json_encode($value),
            ]);
        }
        
    }
}
