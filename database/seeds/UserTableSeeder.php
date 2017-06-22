<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder 
{
    public function run()
    {
        $users = factory(User::class)->times(50)->make()->each(function ($user, $index) {
            if ($index == 0) {
                // $user->field = 'value';
            }
        });

        User::insert($users->toArray());
    }

}

