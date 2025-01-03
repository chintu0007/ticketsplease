<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\CommonMark\Extension\CommonMark\Parser\Block\ThematicBreakStartParser;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(20)->create();

        Ticket::factory(100)
            ->recycle($users)
            ->create();

        User::create([
            'email'    => 'manager@manager.com',
            'password' => bcrypt('password'),
            'name'     => 'The Manager',
            'is_manager' => true
        ]);  
            
    }
}
