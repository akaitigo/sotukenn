<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(StoreSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(JobSeeder::class);
        $this->call(ParttimerSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(MultiAuthTableSeeder::class);
        $this->call(EmployeeJobSeeder::class);
        $this->call(ParttimerJobSeeder::class);
        $this->call(ParttimerStatusSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(EmployeeStatusSeeder::class);
        $this->call(NoticeSeeder::class);
        $this->call(ShiftdividerSeeder::class);
        $this->call(InformationShareSeeder::class);
        $this->call(CompleteShiftSeeder::class);
        $this->call(NextdividerSeeder::class);
        $this->call(StaffShiftSeeder::class);
        $this->call(NeedShiftSeeder::class);
        $this->call(CommentSeeder::class);
    }
}
