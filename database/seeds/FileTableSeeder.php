<?php

use Illuminate\Database\Seeder;
use App\Models\File;

class FileTableSeeder extends Seeder 
{
    public function run()
    {
        $files = factory(File::class)->times(50)->make()->each(function ($file, $index) {
            if ($index == 0) {
                // $file->field = 'value';
            }
        });

        File::insert($files->toArray());
    }

}

