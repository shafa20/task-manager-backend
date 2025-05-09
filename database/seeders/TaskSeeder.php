<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['Pending', 'Completed'];
        for ($i = 1; $i <= 100; $i++) {
            Task::create([
                'name' => 'Sample Task ' . $i,
                'description' => 'This is a sample description for task #' . $i,
                'status' => $statuses[array_rand($statuses)],
            ]);
        }
    }
}
