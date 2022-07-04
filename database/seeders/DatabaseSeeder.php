<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();

        DB::table('pegawai')->insert([
            [
                'jabatan' => 'Manager',
                'email' => 'manager@example.com',
                'password' => '$2y$10$KTkev82/qFEKJ1gs7h8RcO5qIEaKmu14oq./YqgRUil/WfABa/28i' // 12345678
            ],
            [
                'jabatan' => 'Administrator',
                'email' => 'administrator@example.com',
                'password' => '$2y$10$KTkev82/qFEKJ1gs7h8RcO5qIEaKmu14oq./YqgRUil/WfABa/28i' // 12345678
            ],
            [
                'jabatan' => 'Customer Service',
                'email' => 'customerservice@example.com',
                'password' => '$2y$10$KTkev82/qFEKJ1gs7h8RcO5qIEaKmu14oq./YqgRUil/WfABa/28i' // 12345678
            ]
        ]);

        DB::table('autoincrement')->insert([
            [
                'id' => 'pelanggan',
                'value' => 2
            ]
        ]);

        DB::table('pengemudi')->insert([
            'email' => 'pengemudi@example.com',
            'password' => '$2y$10$KTkev82/qFEKJ1gs7h8RcO5qIEaKmu14oq./YqgRUil/WfABa/28i' // 12345678
        ]);

        DB::table('pelanggan')->insert([
            'id' => 'CUS220628-1',
            'tanggal_lahir' => '2002-06-28',
            'email' => 'pelanggan@example.com',
            'password' => '$2y$10$KTkev82/qFEKJ1gs7h8RcO5qIEaKmu14oq./YqgRUil/WfABa/28i' // 12345678
        ]);
    }
}
