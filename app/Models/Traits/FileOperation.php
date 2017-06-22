<?php 

namespace App\Models\Traits;

use App\Models\File;

trait FileOperation
{
    public static function createWithInput($data)
    {
        return File::create($data);
    }

    public function updateWithInput($data)
    {
        return $this->update($data);
    }
}
