<?php 

namespace App\Models\Traits;

use App\Models\Node;

trait NodeOperation
{
    public static function createWithInput($data)
    {
        return Node::create($data);
    }

    public function updateWithInput($data)
    {
        return $this->update($data);
    }
}
