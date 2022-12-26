<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Orçun Candan',
            'email' => 'orcuncandan89@gmail.com',
            'email_verified_at' => now(),
            'role' => 'admin',
            'password' =>
                '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $orcBank = \App\Models\User::create([
            'name' => 'orcBank',
            'email' => 'orcbank@gmail.com',
            'email_verified_at' => now(),
            'role' => 'bank',
            'password' =>
                '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        foreach (config('app.currencies') as $currency) {
            $orcBank->accounts()->create([
                'name' => 'Kasa Nakit (' . $currency . ')',
                'slug' => 'kasaNakit' . $currency,
                'currency' => $currency,
                'balance' => 0,
            ]);
        }
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
