<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Database\Seeders\UserSeeder; // Added this line for UserSeeder

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);
        
        DB::table('news')->insert([
            'title' => 'Sample Berita 1',
            'content' => 'Ini adalah konten contoh untuk berita pertama.',
            'status' => true,
            'publish_date' => date('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('announcements')->insert([
            'title' => 'Pengumuman Penting!',
            'content' => 'Ini adalah pengumuman penting bagi seluruh staf.',
            'publish_date' => date('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
