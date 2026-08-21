<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@kampus.ac.id'],
            [
                'name' => 'Administrator SiPinjam',
                'nim' => null,
                'prodi' => null,
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'mahasiswa@kampus.ac.id'],
            [
                'name' => 'Budi Santoso',
                'nim' => '23010001',
                'prodi' => 'Teknik Informatika',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
            ]
        );

        $categories = [
            ['name' => 'Elektronik', 'description' => 'Perangkat elektronik kampus.'],
            ['name' => 'Multimedia', 'description' => 'Peralatan foto, video, dan presentasi.'],
            ['name' => 'Laboratorium', 'description' => 'Peralatan untuk kegiatan praktikum.'],
            ['name' => 'Olahraga', 'description' => 'Peralatan kegiatan olahraga mahasiswa.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }

        $items = [
            ['category' => 'Elektronik', 'code' => 'ELK-001', 'name' => 'Proyektor Epson', 'stock' => 5, 'condition' => 'baik', 'description' => 'Proyektor untuk presentasi kelas dan kegiatan kampus.'],
            ['category' => 'Elektronik', 'code' => 'ELK-002', 'name' => 'Laptop Lenovo', 'stock' => 8, 'condition' => 'baik', 'description' => 'Laptop inventaris untuk kegiatan akademik.'],
            ['category' => 'Multimedia', 'code' => 'MM-001', 'name' => 'Kamera Canon', 'stock' => 3, 'condition' => 'baik', 'description' => 'Kamera dokumentasi kegiatan kampus.'],
            ['category' => 'Multimedia', 'code' => 'MM-002', 'name' => 'Tripod Kamera', 'stock' => 6, 'condition' => 'baik', 'description' => 'Tripod untuk kebutuhan dokumentasi.'],
            ['category' => 'Laboratorium', 'code' => 'LAB-001', 'name' => 'Arduino Uno', 'stock' => 20, 'condition' => 'baik', 'description' => 'Board mikrokontroler untuk praktikum.'],
            ['category' => 'Olahraga', 'code' => 'ORG-001', 'name' => 'Bola Futsal', 'stock' => 10, 'condition' => 'baik', 'description' => 'Bola futsal untuk kegiatan olahraga.'],
        ];

        foreach ($items as $data) {
            $category = Category::where('name', $data['category'])->first();

            Item::updateOrCreate(
                ['code' => $data['code']],
                [
                    'category_id' => $category->id,
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'stock' => $data['stock'],
                    'available_stock' => $data['stock'],
                    'condition' => $data['condition'],
                    'status' => 'available',
                ]
            );
        }
    }
}
