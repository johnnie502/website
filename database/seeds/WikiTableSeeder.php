<?php

use Illuminate\Database\Seeder;
use App\Models\Wiki;

class WikiTableSeeder extends Seeder 
{
    public function run()
    {
        $wikis = factory(Wiki::class)->times(50)->make()->each(function ($wiki, $index) {
            if ($index == 0) {
                // $wiki->field = 'value';
            }
        });

        Wiki::insert($wikis->toArray());
    }

}

