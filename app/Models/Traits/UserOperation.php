<?php 

namespace App\Models\Traits;

use App\Models\User;

trait UserOperation
{
    public static function createWithInput($data)
    {
        return User::create($data);
    }

    public function updateWithInput($data)
    {
        return $this->update($data);
    }
}
