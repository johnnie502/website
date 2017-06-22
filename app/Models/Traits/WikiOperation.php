<?php 

namespace App\Models\Traits;

use App\Models\Wiki;

trait WikiOperation
{
    public static function createWithInput($data)
    {
        return Wiki::create($data);
    }

    public function updateWithInput($data)
    {
        return $this->update($data);
    }
}
