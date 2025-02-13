<?php

namespace Database\Seeders;

use App\Models\MoveClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MoveClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            'physical',
            'special',
            'status',
        ];

        foreach ($classes as $class) {
            MoveClass::create(['name' => $class]);
        }
    }
}
