<?php

namespace App;

use Illuminate\Database\Capsule\Manager as Capsule;

class Migration
{
    public static function run()
    {
        Capsule::schema()->dropIfExists('students'); // Drop child table first
        Capsule::schema()->dropIfExists('majors');   // Then drop parent table
        Capsule::schema()->dropIfExists('users');    // Independent table can be dropped anytime
        
        // Create users table
        Capsule::schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        // Create majors table
        Capsule::schema()->create('majors', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        // Create students table
        Capsule::schema()->create('students', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('address');
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth');
            $table->string('tahun_angkatan');
            $table->enum('semester', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]);
            $table->integer('major_id')->unsigned();
            $table->foreign('major_id')->references('id')->on('majors');
            $table->timestamps();
        });

        // Insert data into users table
        Capsule::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
        ]);

        // Insert data into majors table
        Capsule::table('majors')->insert([
            ['name' => 'Teknik Informatika'],
            ['name' => 'Sistem Informasi'],
            ['name' => 'Teknik Komputer'],
            ['name' => 'Teknik Elektro'],
            ['name' => 'Teknik Industri'],
            ['name' => 'Teknik Mesin'],
            ['name' => 'Teknik Sipil'],
            ['name' => 'Teknik Lingkungan'],
        ]);

        // Insert data into students table
        Capsule::table('students')->insert([
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'phone_number' => '081234567890',
                'address' => 'Jl. Example No. 123',
                'gender' => 'male',
                'date_of_birth' => '2000-01-01',
                'tahun_angkatan' => '2020',
                'semester' => '5',
                'major_id' => 1
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'phone_number' => '089876543210',
                'address' => 'Jl. Sample No. 456',
                'gender' => 'female',
                'date_of_birth' => '2001-05-15',
                'tahun_angkatan' => '2021',
                'semester' => '3',
                'major_id' => 2
            ],
            [
                'name' => 'Michael Johnson',
                'email' => 'michael.j@example.com',
                'phone_number' => '087654321098',
                'address' => 'Jl. Test No. 789',
                'gender' => 'male',
                'date_of_birth' => '1999-12-25',
                'tahun_angkatan' => '2019',
                'semester' => '7',
                'major_id' => 3
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah.w@example.com',
                'phone_number' => '082345678901',
                'address' => 'Jl. Demo No. 321',
                'gender' => 'female',
                'date_of_birth' => '2002-08-30',
                'tahun_angkatan' => '2022',
                'semester' => '1',
                'major_id' => 4
            ],
            [
                'name' => 'David Brown',
                'email' => 'david.b@example.com',
                'phone_number' => '081122334455',
                'address' => 'Jl. Merdeka No. 45',
                'gender' => 'male',
                'date_of_birth' => '2001-03-12',
                'tahun_angkatan' => '2021',
                'semester' => '3',
                'major_id' => 1
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.d@example.com',
                'phone_number' => '089988776655',
                'address' => 'Jl. Sudirman No. 78',
                'gender' => 'female',
                'date_of_birth' => '2000-07-22',
                'tahun_angkatan' => '2020',
                'semester' => '5',
                'major_id' => 1
            ],
            [
                'name' => 'Robert Taylor',
                'email' => 'robert.t@example.com',
                'phone_number' => '087711223344',
                'address' => 'Jl. Gatot Subroto No. 90',
                'gender' => 'male',
                'date_of_birth' => '2002-11-05',
                'tahun_angkatan' => '2022',
                'semester' => '1',
                'major_id' => 1
            ],
            [
                'name' => 'Lisa Anderson',
                'email' => 'lisa.a@example.com',
                'phone_number' => '082233445566',
                'address' => 'Jl. Thamrin No. 56',
                'gender' => 'female',
                'date_of_birth' => '1999-09-18',
                'tahun_angkatan' => '2019',
                'semester' => '7',
                'major_id' => 1
            ],
            [
                'name' => 'Kevin Martinez',
                'email' => 'kevin.m@example.com',
                'phone_number' => '081567890123',
                'address' => 'Jl. Asia Afrika No. 34',
                'gender' => 'male',
                'date_of_birth' => '2001-12-30',
                'tahun_angkatan' => '2021',
                'semester' => '3',
                'major_id' => 2
            ],
            [
                'name' => 'Amanda White',
                'email' => 'amanda.w@example.com',
                'phone_number' => '089123456789',
                'address' => 'Jl. Diponegoro No. 67',
                'gender' => 'female',
                'date_of_birth' => '2000-04-25',
                'tahun_angkatan' => '2020',
                'semester' => '5',
                'major_id' => 2
            ]
        ]);
    }
}