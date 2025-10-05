<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'notification_switch' => true,
                'phone_number' => '+1234567890',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'notification_switch' => true,
                'phone_number' => '+1987654321',
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'password' => Hash::make('password'),
                'notification_switch' => false,
                'phone_number' => null,
            ],
            [
                'name' => 'Alice Brown',
                'email' => 'alice@example.com',
                'password' => Hash::make('password'),
                'notification_switch' => true,
                'phone_number' => '+1555123456',
            ],
            [
                'name' => 'Charlie Wilson',
                'email' => 'charlie@example.com',
                'password' => Hash::make('password'),
                'notification_switch' => true,
                'phone_number' => '+1444987654',
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // Get all users for creating notifications
        $allUsers = User::all();

        // Create sample notifications
        $notifications = [
            [
                'type' => 'system',
                'text' => 'Welcome to RIN2! Your account has been successfully created.',
                'expires_at' => now()->addDays(30),
                'is_for_all' => true,
                'user_id' => null,
            ],
            [
                'type' => 'marketing',
                'text' => 'Check out our new features! We\'ve added some exciting updates to improve your experience.',
                'expires_at' => now()->addDays(7),
                'is_for_all' => true,
                'user_id' => null,
            ],
            [
                'type' => 'invoices',
                'text' => 'Your monthly invoice is ready for review. Please check your billing section.',
                'expires_at' => now()->addDays(14),
                'is_for_all' => false,
                'user_id' => $allUsers->first()->id,
            ],
            [
                'type' => 'system',
                'text' => 'Scheduled maintenance will occur tonight from 2 AM to 4 AM EST.',
                'expires_at' => now()->addDays(1),
                'is_for_all' => true,
                'user_id' => null,
            ],
            [
                'type' => 'marketing',
                'text' => 'Special offer: 20% off premium features for the next 48 hours!',
                'expires_at' => now()->addDays(2),
                'is_for_all' => true,
                'user_id' => null,
            ],
            [
                'type' => 'invoices',
                'text' => 'Payment reminder: Your subscription will renew in 3 days.',
                'expires_at' => now()->addDays(5),
                'is_for_all' => false,
                'user_id' => $allUsers->skip(1)->first()->id,
            ],
            [
                'type' => 'system',
                'text' => 'Security update: Please change your password if you haven\'t done so recently.',
                'expires_at' => now()->addDays(10),
                'is_for_all' => true,
                'user_id' => null,
            ],
            [
                'type' => 'marketing',
                'text' => 'New tutorial available: Learn how to maximize your productivity with our latest tools.',
                'expires_at' => now()->addDays(21),
                'is_for_all' => true,
                'user_id' => null,
            ],
        ];

        foreach ($notifications as $notificationData) {
            Notification::create($notificationData);
        }

        // Mark some notifications as read by some users (simulate real usage)
        $notifications = Notification::all();
        $users = User::all();

        // Mark first notification as read by first two users
        if ($notifications->count() > 0 && $users->count() >= 2) {
            $firstNotification = $notifications->first();
            $firstNotification->readByUsers()->attach([
                $users->first()->id => ['read_at' => now()->subHours(2)],
                $users->skip(1)->first()->id => ['read_at' => now()->subHours(1)],
            ]);
        }

        // Mark second notification as read by one user
        if ($notifications->count() > 1 && $users->count() >= 1) {
            $secondNotification = $notifications->skip(1)->first();
            $secondNotification->readByUsers()->attach([
                $users->first()->id => ['read_at' => now()->subMinutes(30)],
            ]);
        }

        $this->command->info('Sample users and notifications created successfully!');
        $this->command->info('Test users created:');
        foreach ($users as $user) {
            $this->command->info("- {$user->name} ({$user->email}) - Notifications: " . ($user->notification_switch ? 'ON' : 'OFF'));
        }
    }
}
