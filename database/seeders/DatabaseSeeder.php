<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user directly (without factory to avoid Faker dependency)
        if (!\App\Models\User::where('email', 'admin@example.com')->exists()) {
            \App\Models\User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        $this->call([
            BukuCategorySeeder::class,
            MemberSeeder::class,
            SubscriptionSeeder::class,
            PinjamanSeeder::class,
            PaymentsSeeder::class,
            WishlistSeeder::class,
            BookReviewSeeder::class,
            BookReservationSeeder::class,
            NotificationSeeder::class,
            ReportSeeder::class,
        ]);
    }
}